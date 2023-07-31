<?php
class Account {
    private $id;
    private $name;
    private $authenticated;
	
    public function __construct() {
        $this->id = NULL;
	$this->name = NULL;
	$this->authenticated = FALSE;
    }
	
    public function __destruct() {}
	
    public function getId(): ?int {return $this->id;}
    public function getName(): ?string {return $this->name;}
    public function isAuthenticated(): bool {return $this->authenticated;}
    
    public function getUserData(int $userId = null) {
        if(empty($userId)) {$userId = $this->id;}
        if (!$this->isIdValid($userId))         {throw new Exception('Invalid account ID');}
		
		global $pdo;	
        $query = 'SELECT account_id, account_name, account_realname, account_lastlogin, account_type, account_enabled, account_email, linked_crew, linked_customer FROM '.DB.'.accounts WHERE (account_id = :id)';
	$values = array(':id' => $userId);
		
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Database query error');}
        
        $row = $res->fetch(PDO::FETCH_OBJ);
        
        return $row;
    }

    public function getAllUsers() {
	global $pdo;	
        $query = 'SELECT account_id, account_name, account_realname, account_lastlogin, account_type, account_enabled, account_email, linked_crew, linked_customer FROM '.DB.'.accounts';
		
        try {
            $res = $pdo->prepare($query);
            $res->execute();
	}
	catch (PDOException $e) {throw new Exception('Database query error');}
        
        $row = $res->fetchAll(PDO::FETCH_OBJ);
        
        return $row;
    }
    
    public function addAccount(string $name, string $realname, string $email, string $type = null, int $active): int {
    
	global $pdo;	
	$name = trim($name);
	$realname = trim($realname);
	$email = trim($email);
	$passwd = $this->generatePassword();
	
	if (!$this->isNameValid($name)) {throw new Exception('Gebruikersnaam voldoet niet aan de eisen');}
	if (!$this->isPasswdValid($passwd)) {throw new Exception('Wachtwoord voldoet niet aan de eisen');}
	if (!is_null($this->getIdFromName($name))) {throw new Exception('Deze gebruikersnaam is al in gebruik');}
	if (empty($email)) {throw new Exception('Er is geen emailadres ingevoerd');}
		
	$query = 'INSERT INTO '.DB.'.accounts (account_name, account_realname, account_email, account_passwd, account_type, account_enabled) VALUES (:name, :realname, :email, :passwd, :type, :enabled)';
	$hash = password_hash($passwd, PASSWORD_DEFAULT);
	$values = array(':name' => $name, ':realname' => $realname, ':email' => $email, ':passwd' => $hash, ':type' => $type, ':enabled' => $active);

        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens het uploaden van de data naar de database'. $e);}

$subject = "Je inloggegevens voor EventSolutions";

$message = "
Van harte welkom!<br><br>
Hierbij sturen we je graag je toegangsgegevens voor onze online omgeving.<br><br>
Je kunt hiermee inloggen via <a href=\"https://accounts.eventsolutions.nu\">deze link</a>.<br><br>
Gebruikersnaam: ".$name."<br>
Wachtwoord: ".$passwd."<br><br>
We raden je sterk aan om je wachtwoord na de eerste keer inloggen te wijzigen.<br><br>
Met vriendelijke groet,<br>
Het team van EventSolutions
";

$sendMail = sendMail::sendit($email, $subject, $message);

        return $pdo->lastInsertId();
		
		
    }
	
    public function deleteAccount(int $id) {
        global $pdo;

        if (!$this->isIdValid($id)) {
            throw new Exception('Invalid account ID');
	}
		
	$query = 'DELETE FROM '.DB.'.accounts WHERE (account_id = :id)';
        $values = array(':id' => $id);
		
	try {
            $res = $pdo->prepare($query);
            $res->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Database query error');}
		
	$query = 'DELETE FROM '.DB.'.account_sessions WHERE (account_id = :id)';
	$values = array(':id' => $id);
	
	try {
            $res = $pdo->prepare($query);
            $res->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Database query error');}
        
        return 'success';
    }
	
    public function editAccount(int $id, string $name, string $realname, string $email, bool $enabled) {
	global $pdo;
		
	$name = trim($name);
		
	if (!$this->isIdValid($id))         {throw new Exception('Invalid account ID');}
	if (!$this->isNameValid($name))     {throw new Exception('Invalid user name');}
		
	$idFromName = $this->getIdFromName($name);
	if (!is_null($idFromName) && ($idFromName != $id)) {throw new Exception('User name already used');}
		
	$query = 'UPDATE '.DB.'.accounts SET account_name = :name, account_realname = :realname, account_email = :email, account_enabled = :enabled, account_lastedit = NOW() WHERE account_id = :id';
	$intEnabled = $enabled ? 1 : 0;
	$values = array(':name' => $name, ':realname' => $realname, ':email' => $email, ':enabled' => $intEnabled, ':id' => $id);
	
        try {
            $res = $pdo->prepare($query);
            $result = $res->execute($values);
			
			return $result;
	}
	catch (PDOException $e) {throw new Exception('Database query error');}
    }
	
	public function editPassword(int $id, string $passwd, string $passwdNew, string $passwdVal) {
	global $pdo;
		
	$passwd = trim($passwd);
	$passwdNew = trim($passwdNew);
	$passwdVal = trim($passwdVal);
		
	if (!$this->isIdValid($id))         {throw new Exception('Het account waarvoor je het wachtwoord probeert te wijzigen, bestaat niet');}
	if (!$this->isPasswdValid($passwdNew)) {throw new Exception('Je nieuwe wachtwoord voldoet niet aan alle eisen');}
	if ($passwdNew != $passwdVal) 		{throw new Exception('De nieuwe wachtwoorden komen niet overeen');}
		
	$query = 'UPDATE '.DB.'.accounts SET account_passwd = :passwd WHERE account_id = :id';
	$hash = password_hash($passwdNew, PASSWORD_DEFAULT);
	$values = array(':passwd' => $hash, ':id' => $id);
	
        try {
            $res = $pdo->prepare($query);
            $result = $res->execute($values);
			
			return $result;
	}
	catch (PDOException $e) {throw new Exception('Database query error');}
    }
    
    	public function renewPassword(string $username) {
	global $pdo;

        $id = $this->getIdFromName($username);
        
        if(empty($id)) {throw new Exception('Deze gebruikersnaam komt niet voor in het systeem');}
        
        $passwd = $this->generatePassword();
        $email = $this->getUserData($id);
		
	$query = 'UPDATE '.DB.'.accounts SET account_passwd = :passwd WHERE account_id = :id';
	
        $hash = password_hash($passwd, PASSWORD_DEFAULT);
	$values = array(':passwd' => $hash, ':id' => $id);
	
        try {
            $res = $pdo->prepare($query);
            $result = $res->execute($values);
            
            $subject = "Je nieuwe wachtwoord";

            $message = "
                Het kan de beste overkomen...<br><br>
                Hierbij ontvang je je nieuwe wachtwoord voor onze online omgeving:<br>
                Je kunt hiermee inloggen via <a href=\"https://accounts.eventsolutions.nu\">deze link</a>.<br><br>
                Gebruikersnaam: ".$username."<br>
                Wachtwoord: ".$passwd."<br><br>
                We raden je sterk aan om je wachtwoord na het inloggen te wijzigen.<br><br>
                Met vriendelijke groet,<br>
                Het team van EventSolutions
            ";
            $sendMail = sendMail::sendit($email->account_email, $subject, $message, $attach = '');
	}
	catch (PDOException $e) {throw new Exception('Database query error');}
    
        return $id . $result;
        }
	
    public function login(string $name, string $passwd): bool {
	global $pdo;
		
	$name = trim($name);
	$passwd = trim($passwd);
		
	if (!$this->isNameValid($name)) {return FALSE;}
	if (!$this->isPasswdValid($passwd)) {return FALSE;}
		
	$query = 'SELECT * FROM '.DB.'.accounts WHERE (account_name = :name) AND (account_enabled = 1)';
	$values = array(':name' => $name);
		
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Database query error');}
	
        $row = $res->fetch(PDO::FETCH_ASSOC);
	
        if (is_array($row)) {
            if (password_verify($passwd, $row['account_passwd'])) {
		$this->id = intval($row['account_id'], 10);
		$this->name = $name;
		$this->authenticated = TRUE;
		$this->registerLoginSession();
		return TRUE;
            }
	}
	return FALSE;
    }
	
    public function isNameValid(string $name): bool {
        $valid = TRUE;
	$len = mb_strlen($name);
		
	if (($len < 5) || ($len > 52)) {$valid = FALSE;}

        return $valid;
    }
	
    public function isPasswdValid(string $passwd): bool {
        $valid = TRUE;
	$len = mb_strlen($passwd);
		
	if (($len < 8) || ($len > 25)) {$valid = FALSE;}

        return $valid;
    }
	
    public function isIdValid(int $id): bool {
        $valid = TRUE;
			
	if (($id < 1) || ($id > 1000000)) {$valid = FALSE;}
		
        return $valid;
    }
	
    public function sessionLogin(): bool {
        global $pdo;
    
        if (session_status() == PHP_SESSION_ACTIVE) {
            $query = 
                'SELECT * FROM '.DB.'.account_sessions, '.DB.'.accounts WHERE (account_sessions.session_id = :sid) ' . 
                'AND (account_sessions.login_time >= (NOW() - INTERVAL 7 DAY)) AND (account_sessions.account_id = accounts.account_id) ' . 
                'AND (accounts.account_enabled = 1)';		
            $values = array(':sid' => session_id());
			
            try {
                $res = $pdo->prepare($query);
                $res->execute($values);
            }
            catch (PDOException $e) {throw new Exception('Database query error');}
			
            $row = $res->fetch(PDO::FETCH_ASSOC);
			
            if (is_array($row)) {
                $this->id = intval($row['account_id'], 10);
                $this->name = $row['account_name'];
                $this->authenticated = TRUE;
                return TRUE;
            }
        }
	return FALSE;
    }
	
    public function logout() {
        global $pdo;
		
	$this->id = NULL;
	$this->name = NULL;
	$this->authenticated = FALSE;
		
	if (session_status() == PHP_SESSION_ACTIVE) {
            $sessionId = session_id();
            $query = 'DELETE FROM '.DB.'.account_sessions WHERE (session_id = :sid)';
            $values = array(':sid' => $sessionId);
			
            try {
		$res = $pdo->prepare($query);
		$res->execute($values);
            }
            catch (PDOException $e) {throw new Exception('Database query error');}
        }
    }
	
    public function closeOtherSessions() {
	global $pdo;
    	
        if (is_null($this->id)) {return;}
		
	if (session_status() == PHP_SESSION_ACTIVE) {
            $query = 'DELETE FROM '.DB.'.account_sessions WHERE (session_id != :sid) AND (account_id = :account_id)';
            $values = array(':sid' => session_id(), ':account_id' => $this->id);
			
            try {
                $res = $pdo->prepare($query);
		$res->execute($values);
            }
            catch (PDOException $e) {throw new Exception('Database query error');}
	}
    }
	
    public function getIdFromName(string $name): ?int {
        global $pdo;
		
	if (!$this->isNameValid($name)) {throw new Exception('Deze gebruikersnaam komt niet voor in ons systeem');}
        
        $id = NULL;
	
	$query = 'SELECT account_id FROM '.DB.'.accounts WHERE (account_name = :name)';
	$values = array(':name' => $name);
		
	try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        }
	catch (PDOException $e) {throw new Exception('Database query error');}
		
	$row = $res->fetch(PDO::FETCH_ASSOC);
	
	if (is_array($row)) {$id = intval($row['account_id'], 10);}
	
        return $id;
    }
		
    private function registerLoginSession() {
	global $pdo;
		
	if (session_status() == PHP_SESSION_ACTIVE) {
            $query = 'REPLACE INTO '.DB.'.account_sessions (session_id, account_id, login_time) VALUES (:sid, :accountId, NOW())';
            $values = array(':sid' => session_id(), ':accountId' => $this->id);
			
            try {
		$res = $pdo->prepare($query);
		$res->execute($values);
            }
            catch (PDOException $e) {throw new Exception('Database query error');} 
            
            $query = 'UPDATE '.DB.'.accounts SET account_lastlogin = NOW() WHERE account_id = :accountId';
            $values = array(':accountId' => $this->id);
			
            try {
		$res = $pdo->prepare($query);
		$res->execute($values);
            }
            catch (PDOException $e) {throw new Exception('Database query error aaaa');
            } 
	}
    }
	
	public static function generatePassword($length = 10, $add_dashes = false, $available_sets = 'luds') {
	$sets = array();
        if(strpos($available_sets, 'l') !== false) {$sets[] = 'abcdefghjkmnpqrstuvwxyz';}
        if(strpos($available_sets, 'u') !== false) {$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';}
        if(strpos($available_sets, 'd') !== false) {$sets[] = '23456789';}
        if(strpos($available_sets, 's') !== false) {$sets[] = '!@#$%&*?';}

	$all = '';
	$password = '';
	foreach($sets as $set)
	{
		$password .= $set[array_rand(str_split($set))];
		$all .= $set;
	}

	$all = str_split($all);
	for($i = 0; $i < $length - count($sets); $i++)
		$password .= $all[array_rand($all)];

	$password = str_shuffle($password);

	if(!$add_dashes)
		return $password;

	$dash_len = floor(sqrt($length));
	$dash_str = '';
	while(strlen($password) > $dash_len)
	{
		$dash_str .= substr($password, 0, $dash_len) . '-';
		$password = substr($password, $dash_len);
	}
	$dash_str .= $password;
	return $dash_str;
}
}

 
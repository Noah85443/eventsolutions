<?php
class betalingen {	
    
    static public function maakCode() {
        $betaalcode = account::generatePassword(25, true, 'lud');
        return $betaalcode;
    }
    
    static public function factuurData($betaalcode) {
         global $pdo;	

        $query = 'SELECT * FROM '.DB.'.facturen WHERE (betaalcode = :betaalcode)';
            $values = array(':betaalcode' => $betaalcode);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens ophalen van de gegevens');}
        
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        
        return $row;
    }
}
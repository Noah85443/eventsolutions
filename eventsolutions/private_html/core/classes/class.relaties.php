<?php
class relaties {	
   
        public static function alleRelaties() {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.relaties ORDER BY klant_naam ASC';
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute();
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens ophalen van de gegevens');}
        
        $dataset = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        return $dataset;
    }
    
    public static function perRelatie(int $id) {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.relaties WHERE (id = :id)';
            $values = array(':id' => $id);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Er is geen relatie gevonden voor dit ID');}
        
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        
        return $row;
    }
    
    
    public static function nieuweRelatie(array $dataset) {
        if(empty($dataset)) {throw new Exception('Geen data om te verwerken');}
        
        if($dataset["klant_type"] == "bedrijf") {
            $bedrijfsnaam = $dataset["klant_naam"];
            $naam = explode(" ", $dataset["factuur_tav"]);
            $voornaam = $naam[0];
            $achternaam = $naam[1];
        }
        elseif($dataset["klant_type"] == "consument") {
            $bedrijfsnaam = '';
            $naam = explode(" ", $dataset["klant_naam"]);
            $voornaam = $naam[0];
            $achternaam = $naam[1];
        }
        
        $moneybird = new moneybird();
        $moneybirdId = $moneybird->createNewContact($bedrijfsnaam,$voornaam,$achternaam);
        
        $dataset['moneybirdId'] = $moneybirdId->id;
        
        $action = DB::insertFromForm(DB.'.relaties', $dataset);
        
        self::maakKoppelcode($action);

        return $action;
    }
    
    public static function bewerkRelatie(array $dataset, int $id) {
        if(empty($dataset)) {throw new Exception('Geen data om te verwerken');}
        
        $action = DB::updateFromForm(DB.'.relaties', $dataset, $id);
        
        if($dataset["klant_type"] == "bedrijf") {
            $bedrijfsnaam = $dataset["klant_naam"];
            $naam = explode(" ", $dataset["factuur_tav"]);
            $voornaam = $naam[0];
            $achternaam = $naam[1];
        }
        elseif($dataset["klant_type"] == "consument") {
            $bedrijfsnaam = '';
            $naam = explode(" ", $dataset["klant_naam"]);
            $voornaam = $naam[0];
            $achternaam = $naam[1];
        }
        
        $moneybird = new moneybird();
        $moneybird->editContact($dataset['moneybirdId'], $bedrijfsnaam, $voornaam, $achternaam);
        
        return $action;
    }
    
    public static function cpPerRelatie(int $id) {
        if(empty($id)) {throw new Exception('Geen relatie gespecificeerd. Taak afgebroken.');}
        
        global $pdo;
        
        $query = 'SELECT * from '.DB.'.accounts WHERE (linked_customer = :id) ORDER BY account_realname ASC';
        $values = array(':id' => $id);
        
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Geen gegevens gevonden voor deze opdracht.');}
        
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        return $data;
        
    }
    
    public static function maakKoppelcode($id) {
        $n = 10;
        $koppelcode = bin2hex(random_bytes($n));
        
        global $pdo;	

        $query = 'UPDATE '.DB.'.relaties SET koppelcode = :koppelcode WHERE id = :id';
        $values = array(':koppelcode' => $koppelcode, ':id' => $id);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens toewijzen koppelcode: '.$e->getMessage());}
                
        return $koppelcode;
    }
    
    public static function koppelAccount($userId, $koppelcode) {
        global $pdo;
        
        $query = 'SELECT id, koppelcode, klant_naam from '.DB.'.relaties WHERE (koppelcode = :koppelcode) LIMIT 1';
        $values = array(':koppelcode' => $koppelcode);
        
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Geen gegevens gevonden voor deze opdracht.');}
        
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        $company = $data->id;
        
        $query = 'UPDATE '.DB.'.accounts SET linked_customer = :linked_customer WHERE account_id = :id';
        $values = array(':linked_customer' => $company, ':id' => $userId);
        
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens koppelen account');}
        
        return $data->klant_naam;
    }
}
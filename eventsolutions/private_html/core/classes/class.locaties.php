<?php
class locaties {	
   
        public static function alleLocaties() {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.locaties ORDER BY locatieNaam ASC';
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute();
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens ophalen van de gegevens');}
        
        $dataset = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        return $dataset;
    }
    
    public static function perLocatie($locatieData) {
        
        if(is_numeric($locatieData)) {$locatieId = $locatieData;}
        else {
            $dataset = json_decode($locatieData, true);
            
            if($dataset['locatieId'] == 0) {
                return (object) $dataset;
            }
            else {
                $locatieId = $dataset['locatieId'];
            }
        }
            
        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.locaties WHERE (id = :id)';
            $values = array(':id' => $locatieId);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Er is geen locatie gevonden voor dit ID');}
        
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        
        return $row;
    }
    
        public static function perKlant(int $statusId) {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.projecten WHERE (status = :statusId) AND (toonProject = 1)';
            $values = array(':statusId' => $statusId);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Database query error');}
        
        $row = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        return $row;
    }
    
    public static function nieuweLocatie(array $dataset) {
        if(empty($dataset)) {throw new Exception('Geen data om te verwerken');}
        
        $action = DB::insertFromForm(DB.'.locaties', $dataset);	
        
        return $action;
    }
    
     public static function bewerkLocatie(array $dataset, int $id) {
        if(empty($dataset)) {throw new Exception('Geen data om te verwerken');}
        
        $action = DB::updateFromForm(DB.'.locaties', $dataset, $id);
        
        return $action;
    }
}
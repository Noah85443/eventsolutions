<?php
class crewMembers {	
   
    public static function newCrew(array $dataset) {
        if(empty($dataset)) {throw new Exception('Geen data om te verwerken');}
        
        $action = DB::insertFromForm(DB.'.crew_medewerkers', $dataset);	
        
        return $action;
    }
    
    public static function getCrew(int $id) {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.crew_medewerkers WHERE (id = :id)';
            $values = array(':id' => $id);
		
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Database query error');}
        
        $row = $res->fetch(PDO::FETCH_OBJ);
        
        return $row;
    }
    
    public static function alleMedewerkers() {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.crew_medewerkers';
		
        try {
            $res = $pdo->prepare($query);
            $res->execute();
	}
	catch (PDOException $e) {throw new Exception('Database query error');}
        
        $dataset = $res->fetchAll(PDO::FETCH_OBJ);
        
        return $dataset;
    }
    
    public static function updateCrew(array $dataset, int $id) {
        if(empty($dataset)) {throw new Exception('Geen data om te verwerken');}
        
        $action = DB::updateFromForm(DB.'.crew_medewerkers', $dataset, $id);	
        
        return $action;
    }
}
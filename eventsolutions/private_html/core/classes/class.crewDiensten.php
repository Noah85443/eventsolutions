<?php
class crewDiensten {	
   
    public static function perProject(int $id) {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.crew_diensten WHERE (projectId = :id)';
            $values = array(':id' => $id);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Database query error');}

        $row = array_map('reset', $stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_OBJ));
        
        return $row;
    }
    
    public static function perDienst(int $id) {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.crew_diensten WHERE (id = :id)';
            $values = array(':id' => $id);
		
        try {
            $stmt = $pdo->prepare($query); 
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Database query error');}
        
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        
        return $row;
    }
    
        public static function nieuweDienst(array $dataset) {
        if(empty($dataset)) {throw new Exception('Geen data om te verwerken');}
        
        $action = DB::insertFromForm(DB.'.crew_diensten', $dataset);	
        
        return $action;
    }
	
	public static function wijzigDienst(array $dataset, int $id) {
        if(empty($dataset)) {throw new Exception('Geen data om te verwerken');}
        
        $action = DB::updateFromForm(DB.'.crew_diensten', $dataset, $id);	
        
        return $action;
    }
}
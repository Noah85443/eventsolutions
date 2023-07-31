<?php
class crewProducten {	
    
    public static function perProduct(int $id) {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.crew_producten WHERE (id = :id)';
            $values = array(':id' => $id);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Database query error');}
        
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        
        return $row;
    }
    
    public static function perProductType(int $type) {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.crew_producten WHERE (type = :type)';
            $values = array(':type' => $type);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Database query error');}
        
        $dataset = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        return $dataset;
    }
}
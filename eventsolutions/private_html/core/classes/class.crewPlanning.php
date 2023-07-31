<?php
class crewPlanning {	
   
    public static function inplannen(int $dienstNr, int $medewerkerId, int $projectId = 0, string $afwijkendBegin = '00:00:00', string $afwijkendEinde = '00:00:00') {

        global $pdo;	

        $query = 'INSERT INTO '.DB.'.crew_planning (dienstNr, medewerkerId, afwijkendBegin, afwijkendEinde, projectId) VALUES (:dienstNr, :medewerkerId, :afwijkendBegin, :afwijkendEinde, :projectId)';
        $values = array(':dienstNr' => $dienstNr, ':medewerkerId' => $medewerkerId, ':afwijkendBegin' => $afwijkendBegin, ':afwijkendEinde' => $afwijkendEinde, ':projectId' => $projectId);

		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout opgetreden tijdens het inplannen van medewerker');}

        return $pdo->lastInsertId();
    }
    
    public static function wijzigen(int $dienstId, int $status ) {

        global $pdo;	

        $query = 'UPDATE '.DB.'.crew_planning SET status = :status WHERE id = :id';
        $values = array(':status' => $status, ':id' => $dienstId);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens wijzigen: '.$e->getMessage());}
        
        return true;
    }
    
    public static function perMedewerker(int $medewerkerId, string $status = '') {

        global $pdo;	
        
        if($status == "ingepland") {$conditions = '(medewerkerId = :id AND status = 1)';}
        elseif($status == "uitgepland") {$conditions = '(medewerkerId = :id AND status = 2)';}
        else    {$conditions = '(medewerkerId = :id)';}
        
        $query = 'SELECT * FROM '.DB.'.crew_planning WHERE '.$conditions.' ORDER BY id ASC';
            $values = array(':id' => $medewerkerId);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Database query error');}

        $row = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        return $row;
    }
    
     public static function perDienst(int $dienstNr) {

        global $pdo;	

        $query = 'SELECT status, medewerkerId, id FROM '.DB.'.crew_planning WHERE (dienstNr = :dienstNr) ORDER BY status';
        $values = array(':dienstNr' => $dienstNr);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens controleren van beschikbaarheid');}
        
        $dataset = $stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_OBJ);
        
        return $dataset;
    }
    
    public static function checkDienstStatus(int $dienstNr, int $medewerkerId) {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.crew_beschikbaarheid WHERE (dienstNr = :dienstNr) AND (medewerkerId = :medewerkerId)';
        $values = array(':dienstNr' => $dienstNr, ':medewerkerId' => $medewerkerId);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens controleren van beschikbaarheid');}
        
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        
        if(!empty($row)) {
            return $row->status;
        }
        else {
            return '0';
        }
    }
}
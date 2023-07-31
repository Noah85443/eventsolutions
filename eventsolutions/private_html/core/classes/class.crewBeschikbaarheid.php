<?php
class crewBeschikbaarheid {	
   
    public static function toevoegen(int $projectId, int $dienstNr, int $status, int $medewerkerId ) {

        global $pdo;	

        $query = 'INSERT INTO '.DB.'.crew_beschikbaarheid (projectId, dienstNr, status, medewerkerId) VALUES (:projectId, :dienstNr, :status, :medewerkerId)';
        $values = array(':projectId' => $projectId, ':dienstNr' => $dienstNr, ':status' => $status, ':medewerkerId' => $medewerkerId);

		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout opgetreden tijdens verwerken van de beschikbaarheid');}

        return $pdo->lastInsertId();

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
    
    public static function checkPerDienst(int $dienstNr) {

        global $pdo;	

        $query = 'SELECT status, medewerkerId, id FROM '.DB.'.crew_beschikbaarheid WHERE (dienstNr = :dienstNr) ORDER BY status';
        $values = array(':dienstNr' => $dienstNr);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens controleren van beschikbaarheid');}
        
        $dataset = $stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_OBJ);
        
        return $dataset;
    }
    
    public static function updateBeschikbaarheid(int $beschikbaarheidId, int $status ) {

        global $pdo;	

        $query = 'UPDATE '.DB.'.crew_beschikbaarheid SET status = :status WHERE id = :id';
        $values = array(':status' => $status, ':id' => $beschikbaarheidId);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens wijzigen: '.$e->getMessage());}
        
        return true;
    }
}
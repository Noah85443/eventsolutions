<?php
class verhuurEmballage {	
   
    public static function alleEmballage() {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.verhuur_emballage ORDER BY naam ASC';
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute();
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens ophalen van de gegevens');}
        
        $dataset = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        return $dataset;
    }
    
    public static function artikel(int $id) {

        global $pdo;	

        $query = 'SELECT * '
                . 'FROM '.DB.'.verhuur_emballage '
                . 'WHERE artikelNr = :id';
        $values = array(':id' => $id);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens ophalen van de gegevens'.$e->getMessage());}
        
        $dataset = $stmt->fetch(PDO::FETCH_OBJ);
 
        return $dataset;
    }
}
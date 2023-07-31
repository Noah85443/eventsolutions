<?php
class crewDeclaraties {	
   
    public static function perMedewerker(int $id) {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.crew_declaraties WHERE (medewerker = :id) ORDER BY id DESC';
            $values = array(':id' => $id);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens het samenstellen van het declaratielijst');}
        
        $dataset = $stmt->fetchAll(PDO::FETCH_OBJ);
                
        return $dataset;
    }
    
        public static function perId(int $id) {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.crew_declaraties WHERE (id = :id)';
            $values = array(':id' => $id);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens het ophalen van de declaratie');}
        
        $dataset = $stmt->fetch(PDO::FETCH_OBJ);
                
        return $dataset;
    }
    
    public static function perProject(int $id) {	
        global $pdo;	

        $query = 'SELECT id, crew_declaraties.* FROM '.DB.'.crew_declaraties WHERE (project_id = :id)';
        $values = array(':id' => $id);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens het ophalen van de declaratie');}
        
        $dataset = $stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);      
        $return = json_decode(json_encode($dataset));
        
        return $return;
    }
    
    public static function perProductType(int $id) {	
        global $pdo;	

        $query = 'SELECT product_type, crew_declaraties.* FROM '.DB.'.crew_declaraties WHERE (project_id = :id)';
        $values = array(':id' => $id);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens het ophalen van de declaratie');}
        
        $dataset = $stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);      
        $return = json_decode(json_encode($dataset));
        
        return $return;
    }
    
     public static function perProductId(int $id) {	
        global $pdo;	

        $query = 'SELECT product_id, crew_declaraties.* FROM '.DB.'.crew_declaraties WHERE (project_id = :id)';
        $values = array(':id' => $id);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens het ophalen van de declaratie');}
        
        $dataset = $stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);      
        $return = json_decode(json_encode($dataset));
        
        return $return;
    }
    
    public static function declaratieToevoegen(int $medewerker, int $project_id, int $product_id, int $product_type, string $naam, string $specificatie, int $opFactuur, int $status = 1, string $uren_id = null, string $aantal = NULL, string $waarde = NULL) {
        switch ($product_type) {
            case 2:
                if(!empty($aantal)) 
                    {$aantal = $aantal;}
                else 
                    {$aantal = 1;}
                $waarde = crewProducten::perProduct($product_id)->verkoopprijs;
                break;
            case 3:
                $aantal = $aantal;
                $waarde = $aantal * crewProducten::perProduct($product_id)->verkoopprijs;
                break;
            case 4:
                $aantal = 1;
                $waarde = $waarde;
                break;
            default:
                throw new Exception('Onbekend type declaratie. Controleer de invoer');
        }
        
        global $pdo;
			      
        $query = 'INSERT INTO '.DB.'.crew_declaraties '
                . '(medewerker, project_id, aantal, product_id, product_type, naam, specificatie, waarde, uren_id, status, opFactuur)'
                . 'VALUES '
                . '(:medewerker, :project_id, :aantal, :product_id, :product_type, :naam, :specificatie, :waarde, :uren_id, :status, :opFactuur)';
	$values = array(
            ':medewerker' => $medewerker, 
            ':project_id' => $project_id,
            ':aantal' => $aantal, 
            ':product_id' => $product_id,
            ':product_type' => $product_type,
            ':naam' => $naam, 
            ':specificatie' => $specificatie, 
            ':waarde' => $waarde, 
            ':uren_id' => $uren_id,
            ':status' => $status, 
            ':opFactuur' => $opFactuur
        );

        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens het uploaden van de data naar de database'. $e->getMessage());}
    
        return $pdo->lastInsertId();
        }
        
    public static function updateStatus(int $declaratieId, int $status ) {

        global $pdo;	

        $query = 'UPDATE '.DB.'.crew_declaraties SET status = :status WHERE id = :id';
        $values = array(':status' => $status, ':id' => $declaratieId);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens wijzigen: '.$e->getMessage());}
        
        return true;
    }
    
     public static function updateFactuurStatus(int $declaratieId, int $status ) {

        global $pdo;	

        $query = 'UPDATE '.DB.'.crew_declaraties SET opFactuur = :status WHERE id = :id';
        $values = array(':status' => $status, ':id' => $declaratieId);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens wijzigen: '.$e->getMessage());}
        
        return true;
    }
        
    public static function statusId($state = null){
        $states = array(
            "0" => array("nr" => 0, "txt" => "Lege regel aangemaakt", "ico" => "<i class=\"material-icons btn btn-outline-danger btn-sm py-2 fs-6\">priority_high</i>"),
            "1" => array("nr" => 1, "txt" => "Declaratie ingevoerd door medewerker", "ico" => "<i class=\"material-icons btn btn-outline-info btn-sm py-2 fs-6\">person_outline</i>"),
            "2" => array("nr" => 2, "txt" => "Declaratie goedgekeurd", "ico" => "<i class=\"material-icons btn btn-outline-success btn-sm py-2 fs-6\">check</i>"),
            "3" => array("nr" => 3, "txt" => "Klant akkoord", "ico" => "<i class=\"material-icons btn btn-success btn-sm py-2 fs-6\">done_all</i>"),
            "4" => array("nr" => 4, "txt" => "Declaratie afgekeurd", "ico" => "<i class=\"material-icons btn btn-outline-danger btn-sm py-2 fs-6\">clear</i>"),
            "5" => array("nr" => 5, "txt" => "Declaratie uitbetaald", "ico" => "<i class=\"material-icons btn btn-secondary btn-sm py-2 fs-6\">payments</i>"),
        );
    
       if(!empty($state)) {
           return $states[$state];
       }
       else {
            return $states;
       }
    }
    
}
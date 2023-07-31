 <?php
class crewUren {	
   
    public static function perMedewerker(int $id) {

        global $pdo;	

        $query = 'SELECT id FROM '.DB.'.crew_uren WHERE (medewerkerId = :id) ORDER BY tijdBegin DESC';
            $values = array(':id' => $id);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens het samenstellen van het urenregister');}
        
        $dataset = array();
        while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
            $dataregel = crewUren::dataPerRegel($row->id);
            array_push($dataset, $dataregel);
        }
        
        return $dataset;
    }
    
        public static function perMedewerkerOpenstaand(int $id) {

        global $pdo;	

        $diensten = crewPlanning::perMedewerker($id);
        $nogOpenstaand = array();
        
        for($x = 0; $x < count($diensten); $x++) {
            $dienstNr = $diensten[$x]->dienstNr;
            $query = 'SELECT * FROM '.DB.'.crew_uren WHERE (medewerkerId = :id) AND (dienstId = :dienstNr) ORDER BY tijdBegin asc';
            $values = array(':id' => $id, ':dienstNr' => $dienstNr);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens het controleren van de database'.$e->getMessage());}
        
        
        $dienst = $stmt->fetch(PDO::FETCH_OBJ);
        
        if(empty($dienst)) {array_push($nogOpenstaand, $diensten[$x]);}
        }
        return $nogOpenstaand;
    }
    
    public static function perDienstInProject(int $id) {

        global $pdo;	

        $query = 'SELECT dienstId, id  FROM '.DB.'.crew_uren WHERE (projectId = :id) ORDER BY tijdBegin DESC';
            $values = array(':id' => $id);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens het samenstellen van het urenregister');}
        
        $dataset = $stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_OBJ); 
        
        return $dataset;
    }
    
        public static function projectPerFunctie(int $id) {

            global $pdo;	

        $query = 'SELECT crew_diensten.functieId, crew_uren.id, crew_uren.dienstId '
                . 'FROM '.DB.'.crew_uren '
                . 'LEFT JOIN '.DB.'.crew_diensten ON crew_uren.dienstId = crew_diensten.id '
                . 'WHERE (crew_uren.projectId = :id) '
                . 'ORDER BY crew_uren.tijdBegin DESC';
        $values = array(':id' => $id);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens het samenstellen van het urenregister'.$e->getMessage());}
        
        $dataset = $stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_OBJ); 
        
        foreach($dataset as $product => $regel) {
            for($x=0; $x<count($regel); $x++) {
                $data = self::dataPerRegel($regel[$x]->id);
                $regel[$x]->aantal = $data['uren']['punt'];
            }
            
        }
        
        return $dataset;
    }
    
    public static function perProject(int $id) {

        global $pdo;	

        $query = 'SELECT id  FROM '.DB.'.crew_uren WHERE (projectId = :id) ORDER BY tijdBegin DESC';
            $values = array(':id' => $id);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens het samenstellen van het urenregister');}
        
        $dataset = $stmt->fetchAll(PDO::FETCH_OBJ); 
        
        return $dataset;
    }
    
    public static function perUrenId(int $id) {

        global $pdo;	

        $query = 'SELECT id FROM '.DB.'.crew_uren WHERE (id = :id) ORDER BY tijdBegin DESC';
            $values = array(':id' => $id);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens het samenstellen van het urenregister');}
        
        $row = $stmt->fetch(PDO::FETCH_OBJ);
       
        $dataset = crewUren::dataPerRegel($row->id);
            
        
        
        return $dataset;
    }
    
    
    // Bereken gewerkte uren per regel
    public static function dataPerRegel(int $id) {
        global $pdo;
        
        $query = 'SELECT * FROM '.DB.'.crew_uren WHERE (id = :id)';
        $values = array(':id' => $id);
         
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Uren konden niet worden opgehaald');}
        $dataset = $res->fetch(PDO::FETCH_OBJ);
        
        $projectInfo = projecten::perProject($dataset->projectId);
        
        $dienstData = crewDiensten::perDienst($dataset->dienstId);
        if(!empty($dienstData->functieId)) {
            $dienstNaam = crewProducten::perProduct($dienstData->functieId)->productNaam;
            $functieId = $dienstData->functieId;
        }
        else {
            $dienstNaam = 'Onbekende dienst';
            $functieId = 0;
        }
        $pauzeTijd = new DateTime($dataset->tijdPauze);
	$pauzeTijd->format("H:i:s");
	
        $gewerkteUren = "PT".$pauzeTijd->format("H")."H".$pauzeTijd->format("i")."M";
	$startTijd = new DateTime($dataset->tijdBegin);
	
        $eindTijd = new DateTime($dataset->tijdEinde);
	$eindTijd2 = new DateTime($dataset->tijdEinde); 
	$eindPauze = date_sub($eindTijd, new DateInterval($gewerkteUren));
	$eindPauze->format("Y-m-d H:i:s");
	$result = $startTijd->diff($eindPauze);
		
	$decimal = round($result->s / 3600 + $result->i / 60 + $result->h + $result->days * 24, 2);
	$dot = str_replace(',', '.', $decimal);
        
        $gewerkt = array(
            "id" => $dataset->id,
            "medewerker" => $dataset->medewerkerId,
            "project" => $projectInfo->projectNaam,
            "projectId" => $dataset->projectId,
            "subproject" => $dataset->subProjectId,
            "dienstNr" => $dataset->dienstId,
            "dienstId" => $functieId,
            "dienstNaam" => $dienstNaam,
            "status" => $dataset->status,
            "uren" => array(
                "datum" => $startTijd->format("d-m-Y"),
		"datumKort" => $startTijd->format("d-m"),
		"week" => date("W", strtotime($startTijd->format("Y-m-d"))),
		"begin" => $startTijd->format("H:i"),
		"eind" => $eindTijd2->format("H:i"),
		"pauze" => $pauzeTijd->format("H:i"),
		"totaal" => $result->format("%H:%I"),
		"komma" => $decimal,
		"punt" => $dot)
            );  
    return $gewerkt;
    }
    
    public static function urenToevoegen(int $medewerkerId, int $projectId, int $dienstId, string $datum, string $tijdBegin, string $tijdEinde, string $tijdPauze, string $status) {
        
        global $pdo;
       
        
        if ($tijdBegin < $tijdEinde) {
            $datumEinde = $datum;
        }
        else {
            $datumEinde = date('Y-m-d', strtotime("+1 day", strtotime($datum)));
	}
			
	$start = $datum . ' ' . $tijdBegin;
	$eind = $datumEinde . ' ' .  $tijdEinde;
        
        $query = 'INSERT INTO '.DB.'.crew_uren (medewerkerId, projectId, dienstId, tijdBegin, tijdEinde, tijdPauze, status) VALUES (:medewerkerId, :projectId, :dienstId, :tijdBegin, :tijdEinde, :tijdPauze, :status)';
	$values = array(':medewerkerId' => $medewerkerId, ':projectId' => $projectId, ':dienstId' => $dienstId, ':tijdBegin' => $start, ':tijdEinde' => $eind, ':tijdPauze' => $tijdPauze, ':status' => $status);

        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens het uploaden van de data naar de database'. $e->getMessage());}
    
        return $pdo->lastInsertId();
        }
        
    public static function updateStatus(int $urenId, int $status ) {

        global $pdo;	

        $query = 'UPDATE '.DB.'.crew_uren SET status = :status WHERE id = :id';
        $values = array(':status' => $status, ':id' => $urenId);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens wijzigen: '.$e->getMessage());}
        
        return true;
    }
        
    public static function statusId($state = null){
        $states = array(
            "0" => array("nr" => 0, "txt" => "Lege regel aangemaakt", "ico" => "<i class=\"far fa-clock font-red\"></i>"),
            "1" => array("nr" => 1, "txt" => "Uren ingevoerd door medewerker", "ico" => "<i class=\"fas fa-user-plus font-blue\"></i>"),
            "2" => array("nr" => 2, "txt" => "Uren goedgekeurd", "ico" => "<i class=\"fas fa-user-plus font-blue\"></i>"),
            "3" => array("nr" => 3, "txt" => "Klant akkoord", "ico" => "<i class=\"fas fa-user-plus font-blue\"></i>"),
            "4" => array("nr" => 4, "txt" => "Uren afgekeurd", "ico" => "<i class=\"fas fa-user-check font-green\"></i>"),
        );
    
       if(!empty($state)) {
           return $states[$state];
       }
       else {
            return $states;
       }
    }
    
}
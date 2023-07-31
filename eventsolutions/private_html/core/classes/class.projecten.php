<?php
class projecten {	
   
    public static function alleProjecten() {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.projecten ORDER BY datumBegin DESC';
		
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

        $query = 'SELECT * FROM '.DB.'.projecten WHERE (relatie = :relatie) ORDER BY datumBegin DESC';
            $values = array(':relatie' => $id);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens ophalen van de gegevens');}
        
        $row = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        return $row;
    }
    
    public static function perProject(int $id) {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.projecten WHERE (id = :id)';
            $values = array(':id' => $id);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens ophalen van de gegevens');}
        
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        
        return $row;
    }
    
        public static function perStatus($statusId) {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.projecten WHERE (status = :statusId) AND (toonProject = 1)';
            $values = array(':statusId' => $statusId);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens ophalen van de gegevens');}
        
        $row = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        return $row;
    }
    
    public static function statusId($state = null){
        $states = [
            "nieuwe_aanvraag"                       
                => ["id" => "nieuwe_aanvraag", 
                    "txt" => "Projectaanvraag gedaan door klant", 
                    "ico" => "<i class=\"material-icons-outlined float-start pe-2\">new_releases</i>"],
            "aanvraag_goedgekeurd"                  
                => ["id" => "aanvraag_goedgekeurd", 
                    "txt" => "Project bevestigd door backoffice", 
                    "ico" => "<i class=\"material-icons-outlined float-start pe-2\">check_box</i>"],
            "project_wacht_op_goedkeuring_offerte"  
                => ["id" => "project_wacht_op_goedkeuring_offerte", 
                    "txt" => "Project bevestigd door backoffice", 
                    "ico" => "<i class=\"material-icons-outlined float-start pe-2\">check_box</i>"],
            "project_in_behandeling"                
                => ["id" => "project_in_behandeling", 
                    "txt" => "Project in behandeling", 
                    "ico" => "<i class=\"material-icons-outlined float-start pe-2\">autorenew</i>"],
            "project_klaar_voor_uitvoering"         
                => ["id" => "project_klaar_voor_uitvoering", 
                    "txt" => "Project klaar voor uitvoering", 
                    "ico" => "<i class=\"material-icons-outlined float-start pe-2\">beenhere</i>"],
            "verhuur_geleverd"                      
                => ["id" => "verhuur_geleverd", 
                    "txt" => "Materialen geleverd", 
                    "ico" => "<i class=\"material-icons-outlined float-start pe-2\">check_circle</i>"],
            "project_wachten_op_data"               
                => ["id" => "project_wachten_op_data", 
                    "txt" => "In afwachting van invoer uren/nacalculaties", 
                    "ico" => "<i class=\"material-icons-outlined float-start pe-2\">pending_actions</i>"],
            "project_wachten_op_goedkeuring_data"   
                => ["id" => "project_wachten_op_goedkeuring_data", 
                    "txt" => "In afwachting van goedkeuring uren/nacalculaties", 
                    "ico" => "<i class=\"material-icons-outlined float-start pe-2\">free_cancellation</i>"],
            "verhuur_wachten_op_telling"            
                => ["id" => "verhuur_wachten_op_telling", 
                    "txt" => "Wachten op telling retouren", 
                    "ico" => "<i class=\"material-icons-outlined float-start pe-2\">pending_actions</i>"],
            "project_data_goedgekeurd"              
                => ["id" => "project_data_goedgekeurd", 
                    "txt" => "Nacalculaties/Uren goedgekeurd - Klaar voor facturatie", 
                    "ico" => "<i class=\"material-icons-outlined float-start pe-2\">assignment_turned_in</i>"],
            "facturatie_verzonden"                  
                => ["id" => "facturatie_verzonden", 
                    "txt" => "Project gefactureerd - wachten op betaling", 
                    "ico" => "<i class=\"material-icons-outlined float-start pe-2\">currency_exchange</i>"],
            "project_afgerond"                      
                => ["id" => "project_afgerond", 
                    "txt" => "Project afgerond", 
                    "ico" => "<i class=\"material-icons-outlined float-start pe-2\">check_circle</i>"],
            "project_geannuleerd"                   
                => ["id" => "project_geannuleerd", 
                    "txt" => "Project geannuleerd", 
                    "ico" => "<i class=\"material-icons-outlined float-start pe-2\">delete_forever</i>"]];
    
        if(isset($state)) {
            return $states[$state];
        }
        else {
            return $states;
        }
    }
    
    public static function nieuwProject(array $dataset) {
        if(empty($dataset)) {throw new Exception('Geen data om te verwerken');}

        $projectNummer = self::genereerProjectNr(); 
                        
        $locatie = [
            "straat" => $dataset['locatie_straat'],
            "postcode" => $dataset['locatie_postcode'],
            "plaats" => $dataset['locatie_plaats'],
            "land" => $dataset['locatie_land'],
            "locatieId" => $dataset['locatie_id']
        ];
        $locatie = json_encode($locatie, true);
        
        global $pdo;
        $query = 'INSERT INTO '.DB.'.projecten (projectNummer,projectNaam,datumBegin,datumEind,locatie,projectAdmin,relatie,toonProject,status) VALUES (:projectNummer,:projectNaam, :datumBegin, :datumEind, :locatie, :projectAdmin, :relatie, :toonProject,:status)';
	$values = [
            ':projectNummer' => $projectNummer,
            ':projectNaam' => $dataset['projectNaam'], 
            ':datumBegin' => $dataset['datumBegin'],
            ':datumEind' => $dataset['datumEind'],
            ':relatie' => $dataset['relatie'],
            ':status' => $dataset['status'],
            ':toonProject' => $dataset['toonProject'],
            ':projectAdmin' => $dataset['projectAdmin'],
            ':locatie' => $locatie
        ];

        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens het uploaden van de data naar de database'. $e->getMessage());}
    
        return $projectNummer;
    }
    
    public static function updateProject(array $dataset, int $projectId) {
        if(empty($dataset)) {throw new Exception('Geen data om te verwerken');}
        
         $locatie = [
            "straat" => $dataset['locatie_straat'],
            "postcode" => $dataset['locatie_postcode'],
            "plaats" => $dataset['locatie_plaats'],
            "land" => $dataset['locatie_land'],
            "locatieId" => $dataset['locatie_id']
        ];
        $locatie = json_encode($locatie, true);
        
        global $pdo;	

        $query = '
            UPDATE
                '.DB.'.projecten
            SET 
                projectNaam = :projectNaam,
                datumBegin = :datumBegin,
                datumEind = :datumEind,
                klantKenmerk = :klantKenmerk,
                locatie = :locatie,
                projectAdmin = :projectAdmin,
                relatie = :relatie,
                status = :status,
                toonProject = :toonProject
            WHERE 
                id = :id';
        
        $values = array(
            ':projectNaam' => $dataset['projectNaam'],
            ':datumBegin' => $dataset['datumBegin'],
            ':datumEind' => $dataset['datumEind'],
            ':klantKenmerk' => $dataset['klantKenmerk'],
            ':locatie' => $locatie,
            ':projectAdmin' => $dataset['projectAdmin'],
            ':relatie' => $dataset['relatie'],
            ':status' => $dataset['status'],
            ':toonProject' => $dataset['toonProject'],
            ':id' => $projectId
        );
		
        try {
            $stmt = $pdo->prepare($query);
            $action = $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens wijzigen: '.$e->getMessage());}
        
        return $action;
    }
    
    public static function updateStatus(int $projectId, string $status ) {

        global $pdo;	

        $query = 'UPDATE '.DB.'.projecten SET status = :status WHERE id = :id';
        $values = array(':status' => $status, ':id' => $projectId);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens wijzigen: '.$e->getMessage());}
        
        return true;
    }
    
        public static function genereerProjectNr() {

        global $pdo;	

        $query = 'SELECT id,projectNummer FROM '.DB.'.projecten ORDER BY id DESC';

        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute();
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens ophalen van de gegevens');}
        
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        
        $nummer = ($row->id + 1);
        $output = date('y') . sprintf('%05d', $nummer);
        
        return $output;
    }
}
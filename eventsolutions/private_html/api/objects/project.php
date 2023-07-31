<?php
class Project {
  
    private $conn;
    private $table_name = "projecten_verhuur";
  

  
    public function __construct($db){
        $this->conn = $db;
    }
    

    public function nieuw_project($dataset){
    try
    {    
        $artikelen = json_encode($dataset->artikelen, true);
		$gegevens_aanvrager = [
			"contactgegevens" => $dataset->contactgegevens,
			"bezorgadres" => $dataset->bezorgadres,
			"facturatie" => [
				"tav" => $dataset->factuur_tav,
				"email" => $dataset->factuur_email,
				"adres" => $dataset->factuur_adres
			]
		];
        
		$gegevens_aanvrager = json_encode($gegevens_aanvrager, true);
		
        $query = "INSERT INTO
                    {$this->table_name}
                    (
                        status,
                        artikelen,
                        huurperiode_start,
                        huurperiode_eind,
                        levering_aanvoer,
						levering_retour,
                        aanvoerdatum,
                        retourdatum,
                        gegevens_aanvrager,
                        bron
                    ) 
                VALUES 
                    (
                        '".$dataset->status."',    
                        '".$artikelen."',
                        '".$dataset->huurperiode_start."',
                        '".$dataset->huurperiode_eind."',
                        '".$dataset->levering_aanvoer."',
						'".$dataset->levering_retour."',
                        '".$dataset->aanvoerdatum."',
                        '".$dataset->retourdatum."',
                        '".$gegevens_aanvrager."',
                        '".$dataset->bron."'
                    )
               ";
    $stmt = $this->conn->prepare($query);
    $result = $stmt->execute();
    return $result;

    }
    catch (PDOException $e)
    {
        throw new Exception('Fout tijdens het opslaan van de opdracht. Probeer het opnieuw of neem contact met ons op.');
    }
        
    }
    
    }

?>
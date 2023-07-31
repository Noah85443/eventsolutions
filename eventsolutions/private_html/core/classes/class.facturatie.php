<?php
class facturatie {	
   
    public static function alleFacturen() {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.facturen ORDER BY datum DESC';
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute();
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens ophalen van de gegevens');}
        
        $dataset = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        return $dataset;
    }
    
        public static function perRelatie($id) {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.facturen WHERE (relatie = :relatie) ORDER BY datum DESC';
        $values = array(':relatie' => $id);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens ophalen van de gegevens');}
        
        $dataset = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        return $dataset;
    }
    
    public static function opFactuurNummer(int $id) {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.facturen WHERE (nummer = :nummer)';
            $values = array(':nummer' => $id);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens ophalen van de gegevens');}
        
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        
        return $row;
    }
    
        public static function opBetaalcode(string $betaalcode) {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.facturen WHERE (betaalcode = :betaalcode)';
            $values = array(':betaalcode' => $betaalcode);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens ophalen van de gegevens');}
        
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        
        return $row;
    }
    
    public static function FactuurNrvanId(int $id) {

        global $pdo;	

        $query = 'SELECT nummer FROM '.DB.'.facturen WHERE (id = :id)';
            $values = array(':id' => $id);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens ophalen van de gegevens');}
        
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        
        return $row->nummer;
    }
    
        public static function perStatus(int $status) {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.facturen WHERE (status = :status)';
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
            "1" => [
                "nr" => 1, 
                "txt" => "Factuur aangemaakt (leeg)", 
                "style" => "text-bg-light",
                "txt_badge" => "Concept"
            ],
            "2" => [
                "nr" => 2,
                "txt" => "Factuurregels toegevoegd", 
                "style" => "text-bg-light",
                "txt_badge" => "Concept"
            ],
            "3" => [
                "nr" => 3, 
                "txt" => "Factuur aangemaakt en verzonden aan klant", 
                "style" => "text-bg-warning",
                "txt_badge" => "Openstaand"
            ],
            "4" => [
                "nr" => 4, 
                "txt" => "1e herinnering verstuurd", 
                "style" => "text-bg-secondary",
                "txt_badge" => "Herinnerd (1e)"
            ],
            "5" => [
                "nr" => 5, 
                "txt" => "2e herinnering verstuurd", 
                "style" => "text-bg-secondary",
                "txt_badge" => "Herinnerd (2e)"
            ],
            "6" => [
                "nr" => 6,
                "txt" => "3e herinnering verstuurd", 
                "style" => "text-bg-secondary",
                "txt_badge" => "Herinnerd (3e)"
            ],
            "7" => [
                "nr" => 7, 
                "txt" => "Overgedragen aan incassobureau", 
                "style" => "text-bg-danger",
                "txt_badge" => "Incassobureau"
            ],
            "8" => [
                "nr" => 8, 
                "txt" => "Betaald", 
                "style" => "text-bg-success",
                "txt_badge" => "Betaald"
            ],
            "9" => [
                "nr" => 9, 
                "txt" => "Gecrediteerd", 
                "style" => "text-bg-success",
                "txt_badge" => "Gecrediteerd"
            ]
        ];
    
       if(!empty($state)) {
           return $states[$state];
       }
       else {
            return $states;
       }
    }
    
        public static function updateStatus(int $factuurNr, int $status ) {

        global $pdo;	

        $query = 'UPDATE '.DB.'.facturen SET status = :status WHERE nummer = :factuurNr';
        $values = array(':status' => $status, ':factuurNr' => $factuurNr);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens wijzigen: '.$e->getMessage());}
        
        return true;
    }
    
    public static function nieuweFactuur(array $dataset) {
        
        global $pdo;
        
        if(empty($dataset)) {throw new Exception('Geen data om te verwerken');}
        
        $relatie = $dataset['relatie'];
        $factuurNr = facturatie::genereerFactuurnr();
        $projecten = json_encode($dataset['projecten']);
        $datum = $dataset['datum'];
        $vervaldatum = $dataset['vervaldatum'];
        $betaalcode = betalingen::maakCode();
        $status = 1;
        $currentUser = 10;
        
        $query = 'INSERT INTO '.DB.'.facturen (relatie, nummer, projecten, datum, vervaldatum, betaalcode, status, behandelddoor) '
                . 'VALUES (:relatie, :nummer, :projecten, :datum, :vervaldatum, :betaalcode, :status, :behandelddoor)';
        
        $values = array(':relatie' => $relatie, ':nummer' => $factuurNr, ':projecten' => $projecten, ':datum' => $datum, ':vervaldatum' => $vervaldatum, ':betaalcode' => $betaalcode, ':status' => $status, ':behandelddoor' => $currentUser);

		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens wijzigen: '.$e->getMessage());}
        
        return $factuurNr;
    }
    
    public static function genereerFactuurnr() {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.facturen ORDER BY nummer DESC';

        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute();
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens ophalen van de gegevens');}
        
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        
        $output = $row->nummer + 1;
        
        return $output;
    }
    
        public static function berekenBtw($bedrag, $btwCode) {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.instellingen_btwcodes WHERE (id = :btwCode)';
            $values = array(':btwCode' => $btwCode);

        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens ophalen van de gegevens');}
        
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        
        $btwBedrag = $bedrag * $row->btwDecimaal;
        $nettoBedrag = $bedrag + $btwBedrag;
        
        $output = array(
            'bruto' => round($bedrag,2),
            'netto' => round($nettoBedrag,2),
            'btw' => round($btwBedrag,2),
            'btwCode' => $btwCode,
            'btwPercentage' => $row->btwPercentage,
            'btwOmschrijving' => $row->btwOmschrijving,
            'btwMbId' => $row->btwExtId
        );
        
        return $output;
    }
    
    
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    public static function dataPerProject($project) {
        $factuurdata = array();
        
        $uren = crewUren::projectPerFunctie($project);
        $declaraties = crewDeclaraties::perProductId($project);
        $regels = $uren + (array)$declaraties;
        
        $factuurdata[$project] = self::groepeerDataPerProduct($regels);
        
        return $factuurdata[$project];
    }
     
    public static function groepeerDataPerProduct($dataset) {
        $result = array();
        foreach($dataset as $product => $regel) {
            $productInfo = crewProducten::perProduct($product);
            $result[$product]['productId'] = $product;
            $result[$product]['productNaam'] = $productInfo->productNaam;
            $result[$product]['productType'] = $productInfo->type;
            $result[$product]['productExtId'] = $productInfo->extId;
            $result[$product]['productGbVerkoop'] = $productInfo->grootboekVerkoop;
            
            $result[$product]['aantal'] = 0;
            $result[$product]['regelBruto'] = 0;
            
            if($productInfo->type == 4) {
                $result[$product]['aantal'] = 1;
                for($x=0; $x<count($regel); $x++) {
                    $result[$product]['regelBruto'] += $regel[$x]->waarde;
                }
            }
            else {
                for($x=0; $x<count($regel); $x++) {
                    $result[$product]['aantal'] += $regel[$x]->aantal;
                }
                $result[$product]['regelBruto'] = $productInfo->verkoopprijs;
            }
            
            $productprijs = facturatie::berekenBtw($result[$product]['regelBruto'], $productInfo->btwCode);
            $result[$product]['regelBtw'] = $productprijs['btw'];
            $result[$product]['regelNetto'] = $productprijs['netto'];
            $result[$product]['totaalBruto'] = round($result[$product]['regelBruto'] * $result[$product]['aantal'],2);
            $result[$product]['totaalBtw'] = round($result[$product]['regelBtw'] * $result[$product]['aantal'],2);
            $result[$product]['totaalNetto'] = round($result[$product]['totaalBruto'] + $result[$product]['totaalBtw'],2);
            $result[$product]['btwPercentage'] = $productprijs['btwPercentage'];
            $result[$product]['mbBtwId'] = $productprijs['btwMbId'];
            $result[$product]['regels'] = $dataset[$product];
        }
        
        $result = array_values($result);
        
        return $result;
    }
    
    
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public static function groupByVat($array, $key) {
    	$return = array();
    	foreach($array as $val) {
   	     	$return[$val[$key]][] = $val;
   		}
    	
		return $return;
	}
    
    public static function regelsToevoegen($factuurId, $regels) {

        global $pdo;	

        $query = 'UPDATE '.DB.'.facturen SET regels = :regels WHERE id = :id';
        $values = array(':regels' => $regels, ':id' => $factuurId);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens wijzigen: '.$e->getMessage());}
        
        $factuurNr = self::FactuurNrvanId($factuurId);
        return $factuurNr;        
    }
    
    public static function dataToevoegen($factuurId, $totaal, $pdfLocatie, $moneybirdId) {

        global $pdo;	

        $query = 'UPDATE '.DB.'.facturen SET totaal = :totaal, pdfLocatie = :pdfLocatie, moneybirdId = :moneybirdId WHERE id = :id';
        $values = array(':totaal' => $totaal, ':pdfLocatie' => $pdfLocatie, ':moneybirdId' => $moneybirdId, ':id' => $factuurId);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens wijzigen: '.$e->getMessage());}
        
        $factuurNr = self::FactuurNrvanId($factuurId);
        return $factuurNr;        
    }
    
}
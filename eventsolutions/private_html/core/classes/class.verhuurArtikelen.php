<?php
class verhuurArtikelen {	
   
    public static function alleArtikelen() {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.verhuur_artikelen ORDER BY artikelnaam ASC';
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute();
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens ophalen van de gegevens');}
        
        $dataset = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        for($x=0;$x<count($dataset);$x++) {
            $dataset[$x]->artikelgroep = verhuurArtikelgroepen::perArtikelgroep($dataset[$x]->artikelgroep)->naam;
            $dataset[$x]->prijsEuro = convert::toEuro($dataset[$x]->prijs);
            $dataset[$x]->mancoprijsEuro = convert::toEuro($dataset[$x]->mancoprijs);
        }
        
        return $dataset;
    }
    
        public static function artikel(int $id) {

        global $pdo;	

        $query = 'SELECT * '
                . 'FROM '.DB.'.verhuur_artikelen '
                . 'WHERE id = :id';
        $values = array(':id' => $id);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens ophalen van de gegevens'.$e->getMessage());}
        
        $dataset = $stmt->fetch(PDO::FETCH_OBJ);
        
            $dataset->artikelgroep = verhuurArtikelgroepen::perArtikelgroep($dataset->artikelgroep);
            $dataset->prijsEuro = convert::toEuro($dataset->prijs);
            $dataset->mancoprijsEuro = convert::toEuro($dataset->mancoprijs);
        
        
        return $dataset;
    }
    
        public static function updateArtikel(array $dataset, int $id) {
        if(empty($dataset)) {throw new Exception('Geen data om te verwerken');}
        
        $action = DB::updateFromForm(DB.'.verhuur_artikelen', $dataset, $id);	
        
        return $action;
    }
}
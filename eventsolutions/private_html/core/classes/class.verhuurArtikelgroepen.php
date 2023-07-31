<?php
class verhuurArtikelgroepen {	
   
    public static function alleArtikelgroepen() {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.verhuur_artikelgroepen ORDER BY naam ASC';
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute();
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens ophalen van de gegevens');}
        
        $dataset = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        for($x=0;$x<count($dataset);$x++) {
            if(!empty($dataset[$x]->toplevel)) {$dataset[$x]->toplevel = verhuurArtikelgroepen::perArtikelgroep($dataset[$x]->toplevel)->naam;}
        }
        
        return $dataset;
    }
    
    public static function perArtikelgroep($id) {

        global $pdo;	

        $query = 'SELECT * FROM '.DB.'.verhuur_artikelgroepen WHERE id = '.$id;
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute();
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens ophalen van de gegevens');}
        
        $dataset = $stmt->fetch(PDO::FETCH_OBJ);
        
        return $dataset;
    }
}
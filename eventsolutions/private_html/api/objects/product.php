<?php
class Product {
  
    private $conn;
    private $table_name = "verhuur_artikelen";
  
    public $id;
    public $artikelnaam;
    public $artikelsoort;
    public $stuksPerEenheid;
    public $prijs;
    public $btwTarief;
    public $inhuurartikel;
    public $afbeelding;
    public $alias;
    public $artikelAlias;
  
    public function __construct($db){
        $this->conn = $db;
    }
    
function read(){
    $query = "SELECT
                id, artikelnaam, artikelsoort, stuksPerEenheid, prijs, btwTarief, inhuurartikel, afbeelding, alias
            FROM
                " . $this->table_name . "
            ORDER BY
                id ASC";
  
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
  
    return $stmt;
}

function readFromCategory(){
    $query = "SELECT
                id, artikelnaam, artikelgroep, artikelsoort, stuksPerEenheid, prijs, btwTarief, inhuurartikel, afbeelding, alias
            FROM
                " . $this->table_name . "
            WHERE
                artikelgroep = ?
            ORDER BY
                id ASC";
  
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->artikelgroep);
    $stmt->execute();
  
    return $stmt;
}

function readOne(){
    $query = "SELECT
                id, artikelnaam, artikelnr, artikelsoort, stuksPerEenheid, prijs, btwTarief, inhuurartikel, afbeelding, alias, onderdelen, samengesteld, beschrijving
            FROM
                " . $this->table_name . "
            WHERE
                alias = ?
                OR
                id = ?
            LIMIT
                0,1";
  
    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(1, $this->id);
    $stmt->bindParam(2, $this->id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
    $this->id = $row['id'];
    $this->artikelnaam = $row['artikelnaam'];
    $this->artikelnr = $row['artikelnr'];
    $this->artikelsoort = $row['artikelsoort'];
    $this->stuksPerEenheid = $row['stuksPerEenheid'];
    $this->prijs = $row['prijs'];
    $this->btwTarief = $row['btwTarief'];
    $this->inhuurartikel = $row['inhuurartikel'];
    $this->afbeelding = $row['afbeelding'];
    $this->alias = $row['alias'];
    $this->onderdelen = $row['onderdelen'];
    $this->samengesteld = $row['samengesteld'];
    $this->kenmerken = $row['kenmerken'];
    $this->beschrijving = $row['beschrijving'];
}

function search($keywords) {
    $query = "SELECT
                id, artikelnaam, artikelnr, artikelsoort, stuksPerEenheid, prijs, btwTarief, inhuurartikel, afbeelding, alias, onderdelen, samengesteld, beschrijving
            FROM
                " . $this->table_name . "
            WHERE
                artikelnaam LIKE ? OR artikelsoort LIKE ?
            ORDER BY
                id ASC";
  
    $stmt = $this->conn->prepare($query);
    
    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";
  
    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);
 
    $stmt->execute();
  
    return $stmt;
}
}
?>
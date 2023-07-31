<?php
class Category {
  
    private $conn;
    private $table_name = "verhuur_artikelgroepen";
  
    public $id;
    public $naam;
    public $toplevel;
    public $alias;
    public $afbeelding;
    public $opVoorpagina;
    public $beschrijving;
  
    public function __construct($db){
        $this->conn = $db;
    }
    
function read(){
    $query = "SELECT
                id, naam, toplevel, alias, afbeelding, opVoorpagina, beschrijving
            FROM
                " . $this->table_name . "
            ORDER BY
                id ASC";
  
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
  
    return $stmt;
}

function readFrontPage(){
    $query = "SELECT
                id, naam, toplevel, alias, afbeelding, opVoorpagina, beschrijving
            FROM
                " . $this->table_name . "
            WHERE
                opVoorpagina = 1
            ORDER BY
                id ASC";
  
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
  
    return $stmt;
}

function readSubCategories(){
    $query = "SELECT
                id, naam, toplevel, alias, afbeelding, opVoorpagina, beschrijving
            FROM
                " . $this->table_name . "
            WHERE
                toplevel = ?
            ORDER BY
                id ASC";
  
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);
    $stmt->execute();
  
    return $stmt;
}

function readOne(){
    $query = "SELECT
                id, alias, naam, toplevel, alias, afbeelding, opVoorpagina, beschrijving
            FROM
                " . $this->table_name . "
            WHERE
                id = ? OR alias = ?
            LIMIT
                0,1";
  
    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(1, $this->id);
    $stmt->bindParam(2, $this->alias);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
    $this->id = $row['id'];
    $this->naam = $row['naam'];
    $this->toplevel = $row['toplevel'];
    $this->alias = $row['alias'];
    $this->afbeelding = $row['afbeelding'];
    $this->opVoorpagina = $row['opVoorpagina'];
    $this->beschrijving = $row['beschrijving'];
}

function readOneFromAlias(){
    $query = "SELECT
                id, alias, toplevel
            FROM
                " . $this->table_name . "
            WHERE
                alias = ?
            LIMIT
                0,1";
  
    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(1, $this->alias);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
    $this->naam = $row['naam'];
    $this->id = $row['id'];
    $this->alias = $row['alias'];
}
}
?>
<?php
class instellingen {	

    private $db_prefix = DB . ".instellingen";
    
    function getData(string $query, array $values = null) {
        global $pdo;
        
        try {
                $stmt = $pdo->prepare($query);
                if(!empty($values)) {
                    $stmt->execute($values);
                    $data = $stmt->fetch(PDO::FETCH_OBJ);
                }
                else {
                    $stmt->execute();
                    $data = $stmt->fetchAll(PDO::FETCH_OBJ);
                }
            }
            catch (PDOException $e) {throw new Exception('Database query error');}
            
            return $data;
    }
    
    function btwCodes(int $id = null) {
         $table = $this->db_prefix."_btwcodes";		
        if(!empty($id)) {
            $query = "SELECT * FROM {$table} WHERE (id = :id)";
            $values = array(':id' => $id);
            $result = $this->getData($query,$values);
        }
        else {
            $query = "SELECT * FROM {$table}_btwcodes";
            $result = $this->getData($query);
        }
        
        return $result;
    }
    
    function productTypes(int $id = null) {
        global $pdo; $table = $this->db_prefix."_producttypes";
        if(!empty($id)) {
            $query = "SELECT * FROM {$table} WHERE (id = :id)";
            $values = array(':id' => $id);
            $result = $this->getData($query,$values);
        }
        else {
            $query = "SELECT * FROM {$table}";
            $result = $this->getData($query);
        }
        
        return $result;
    }
}
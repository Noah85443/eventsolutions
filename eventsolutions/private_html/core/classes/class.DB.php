<?php
class DB {	   
    public static function insertFromForm($table, array $dataset) {
        
        global $pdo;
        array_pop($dataset);
        
        if(empty($dataset)) {
            throw new InvalidArgumentException('Er is geen data gevonden om te verwerken');
        }
        if(!is_string($table)) {
            throw new InvalidArgumentException('De tabelnaam is ongeldig.');
        }

        $fields = '`' . implode('`, `', array_keys($dataset)) . '`';
        $placeholders = ':' . implode(', :', array_keys($dataset));

        $sql = "INSERT INTO {$table} ($fields) VALUES ({$placeholders})";

        $stmt = $pdo->prepare($sql);

        foreach($dataset as $placeholder => &$value) {
            $placeholder = ':' . $placeholder;
            $stmt->bindParam($placeholder, $value);
        }

        if(!$stmt->execute()) {
            throw new ErrorException('Er is iets fout gegaan tijdens het verwerken');
        }

        if($stmt->rowCount() == 0) {
            throw new ErrorException('Er is iets fout gegaan tijdens het verwerken.');
        }
        
        $id = $pdo->lastInsertId();
        
        return $id;
    }
    
    public static function updateFromForm($table, array $dataset, int $id) {
        
        global $pdo;
        array_pop($dataset);
        
        if(empty($dataset)) {
            throw new InvalidArgumentException('Er is geen data gevonden om te verwerken');
        }
        if(!is_string($table)) {
            throw new InvalidArgumentException('De tabelnaam is ongeldig.');
        }
        
        $sql = 'UPDATE '.$table.' SET';
        $values = array();

        foreach ($dataset as $placeholder => &$value) {
            $sql .= ' '.$placeholder.' = :'.$placeholder.',';
            $values[':'.$placeholder] = $value;
        }
        
        $sql = substr($sql, 0, -1).' WHERE id = :id'; 
        
        try {
            $stmt = $pdo->prepare($sql);
            $action = $stmt->execute($values);
        }
	catch (PDOException $e) {throw new Exception('Database query error: '.$e->getMessage().'<br>');}
         
        
        if(!$stmt->execute()) {
            throw new ErrorException('Er is iets fout gegaan tijdens het verwerken.');
        }
        
        $row = $stmt->fetchObject();
        
        return true;
    }
}
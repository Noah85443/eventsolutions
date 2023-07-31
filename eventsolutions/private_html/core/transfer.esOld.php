<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$user = 'u10448d24532_ES';
$passwd = 'P2v984nQ';
$pdo = NULL;
$dsn = 'mysql:host='.$host.';';

require_once system.init.php;                                                                            

define('DB', 'u10448d24532_eventsolutionsOld');


$allelocaties = locaties::alleLocaties();
$query = 'SELECT * FROM '.DB.'.locaties WHERE id = :id';
            
$values = array(':id' => $id);
		
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);
	}
	catch (PDOException $e) {throw new Exception('Fout tijdens het samenstellen van het urenregister');}
        
        $result = $stmt->fetchAll(PDO::FETCH_OBJ); 
        
        print_r($result);

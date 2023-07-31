<?php
$host = 'localhost';
$user = 'u10448d24532_ES';
$passwd = 'P2v984nQ';
$pdo = NULL;
$dsn = 'mysql:host='.$host.';';

try {
   $pdo = new PDO($dsn, $user,  $passwd);
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    print 'Fout tijdens het verbinden met de databases'; 
    die();
}

unset($host,$user,$passwd,$dsn);                                                                            

if($mode === "dev") {
    define('DB', 'u10448d24532_esdev');
}
elseif($mode === "live") {
   define('DB', 'u10448d24532_eventsolutions');
}
else {
    die('Invalid DB access token');
}


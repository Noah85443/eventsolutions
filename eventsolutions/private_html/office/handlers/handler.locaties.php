<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../../core/system.init.php';

$actie = filter_input(INPUT_GET, "actie", FILTER_DEFAULT);
$locatieId = filter_input(INPUT_GET, "locatieId", FILTER_VALIDATE_INT);

switch ($actie) {
    case 'locatiedata' :
        $data = locaties::perLocatie($locatieId);
        print json_encode($data, true);
        break;
}
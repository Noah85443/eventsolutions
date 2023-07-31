<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../../core/system.init.php';

$task = filter_input(INPUT_GET, "task", FILTER_DEFAULT);
$dienstNr = filter_input(INPUT_GET, "dienstNr", FILTER_VALIDATE_INT);
$medewerkerId = filter_input(INPUT_GET, "medewerkerId", FILTER_VALIDATE_INT);
$status = filter_input(INPUT_GET, "status", FILTER_VALIDATE_INT);

if($task == 'plan') {
    $beschikbaarId = filter_input(INPUT_GET, "beschikbaarId", FILTER_VALIDATE_INT);
    
    crewBeschikbaarheid::updateBeschikbaarheid($beschikbaarId, $status);
    crewPlanning::inplannen($dienstNr, $medewerkerId);
    
    print json_encode(array('success' => 1));
}
elseif($task == "unplan") {
    $planningId = filter_input(INPUT_GET, "planningId", FILTER_VALIDATE_INT);
    
    crewPlanning::wijzigen($planningId, $status);
    
    print json_encode(array('success' => 1));
}
elseif($task == "replan") {
    $planningId = filter_input(INPUT_GET, "planningId", FILTER_VALIDATE_INT);
    
    crewPlanning::wijzigen($planningId, $status);
    
    print json_encode(array('success' => 1));
    
}
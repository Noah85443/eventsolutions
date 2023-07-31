<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../../core/system.init.php';

$actie = filter_input(INPUT_GET, "actie", FILTER_DEFAULT);
$projectId = filter_input(INPUT_GET, "projectId", FILTER_VALIDATE_INT);

switch ($actie) {
    case 'wijzigStatus' :
        $status = filter_input(INPUT_GET, "status", FILTER_DEFAULT);
        projecten::updateStatus($projectId, $status);
        print json_encode(array('success' => 1));
        break;

    case 'wijzigUrenStatus' :
        $urenId = filter_input(INPUT_GET, "urenId", FILTER_VALIDATE_INT);
        $status = filter_input(INPUT_GET, "status", FILTER_VALIDATE_INT);
        crewUren::updateStatus($urenId, $status);
        print json_encode(array('success' => 1));
        break;
    
    case 'wijzigDeclaratieStatus' :
        $declaratieId = filter_input(INPUT_GET, "declaratieId", FILTER_VALIDATE_INT);
        $status = filter_input(INPUT_GET, "status", FILTER_VALIDATE_INT);
        crewDeclaraties::updateStatus($declaratieId, $status);
        print json_encode(array('success' => 1));
        break;
    
    case 'wijzigFactuurStatus' :
        $declaratieId = filter_input(INPUT_GET, "declaratieId", FILTER_VALIDATE_INT);
        $status = filter_input(INPUT_GET, "status", FILTER_VALIDATE_INT);
        crewDeclaraties::updateFactuurStatus($declaratieId, $status);
        print json_encode(array('success' => 1));
        break;
    
    case 'urenAanbieden' :
        $projectId = filter_input(INPUT_GET, "projectId", FILTER_VALIDATE_INT);
        projecten::updateStatus($projectId, "project_wachten_op_goedkeuring_data");
        
        notificaties::verstuurUrenValidatie($projectId);
        
        print json_encode(array('success' => 1));
        break;
}
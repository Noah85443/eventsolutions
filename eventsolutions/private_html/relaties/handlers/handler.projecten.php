<?php
require_once '../../core/system.init.php';

$actie = filter_input(INPUT_GET, "actie", FILTER_DEFAULT);
$projectId = filter_input(INPUT_GET, "projectId", FILTER_VALIDATE_INT);

switch ($actie) {
    case 'urenGoedkeuren' :
        $status = "project_data_goedgekeurd";
        projecten::updateStatus($projectId, $status);
        print json_encode(array('success' => 'uren succesvol goedgekeurd'));
        break;
}
?>
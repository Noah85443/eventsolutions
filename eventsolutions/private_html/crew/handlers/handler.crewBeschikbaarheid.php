<?php
require_once '../../core/system.init.php';
require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;

$projectId = filter_input(INPUT_GET, "projectId", FILTER_VALIDATE_INT);
$dienstNr = filter_input(INPUT_GET, "dienstNr", FILTER_VALIDATE_INT);
$status = filter_input(INPUT_GET, "status", FILTER_VALIDATE_INT);
$medewerkerId = filter_input(INPUT_GET, "medewerkerId", FILTER_VALIDATE_INT);

$action = crewBeschikbaarheid::toevoegen($projectId, $dienstNr, $status, $medewerkerId);

if ($status == 1) {
	echo "<div class=\"btn btn-success\">Beschikbaar</div>";
}
elseif($status == 2) {
	echo "<div class=\"btn btn-danger\">Niet beschikbaar</div>";
}
?>
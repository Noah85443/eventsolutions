<?php
require_once '../../core/system.init.php';
require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;

if(isset($_POST['action']) or isset($_GET['view'])) {
    if(isset($_GET['view'])) {
        header('Content-Type: application/json');

        $result = crewPlanning::perMedewerker($_GET['id'], "ingepland");

        for($x=0; $x<count($result); $x++) {
            $dienstInfo = crewDiensten::perDienst($result[$x]->dienstNr);
            $projectInfo = projecten::perProject($dienstInfo->projectId);

            $start = $dienstInfo->datum .' '. $dienstInfo->tijdBegin;
            $end = $dienstInfo->datum .' '. $dienstInfo->tijdEinde;
            $url = '/planning/'.$result[$x]->dienstNr;
            
            $events[] = array(
                'id' => $result[$x]->dienstNr,
                'title' => $projectInfo->projectNaam,
                'start' => $start,
                'end' => $end,
                'url' => $url
            );
        } 
        print json_encode($events); 
        exit;
    }
}
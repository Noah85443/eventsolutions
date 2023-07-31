<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../core/database.php';
include_once '../../core/system.init.php';
include_once '../core/tokenAuth.php';
include_once '../objects/project.php';

checkBearerToken();
  
$database = new Database();
$db = $database->getConnection();
  
$project = new Project($db);

$data = file_get_contents('php://input');
$data = json_decode($data);

if(!empty($data)){
    
    http_response_code(200);
    $return = $project->nieuw_project($data);
    echo json_encode($return, true);
    
    $subject = "Kopie van offerte-aanvraag {$data->bron}";
    $message = "Beste {$data->contactgegevens->voornaam},<br />"
            . "Hartelijk dank voor je aanvraag!<br />"
            . "We gaan aan de slag om ervoor te zorgen dat je feest onvergetelijk wordt :)<br /><br />"
            . "De volgende gegevens hebben we opgeslagen om je een voorstel te kunnen doen:<br /><br />"
            . "Aanvrager: {$data->contactgegevens->voornaam} {$data->contactgegevens->tussenvoegsel} {$data->contactgegevens->achternaam}<br />"
            . "Woonplaats: {$data->contactgegevens->adres->plaats}<br />"
            . "E-mail: {$data->contactgegevens->email}<br />"
            . "Telefoonnummer: {$data->contactgegevens->telefoonnummer}<br /><br />"
            . "Aanvoerdatum: ".convert::datumKort($data->aanvoerdatum)."<br />"
            . "Huurperiode: ".convert::datumKort($data->huurperiode_start)." - ".convert::datumKort($data->huurperiode_eind)."<br />"
            . "Retourdatum: ".convert::datumKort($data->retourdatum)."<br /><br />"
            . "Leveringsconditie: {$data->levering}<br />";
            if($data->levering == "bezorgen") {
            $message .= "Bezorgadres:<br />"
            . $data->bezorgadres->straat ." ". $data->bezorgadres->huisnummer."<br />"
            . $data->bezorgadres->postcode . " " . $data->bezorgadres->plaats . " (" . $data->bezorgadres->land.")<br /><br />";
            }
            $message .= "Aangevraagde artikelen:<br />";
            for($x=0;$x<count($data->artikelen);$x++) {
               $message .=  "- " . $data->artikelen[$x]->aantal . "x " . $data->artikelen[$x]->naam. "<br />";
            }
    
   
    sendMail::sendit($data->contactgegevens->email, $subject, $message);
    
    $subject = "Nieuwe verhuuraanvraag via {$data->bron}";
    sendMail::sendit("backoffice@eventsolutions.nu", $subject, $message);
	
}
  
else {
    http_response_code(404);

    echo json_encode(
        array("message" => "Er is iets misgegaan onderweg... We konden je gegevens niet opslaan.<br />Probeer het alsjeblieft opnieuw of neem contact met ons op.")
    );
}
<?php
require_once '../core/system.init.php';

$userId = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$planning = crewPlanning::perMedewerker($userId,"ingepland");

function dateToCal(string $datum, $tijd) {
    $timestamp = date('Ymd\THis', strtotime($datum . $tijd));
    // Ymd\THis\Z
    
    return $timestamp;
}

function nowToCal() {
    return date('Ymd\THis\Z', time());
}

function escapeString($string) {
  return preg_replace('/([\,;])/','\\\$1', $string);
}

    $eol = "\r\n";
    $load = "BEGIN:VCALENDAR" . $eol .
    "VERSION:2.0" . $eol .
    "METHOD:PUBLISH" . $eol .
    "PRODID:-//eventsolutions-calendar/axel/v1.0//EN" . $eol .
"CALSCALE:GREGORIAN" . $eol .
"X-WR-CALNAME:EventSolutionsCrew" . $eol .
"X-WR-TIMEZONE:Europe/Amsterdam" . $eol .
"BEGIN:VTIMEZONE" . $eol .
"TZID:Europe/Amsterdam" . $eol .
"X-LIC-LOCATION:Europe/Amsterdam" . $eol .
"BEGIN:DAYLIGHT" . $eol .
"TZOFFSETFROM:+0100" . $eol .
"TZOFFSETTO:+0200" . $eol .
"TZNAME:CEST" . $eol .
"DTSTART:19700329T020000" . $eol .
"RRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=-1SU" . $eol .
"END:DAYLIGHT" . $eol .
"BEGIN:STANDARD" . $eol .
"TZOFFSETFROM:+0200" . $eol .
"TZOFFSETTO:+0100" . $eol .
"TZNAME:CET" . $eol .
"DTSTART:19701025T030000" . $eol .
"RRULE:FREQ=YEARLY;BYMONTH=10;BYDAY=-1SU" . $eol .
"END:STANDARD" . $eol .
"END:VTIMEZONE" . $eol;
    

for($x=0; $x<count($planning); $x++) {
    
    $dienstInfo = crewDiensten::perDienst($planning[$x]->dienstNr);
    $projectInfo = projecten::perProject($dienstInfo->projectId);
    $functieNaam = crewProducten::perProduct($dienstInfo->functieId)->productNaam;
    $locatieInfo = locaties::perLocatie($projectInfo->locatie);
    
    if ($dienstInfo->tijdBegin < $dienstInfo->tijdEinde) {
            $datumEinde = $dienstInfo->datum;
        }
        else {
            $datumEinde = date('Y-m-d', strtotime("+1 day", strtotime($dienstInfo->datum)));
	}
        
    $load .= 
        "BEGIN:VEVENT" . $eol .
            "UID:crew-" . $userId . $planning[$x]->dienstNr . "@eventsolutions.nu" . $eol .
            "DTSTART:" . dateToCal($dienstInfo->datum,$dienstInfo->tijdBegin) . $eol .
            "DTEND:" . dateToCal($datumEinde,$dienstInfo->tijdEinde) . $eol .
            "DTSTAMP:" . nowToCal() . $eol .
            "STATUS:CONFIRMED". $eol . 
            "SUMMARY:" . htmlspecialchars($projectInfo->projectNaam) . $eol .
            "DESCRIPTION:" . htmlspecialchars($functieNaam) . $eol .
            "LOCATION:" . $locatieInfo->straat . " " . $locatieInfo->postcode ." ".$locatieInfo->plaats . $eol .
            "URL;VALUE=URI:https://crew.eventsolutions.nu/planning" . $eol .
            "LAST-MODIFIED:" . nowToCal() . $eol .
       "END:VEVENT" . $eol;
}
    $load .= "END:VCALENDAR";
    
    $filename="CrewCalendar";
    header('Content-type: text/calendar; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename.".ics");
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

    // Dump load
    echo $load;
?>
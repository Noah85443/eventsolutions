<?php
$accessLevel = array("crew");
require_once '../core/system.init.php';
require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;

$dienstNr = filter_input(INPUT_GET, "dienstNr", FILTER_VALIDATE_INT);

$dienstInfo = crewDiensten::perDienst($dienstNr);
$projectInfo = projecten::perProject($dienstInfo->projectId);
$locatieNaam = locaties::perLocatie($projectInfo->locatie)->locatieNaam;
$userData = $account->getUserData();

if (isset($_POST['nieuweUren'])) {
    $dataset = filter_input_array(INPUT_POST);

    try {
        $action = crewUren::urenToevoegen($userData->linked_crew, $dienstInfo->projectId, $dienstNr, $dataset['datum'], $dataset['tijdBegin'], $dataset['tijdEinde'], $dataset['tijdPauze'], 1);
    } catch (Exception $e) {
        print "<div class=\"notification error\">Er ging iets fout...: " . $e->getMessage() . "</div>";
    }

    if (!empty($action)) {
        print "<div class=\"notification success\">Uren succesvol geregistreerd in het systeem.<br /><br />Het unieke volgnummer is " . $action . "<br /><br /><a href=\"#\" onclick=\"window.close();\">Sluit venster</a></div>";
    }
    exit();
}
?>

<main>
    <div class="blocks">   
        <?php
        print ""
                . "<h2>Gewerkte uren toevoegen</h2>"
                . "<p>Project: {$projectInfo->projectNaam}</h2>"
                . "<p>Datum: {$dienstInfo->datum}</p>"
                . "<p>Geplande werktijd: {$dienstInfo->tijdBegin} - {$dienstInfo->tijdEinde}</p>";
        ?>
        <form method="post">
            <div class="formField">
                <label for="datum">Datum</label><br />
                <input type="date" name="datum" value="<?php print $dienstInfo->datum; ?>" required />
            </div>
            <br />
            <div class="formField">
                <label for="tijdBegin">Begintijd</label><br />
                <input type="time" name="tijdBegin" value="<?php print $dienstInfo->tijdBegin; ?>" required />
            </div>
            <br />
            <div class="formField">
                <label for="tijdEinde">Eindtijd</label><br />
                <input type="time" name="tijdEinde" value="<?php print $dienstInfo->tijdEinde; ?>" required />
            </div>
            <br />
            <div class="formField">
                <label for="tijdPauze">Pauzeduur</label><br />
                <input type="time" name="tijdPauze" required />
            </div>
            <br />
            <div class="formControls">
                <input type="submit" name="nieuweUren" value="Uren doorgeven" />
            </div>
        </form>
    </div>
</main>
<?php
require_once '../core/system.init.php';
require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;

$projectId = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

$diensten = crewDiensten::perProject($projectId);
$projectInfo = projecten::perProject($projectId);


if (isset($_POST['nieuweUren'])) {
    $dataset = filter_input_array(INPUT_POST);

    try {
        $action = crewUren::urenToevoegen($dataset['medewerkerId'], $projectId, $dataset['dienstNr'], $dataset['datum'], $dataset['tijdBegin'], $dataset['tijdEinde'], $dataset['tijdPauze'], 2);
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
                . "<h2>Gewerkte uren toevoegen (admin)</h2>"
                . "<p>Project: {$projectInfo->projectNaam}</h2>";
        ?>
        <form method="post">
            <div class="formField">
                <label for="dienstNr">Functie</label><br />
                <select name="dienstNr" id="dienstNr">
                    <option value="0" disabled selected>Geen gekoppelde dienst</option>
                    <?php 
                        foreach($diensten as $dienst => $info) {
                            $dienstNaam = crewProducten::perProduct($info->functieId)->productNaam;
                            print "<option value=\"{$dienst}\">{$dienstNaam} ({$info->datum} | {$info->tijdBegin} - {$info->tijdEinde})</option>";
                        }
                    ?>
                </select>
            </div>
            <br />
            <div class="formField">
                <label for="medewerkerId">Medewerker</label><br />
                <select name="medewerkerId" id="medewerkerId">
                    <option value="0" disabled selected>Geen gekoppelde medewerker</option>
                    <?php 
                        $medewerkers = crewMembers::alleMedewerkers();
                        for($x=0;$x<count($medewerkers);$x++) {
                            print "<option value=\"{$medewerkers[$x]->id}\">{$medewerkers[$x]->voornaam} {$medewerkers[$x]->tussenvoegsel} {$medewerkers[$x]->achternaam} </option>";
                        }
                    ?>
                </select>
            </div>
            <br />
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
<?php
require_once '../core/system.init.php';
require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;

$dienstId = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$dienstInfo = crewDiensten::perDienst($dienstId);
$projectInfo = projecten::perProject($dienstInfo->projectId);
$diensten = crewProducten::perProductType(1);

if (isset($_POST['wijzigDienst'])) {
    $dataset = filter_input_array(INPUT_POST);
    unset($dataset['wijzigDienst']);

    try {
        $action = crewDiensten::wijzigDienst($dataset,$dataset['id']);
    } catch (Exception $e) {
        print "<div class=\"notification error\">Er ging iets fout...: " . $e->getMessage() . "</div>";
    }

    if (!empty($action)) {
        print "<div class=\"notification success\">Dienst succesvol gewijzigd in het systeem.<br /><br />Het unieke volgnummer is " . $action . "<br /><br /><a href=\"#\" onclick=\"window.close();\">Sluit venster</a></div>";
    }
    exit();
}
?>

<main>
    <div class="blocks">   
        <?php
        print ""
                . "<h2>Dienst wijzigen</h2>"
                . "<p>Project: {$projectInfo->projectNaam}</h2>";
        ?>
        <form method="post">
            <div class="formField">
                <label for="functieId">Functie</label><br />
                <select name="functieId" id="functieId">
                    <option value="0" disabled selected>Geen gekoppelde functie</option>
                    <?php 
                        foreach($diensten as $id => $info) {
                            print "<option value=\"{$info->id}\"";
							if($info->id == $dienstInfo->functieId) {print "selected";}
							print ">{$info->productNaam} (&euro; {$info->verkoopprijs})</option>";
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
                <label for="aantal">Aantal</label><br />
                <input type="text" name="aantal" value="<?php print $dienstInfo->aantal; ?>" required />
            </div>
            <div class="formField">
                <label for="zichtbaar">Zichtbaar</label><br />
                <input type="text" name="zichtbaar" value="1" value="<?php print $dienstInfo->zichtbaar; ?>" required />
            </div>
            <br />
            <div class="formControls">
                <input type="hidden" name="id" value="<?php print $dienstId; ?>" required />
                <input type="submit" name="wijzigDienst" value="Uren doorgeven" />
                <input type="hidden" name="toegevoegdDoor" id="toegevoegdDoor" value="<?php print $account->getUserData()->linked_crew; ?>" />
            </div>
        </form>
    </div>
</main>
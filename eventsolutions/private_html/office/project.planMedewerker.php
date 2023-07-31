<?php
require_once '../core/system.init.php';
require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;

$projectNr = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

$projectInfo = projecten::perProject($projectNr);
$locatieNaam = locaties::perLocatie($projectInfo->locatie)->locatieNaam;
$userData = $account->getUserData();

if (isset($_POST['planMedewerker'])){
 $dataset = filter_input_array(INPUT_POST);
 
 try {
  $action = crewPlanning::inplannen($dataset['dienstNr'],$dataset['medewerkerId'],$projectInfo->id,$dataset['afwijkendBegin'],$dataset['afwijkendEinde']);
 }
 catch (Exception $e) {
  print "<div class=\"notification error\">Er ging iets fout...: ".$e->getMessage()."</div>";
 }
 
 if(!empty($action)) {
  print "<div class=\"notification success\">Medewerker is verwerkt in de planning.<br /><br />Het unieke volgnummer is ".$action.".</div>";
 }
}
?>

<main>
 <div class="blocks">   
        <?php
        print ""
        . "<h2>Medewerker inplannen (projectmodus)</h2>"
        . "<p>Project: {$projectInfo->projectNaam}</h2>"
        . "<p>Datum: {$projectInfo->datumBegin} - {$projectInfo->datumEind}</p>"
        ?>
     
        <form method="post">
            <div class="formField">
                <label for="dienstNr">Functie</label><br />
                <select name="dienstNr" id="dienstNr">
                    <option value="0" disabled selected>Geen gekoppelde dienst</option>
                    <?php 
                        $diensten = crewDiensten::perProject($projectNr);
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
            <br /><br />
            <div class="formField">
                <label for="afwijkendBegin">Afwijkende begintijd</label><br />
                <input type="time" name="afwijkendBegin" id="afwijkendBegin" />
            </div>
            <br />
            <div class="formField">
                <label for="afwijkendEinde">Afwijkende eindtijd</label><br />
                <input type="time" name="afwijkendEinde" id="afwijkendEinde" />
            </div>
            <br />
            <div class="formControls">
                <input type="submit" name="planMedewerker" value="Medewerker inplannen" />
            </div>
	</form>
    </div>
</main>
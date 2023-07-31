<?php
require_once '../core/system.init.php';
require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;

$projectId = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$uren = crewUren::perProject($projectId);
$projectInfo = projecten::perProject($projectId);

if (isset($_POST['nieuweDeclaratie'])){
 $dataset = filter_input_array(INPUT_POST);

 try {
  $action = crewDeclaraties::declaratieToevoegen($dataset['medewerkerId'], $projectInfo->id, $dataset['productId'], $dataset['product_type'], $dataset['declaratieNaam'], $dataset['specificatie'], 1, 1,$dataset['urenId'], $dataset['aantal'], $dataset['waarde']);
 }
 catch (Exception $e) {
  print "<div class=\"notification error\">Er ging iets fout...: ".$e->getMessage()."</div>";
 }
 
 if(!empty($action)) {
  print "<div class=\"notification success\">Declaratie succesvol geregistreerd in het systeem.<br /><br />Het unieke volgnummer is ".$action.".</div>";
 }
exit();
 }
?>

<html>
    <head>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>
<body>
<main>
    <div class="container">
    <div class="card">
 <div class="card-content">   
        <?php
        print ""
        . "<h6>Declaratie toevoegen</h6>"
        . "Project: {$projectInfo->projectNaam}";

        ?>
        <form method="post">
            <div class="formFieldAlways">
                <label for="urenId">Urenregel</label><br />
                <select name="urenId" id="urenId">
                    <option value="0" disabled selected>Geen gekoppelde dienst</option>
                    <?php 
                        foreach($uren as $shift => $info) {
                            $urenInfo = crewUren::dataPerRegel($info->id);
                            $medewerkerNaam = crewMembers::getCrew($urenInfo['medewerker']);
                            print "<option value=\"{$info->id}\">{$medewerkerNaam->voornaam} {$medewerkerNaam->tussenvoegsel} {$medewerkerNaam->achternaam} ({$urenInfo['uren']['datumKort']} | {$urenInfo['uren']['begin']} - {$urenInfo['uren']['eind']})</option>";
                        }
                    ?>
                </select>
            </div>
            <br />
            <div class="formFieldAlways">
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
            <div class="formFieldSelect">
                <label for="productId">Soort declaratie</label>
                <select name="productId" id="productId">
                    <optgroup label="Reiskosten">
                        <option value="8">Reiskostenvergoeding algemeen</option>
                        <option value="25">Reiskosten - Van Overbeek</option>
                    </optgroup>
                    <optgroup label="Projectkosten">
                        <option value="9">Overnachtingsvergoeding</option>
                        <option value="30">Hotelkosten</option>
                        <option value="31">Cateringkosten (BTW Laag)</option>
                    </optgroup>
                    <optgroup label="Overig">
                        <option value="20">Declaratie overig - 21% BTW</option>
                        <option value="21">Declaratie overig - 9% BTW</option>
                    </optgroup>
                </select>
                <br />
            </div>
            <div class="formField 8 25">
                <label for="aantal">Aantal Kilometers</label>
                <input type="number" name="aantal" id="aantal" min="2" />
                <br />
            </div>
            <div class="formField 20 21 30 31">
                <label for="waarde">Bedrag exclusief BTW</label>
                <input type="number" name="waarde" id="waarde" min="1" step="0.01" />
                <br />
            </div>
            <div class="formField 20 21">
                <label for="declaratieNaam">Aanschaflocatie</label>
                <input type="text" name="declaratieNaam" id="declaratieNaam" /> 
                <br />
            </div>
            <div class="formField 8 9 20 21 25 30 31">
                <label for="specificatie">Specificatie (Omschrijving / Reden / Route / Locatie)</label>
                <input type="text" name="specificatie" id="specificatie" required />
                <br />
            </div>
            <div class="formControls">
                <label for="product_type">Type (2=Vaste stukprijs, 3=reiskosten, 4=variable stukprijs)</label>
                <input type="text" name="product_type" value="" />
                <input type="hidden" name="dienstId" value="<?php print $urenInfo['dienstNr']; ?>" />
                <input type="submit" name="nieuweDeclaratie" value="Declaratie doorgeven" />
            </div>
	</form>
    </div>
    </div>
    </div>

<?php        require_once FOOTER; ?>
<script>
$(document).ready(function(){
    $("select#productId").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue){
                $(".formField").not("." + optionValue).hide();
                $("." + optionValue).show();
            } else{
                $(".formField").hide();
            }
        });
    }).change();
});
</script>
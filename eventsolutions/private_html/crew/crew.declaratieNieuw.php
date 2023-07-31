<?php
$accessLevel = array("crew");
require_once '../core/system.init.php';
require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;



$urenId = filter_input(INPUT_GET, "urenId", FILTER_VALIDATE_INT);
$urenInfo = crewUren::perUrenId($urenId);
$projectInfo = projecten::perProject($urenInfo['projectId']);
$locatieNaam = locaties::perLocatie($projectInfo->locatie)->locatieNaam;
$userData = $account->getUserData();

if (isset($_POST['nieuweDeclaratie'])){
 $dataset = filter_input_array(INPUT_POST);
 
 try {
  $action = crewDeclaraties::declaratieToevoegen($userData->linked_crew, $projectInfo->id, $dataset['productId'], $dataset['product_type'], $dataset['declaratieNaam'], $dataset['specificatie'], 1, 1, $urenId, $dataset['aantal'], $dataset['waarde']);
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
        . "Project: {$urenInfo['project']} <br />"
        . "Functie: {$urenInfo['dienstNaam']}<br />"
        . "Datum: {$urenInfo['uren']['datum']}<br /><br />";
        ?>
        <form method="post">
            <div class="formFieldSelect">
                <label for="productId">Soort declaratie</label>
                <select name="productId" id="productId">
                    <optgroup label="Reiskosten">
                        <option value="8">Reiskostenvergoeding algemeen</option>
                        <option value="25">Reiskosten - Van Overbeek</option>
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
                <input type="text" name="declaratieNaam" id="declaratieNaam" value='Reiskosten' /> 
                <br />
            </div>
            <div class="formField 8 9 20 21 25 30 31">
                <label for="specificatie">Specificatie (Omschrijving / Reden / Route / Locatie)</label>
                <input type="text" name="specificatie" id="specificatie" required />
                <br />
            </div>
            <div class="formControls">
                <input type="hidden" name="product_type" value="3" />
                <input type="hidden" name="dienstId" value="<?php print $urenInfo['dienstNr']; ?>" />
                <input type="submit" name="nieuweDeclaratie" value="Declaratie doorgeven" />
            </div>
	</form>
    </div>
    </div>
<?php        require_once FOOTER; ?>
<script>
$(document).ready(function(){
    $("select").change(function(){
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
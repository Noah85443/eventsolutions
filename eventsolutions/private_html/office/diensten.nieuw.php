<?php
 $accessLevel = array("admin");
 require_once '../core/system.init.php';
 require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
 require_once FRAMEWORK;
?>

<main>
<?php
// handler
if (isset($_POST['nieuweDienst'])){
 $dataset = filter_input_array(INPUT_POST);
 
 try {
  $action = crewDiensten::nieuweDienst($dataset);
 }
 catch (Exception $e) {
  print "<div class=\"notification error\">Er ging iets fout...: ".$e->getMessage()."</div>";
 }
 
 if(!empty($action)) {
  print "<div class=\"notification success\">Nieuwe dienst aangemaakt. Dienstnummer: ".$action.".</div>";
 }
}

$projectId = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
?>
    <div class="blocks">
        <h2>Nieuwe dienst toevoegen aan project</h2>	
        <form method="post">
            <div class="block-50">
                <h2>Algemene gegevens</h2>        	
                <div class="formField">
                    <label for="projectId">Projectnummer</label>
                    <input type="text" name="projectId" id="projectId" value="<?php print $projectId; ?>" readonly  />
                </div>
                <div class="formField">
                    <label for="functieId">Functie</label>
                    <select name="functieId" id="functieId">
                        <option value="0">Geen gekoppelde functie (Functie onbekend)</option>
                        <?php 
                        $producten = crewProducten::perProductType(1);
                        for($x=0;$x<count($producten);$x++) {
                            print "<option value=\"{$producten[$x]->id}\">{$producten[$x]->productNaam} ({$producten[$x]->verkoopprijs})</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="formField">
                    <label for="aantal">Aantal</label>
                    <input type="number" name="aantal" id="aantal" min="1"  />
                </div>
            </div>
            <div class="block-50">
                <h2>Datum en tijd</h2>        	
                <div class="formField">
                    <label for="datum">Datum</label>
                    <input type="date" name="datum" id="datum" />
                </div>                
                <div class="formField">
                    <label for="tijdBegin">Begintijd</label>
                    <input type="time" name="tijdBegin" id="tijdBegin" />
                </div>                
                <div class="formField">
                    <label for="tijdEinde">Eindtijd</label>
                    <input type="time" name="tijdEinde" id="tijdEinde" />
                </div>
           </div>
            <div class="block-50 links">
                <h2>Notities (openbaar)</h2>        	
                <div class="formField" style="height:115px;">
                    <textarea name="notitiesCrew" id="notitiesCrew" cols="50" rows="8"></textarea>
                </div>.
            </div>
            <div class="block-50 links">
                <h2>Notities (admin only)</h2>        	
                <div class="formField" style="height:115px;">
                    <textarea name="notitiesAdmin" id="notitiesAdmin" cols="50" rows="8"></textarea>
                </div>.
            </div>
            <div class="block-50 links">
                <h2>Functie-eisen</h2>        	
                <div class="formField" style="height:115px;">
                    <textarea name="functieEisen" id="functieEisen" cols="50" rows="8"></textarea>
                </div>.
            </div>
            <div class="block-50 links">
                <h2>Overige</h2>        	
                <div class="formField">
                    <label for="declaratiesToegestaan">Declaratiebeleid</label>
                    <select name="declaratiesToegestaan" id="declaratiesToegestaan">
                        <option value="1">Declaraties mogelijk door crew</option>
                        <option value="0">Geen declaraties mogelijk</option>
                        <option value="2">Alleen door admin</option>
                    </select>
                </div>
                <div class="formField">
                    <label for="zichtbaar">Zichtbaarheid</label>
                    <select name="zichtbaar" id="zichtbaar">
                        <option value="1">Tonen</option>
                        <option value="0">Verbergen</option>
                    </select>
                </div>
            </div>
            <div class="block-100">
                <div class="formControls">
                    <input type="submit" name="nieuweDienst" value="Aanmaken" />
                </div>		
            </div>
        </form>
    </div>
</main>
<?php
    require_once FOOTER;
?>
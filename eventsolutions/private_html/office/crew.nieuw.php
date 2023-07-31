<?php
 $accessLevel = array("admin");
 require_once '../core/system.init.php';
 require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
 require_once FRAMEWORK;
?>

<main>
<?php
// handler
if (isset($_POST['newCrewMember'])){
 $dataset = filter_input_array(INPUT_POST);
 
 try {
  $action = crewMembers::newCrew($dataset);
 }
 catch (Exception $e) {
  print "<div class=\"notification error\">Er ging iets fout...: ".$e->getMessage()."</div>";
 }
 
 if(!empty($action)) {
  print "<div class=\"notification success\">Nieuwe medewerker succesvol aangemaakt. Medewerkersnummer: ".$action.".</div>";
 }
}
?>
    <div class="blocks">
        <h2>Nieuwe medewerker toevoegen</h2>	
        <form method="post">
            <div class="block-50">
                <h2>Persoonsgegevens</h2>        	
                <div class="formField">
                    <label for="voorletters">Voorletters</label>
                    <input type="text" name="voorletters"  />
                </div>
                <div class="formField">
                    <label for="voornaam">Voornaam</label>
                    <input type="text" name="voornaam"  />
                </div>
                <div class="formField">
                    <label for="tussenvoegsel">Tussenvoegsel</label>
                    <input type="text" name="tussenvoegsel"  />
                </div>
                <div class="formField">
                    <label for="achternaam">Achternaam</label>
                    <input type="text" name="achternaam"  />
                </div>
            </div>
            <div class="block-50">
                <h2>Adresgegevens</h2>        	
                <div class="formField">
                    <label for="straatnaam">straatnaam</label>
                    <input type="text" name="straatnaam"  />
                </div>
                <div class="formField">
                    <label for="huisnummer">huisnummer</label>
                    <input type="text" name="huisnummer"  />
                </div>
                <div class="formField">
                    <label for="huisnummerToevoeging">toevoeging</label>
                    <input type="text" name="huisnummerToevoeging"  />
                </div>
                <div class="formField">
                    <label for="postcode">postcode</label>
                    <input type="text" name="postcode"  />
                </div>
                <div class="formField">
                    <label for="woonplaats">woonplaats</label>
                    <input type="text" name="woonplaats"  />
                </div>
            </div>
            <div class="block-50 links">
                <h2>Geboortegegevens</h2>        	
                <div class="formField">
                    <label for="geboortedatum">geboortedatum</label>
                    <input type="text" name="geboortedatum"  />
                </div>
                <div class="formField">
                    <label for="geboorteplaats">geboorteplaats</label>
                    <input type="text" name="geboorteplaats"  />
                </div>
                <div class="formField">
                    <label for="geboorteland">geboorteland</label>
                    <input type="text" name="geboorteland"  />
                </div>
            </div>
            <div class="block-50">
                <h2>Vervoer</h2>        	
                <div class="formField">
                    <label for="rijbewijs">rijbewijs?</label>
                    <input type="text" name="rijbewijs"  />
                </div>
                <div class="formField">
                    <label for="eigenAuto">Auto?</label>
                    <input type="text" name="eigenAuto"  />
                </div>
                <div class="formField">
                    <label for="eigenAutoPlaatsen">hoeveel plekken?</label>
                    <input type="text" name="eigenAutoPlaatsen"  />
                </div>
            </div>

            <div class="block-50">
                <h2>Betaalgegevens</h2>        	
                <div class="formField">
                    <label for="rekeningnummer">rekeningnummer</label>
                    <input type="text" name="rekeningnummer"  />
                </div>
                <div class="formField">
                    <label for="rekeninghouder">rekeninghouder</label>
                    <input type="text" name="rekeninghouder"  />
                </div>
                <div class="formField">
                    <label for="checkedRekening">Gecontroleerd?</label>
                    <input type="text" name="checkedRekening"  />
                </div>
                <div class="formField">
                    <label for="loonheffing">Loonheffing</label>
                    <input type="text" name="loonheffing"  />
                </div>
            </div>
                        <div class="block-50 rechts">
                <h2>Contactgegevens</h2>        	
                <div class="formField">
                    <label for="telefoon">Telefoonnr</label>
                    <input type="text" name="telefoon"  />
                </div>
                <div class="formField">
                    <label for="email">E-mailadres</label>
                    <input type="text" name="email"  />
                </div>               
            </div>
            <div class="block-50">
                <h2>Overig</h2>        	
                <div class="formField">
                    <label for="deelGegevens">gegens delen?</label>
                    <input type="text" name="deelGegevens"  />
                </div>
                <div class="formField">
                    <label for="status">Status</label>
                    <input type="text" name="status"  />
                </div>
                <div class="formField">
                    <label for="checkedId">ID Gecontroleerd?</label>
                    <input type="text" name="checkedId"  />
                </div>
            </div>
            <div class="block-100">
                <div class="formControls">
                    <input type="submit" name="newCrewMember" value="Aanmaken" />
                </div>		
            </div>
        </form>
    </div>
</main>
<?php
 require_once FOOTER;
?>
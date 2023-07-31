<?php
$accessLevel = array("crew");
require_once '../core/system.init.php';
require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
require_once FRAMEWORK;

if (isset($_POST['editCrewMember'])){
    $dataset = filter_input_array(INPUT_POST);
 
    try {
        $action = crewMembers::updateCrew($dataset,$dataset['id']);
    }
    catch (Exception $e) {
   print '<div class="alert alert-danger" role="alert">
            Er ging iets fout...: '.$e->getMessage().'
         </div>';
 }
 
    if($action) {
       print '<div class="alert alert-success" role="alert">
            Gegevens succesvol gewijzigd.
          </div>';
 }
    
    else {
        print '<div class="alert alert-danger" role="alert">
            Er ging iets fout.<br />De gegevens zijn niet gewijzigd.
         </div>';
    }
}

$dataset = crewMembers::getCrew($userData->linked_crew);
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">manage_accounts</span>
       <span class="text-secondary">Gegevens &nbsp; > &nbsp; </span>
       <span class=""><?php print $dataset->voornaam.' '.$dataset->tussenvoegsel.' '.$dataset->achternaam; ?></span>
   </h4> 
</div>
 <form method="post" class="">
<div class="container">
    <div class="row mb-5">
        <div class="col px-4">
            <h6 class="pb-3">Volledige naam</h6>
            <div class="mb-3 form-floating">
                <input type="text" class="form-control" name="voorletters" value="<?php print $dataset->voorletters; ?>" required />
                <label for="voorletters">Voorletters</label>
            </div>
            <div class="mb-3 form-floating">
                <input type="text" class="form-control" name="voornaam" value="<?php print $dataset->voornaam; ?>" required />
                <label for="voornaam">Voornaam</label>
            </div>
            <div class="mb-3 form-floating">
                 <input type="text" class="form-control" name="tussenvoegsel" value="<?php print $dataset->tussenvoegsel; ?>" />
                 <label for="tussenvoegsel">Tussenvoegsel</label>
            </div>
            <div class="mb-3 form-floating">
                <input type="text" class="form-control" name="achternaam" value="<?php print $dataset->achternaam; ?>" required />
                <label for="achternaam">Achternaam</label>
            </div>
        </div>
        <div class="col px-4">
            <h6 class="pb-3">Contactgegevens</h6>
            <div class="mb-3 form-floating">
                <input name="email" class="form-control" type="text" value="<?php print $dataset->email; ?>" class="validate">
                <label for="email">E-mailadres</label>
            </div>
            <div class="mb-3 form-floating">
                <input name="telefoon" class="form-control" type="text" value="<?php print $dataset->telefoon; ?>" class="validate">
                 <label for="telefoon">Telefoonnummer</label>   
            </div>
        </div>
        <div class="col px-4">
            <h6 class="pb-3">Adresgegevens</h6>
            <div class="mb-3 form-floating">
                <input name="straatnaam" class="form-control" type="text" value="<?php print $dataset->straatnaam; ?>" class="validate">
                <label for="address">Straatnaam</label>
            </div>
            <div class="mb-3 form-floating input-group">
                <input name="huisnummer" class="form-control" type="text" value="<?php print $dataset->huisnummer; ?>" class="validate">
                 <label for="huisnummer">Nummer | Toevoeging</label>
                 <input name="huisnummerToevoeging" class="form-control" type="text" value="<?php print $dataset->huisnummerToevoeging; ?>"  class="validate">
            </div>
            <div class="mb-3 form-floating">
                
            </div>
            <div class="mb-3 form-floating">
                <input name="postcode" class="form-control" type="text" value="<?php print $dataset->postcode; ?>" class="validate">
                <label for="postcode">Postcode</label>
            </div>
            <div class="mb-3 form-floating">
                <input name="woonplaats" class="form-control" type="text" value="<?php print $dataset->woonplaats; ?>" class="validate">
                <label for="woonplaats">Woonplaats</label>
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col px-4">
            <h6 class="pb-3">Geboortegegevens</h6>
            <div class="mb-3 form-floating">
                <input name="geboortedatum" class="form-control" type="text" value="<?php print $dataset->geboortedatum; ?>" class="validate">
                <label for="geboortedatum">Geboortedatum</label>
            </div>
           <div class="mb-3 form-floating">
                <input name="geboorteplaats" class="form-control" type="text" value="<?php print $dataset->geboorteplaats; ?>" class="validate">
                <label for="geboorteplaats">Geboorteplaats</label>
            </div>
            <div class="mb-3 form-floating">
                <input name="geboorteland" class="form-control" type="text" value="<?php print $dataset->geboorteland; ?>" class="validate">
                <label for="land">Geboorteland</label>
            </div>
        </div>
        <div class="col px-4">
            <h6 class="pb-3">Rijbewijs & Auto</h6>
            <div class="mb-3 form-floating">
                <select name="rijbewijs" class="form-select">
                    <option value="1" <?php if($dataset->rijbewijs == 1) {print "selected";} ?>>B-rijbewijs</option>
                    <option value="0" <?php if($dataset->rijbewijs == 0) {print "selected";} ?>>Geen rijbewijs</option>
                </select>
                <label for="rijbewijs">Heb je een rijbewijs?</label>
            </div>
            <div class="mb-3 form-floating">
                <select name="eigenAuto" class="form-select">
                    <option value="1" <?php if($dataset->eigenAuto == 1) {print "selected";} ?>>Eigen auto</option>
                    <option value="0" <?php if($dataset->eigenAuto == 0) {print "selected";} ?>>Geen eigen auto</option>
                </select>
                <label for="eigenAuto">Heb je een eigen auto?</label>
                
            </div>
           <div class="mb-3 form-floating">
                <select name="eigenAutoPlaatsen" class="form-select">
                    <option value="0" <?php if($dataset->eigenAutoPlaatsen == 0) {print "selected";} ?>>Ik heb geen auto</option>
                    <option value="1" <?php if($dataset->eigenAutoPlaatsen == 1) {print "selected";} ?>>1 extra plek</option>
                    <option value="2" <?php if($dataset->eigenAutoPlaatsen == 2) {print "selected";} ?>>2 extra plekken</option>
                    <option value="3" <?php if($dataset->eigenAutoPlaatsen == 3) {print "selected";} ?>>3 extra plekken</option>
                    <option value="4" <?php if($dataset->eigenAutoPlaatsen == 4) {print "selected";} ?>>4 extra plekken</option>
                    <option value="5" <?php if($dataset->eigenAutoPlaatsen == 5) {print "selected";} ?>>5 extra plekken</option>
                    <option value="6" <?php if($dataset->eigenAutoPlaatsen == 6) {print "selected";} ?>>6 extra plekken</option>
                    <option value="7" <?php if($dataset->eigenAutoPlaatsen == 7) {print "selected";} ?>>7 extra plekken</option>
                    <option value="8" <?php if($dataset->eigenAutoPlaatsen == 8) {print "selected";} ?>>8 extra plekken</option>
                </select>
               <label for="eigenAutoPlaatsen">Hoeveel mensen kunnen er meerijden?</label>
            </div>
        </div>
        <div class="col px-4">
            <h6 class="pb-3">Betalingsgegevens</h6>
            <div class="mb-3 form-floating">
                <input name="rekeningnummer" class="form-control" type="text" value="<?php print $dataset->rekeningnummer; ?>" class="validate">
                <label for="rekeningnummer">Rekeningnummer</label>
            </div>
            <div class="mb-3 form-floating">
                <input name="rekeninghouder" class="form-control" type="text" value="<?php print $dataset->rekeninghouder; ?>" class="validate">
                <label for="rekeninghouder">Rekeninghouder</label>
                
            </div>
            <div class="mb-3 form-floating">
                <select name="checkedRekening" class="form-select" disabled>
                    <option value="1" <?php if($dataset->checkedRekening == 1) {print "selected";} ?>>Geverifieerd</option>
                    <option value="0" <?php if($dataset->checkedRekening == 0) {print "selected";} ?>>Niet geverifieerd</option>
                </select>
                 <label for="checkedRekening">Rekening geverifieerd?</label>
            </div>
            <div class="mb-3 form-floating">
                <select name="loonheffing" class="form-select">
                    <option value="1" <?php if($dataset->loonheffing == 1) {print "selected";} ?>>Aan</option>
                    <option value="0" <?php if($dataset->loonheffing == 0) {print "selected";} ?>>Uit</option>
                </select>
                 <label for="loonheffing">Loonheffingskorting aan</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col px-4">
            <h6 class="pb-3">AVG / Gegevensdeling</h6>
            <div class="mb-3 form-floating">
                <select name="deelGegevens" class="form-select">
                    <option value="1" <?php if($dataset->deelGegevens == 1) {print "selected";} ?>>Ja</option>
                    <option value="0" <?php if($dataset->deelGegevens == 0) {print "selected";} ?>>Nee</option>
                </select>
                <label for="deelGegevens">Mogen we je gegevens delen?</label>
            </div>
            
        </div>
        <div class="col px-4">
            <h6 class="pb-3">Accountstatus</h6>
            <div class="mb-3 form-floating">
                <select name="status" class="form-select" disabled>
                    <option value="1" <?php if($dataset->status == 1) {print "selected";} ?>>Ja</option>
                    <option value="0" <?php if($dataset->status == 0) {print "selected";} ?>>Nee</option>
                </select>
                <label for="status">Account actief?</label>
            </div>
        </div>
        <div class="col px-4">
            <h6 class="pb-3">ID Validatie</h6>
            <div class="mb-3 form-floating">
                <select name="checkedId" class="form-select" disabled>
                    <option value="1" <?php if($dataset->checkedId == 1) {print "selected";} ?>>Ja</option>
                    <option value="0" <?php if($dataset->checkedId == 0) {print "selected";} ?>>Nee</option>
                </select>
                <label for="checkedId">ID gecontroleerd?</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col px-4 my-4">
            <input type="text" name="id" value="<?php print $dataset->id; ?>" hidden />
            <button type="submit" name="editCrewMember" class="btn btn-success">Gegevens Wijzigen</button>
        </div>
    </div>
</div>
</form>

<?php
    require_once FOOTER;
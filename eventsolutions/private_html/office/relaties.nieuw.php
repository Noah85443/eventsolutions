<?php
 $accessLevel = array("admin");
 require_once '../core/system.init.php';
 require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
 require_once FRAMEWORK;
 
 // handler
if (isset($_POST['nieuweRelatie'])){
 $dataset = filter_input_array(INPUT_POST);
 
 try {
  $action = locaties::nieuweRelatie($dataset);
 }
 catch (Exception $e) {
   print '<div class="alert alert-danger" role="alert">
            Er ging iets fout...: '.$e->getMessage().'
         </div>';
 }
 
 if(!empty($action)) {
   print '<div class="alert alert-success" role="alert">
            Nieuwe relatie aangemaakt. Relatienummer: '.$action.' 
          </div>';
 }
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">business</span>
       <span class="text-secondary">Relaties &nbsp; > &nbsp; </span>
       <span>Nieuw</span>
   </h4> 
</div>
<form method="post">
    <div class="row py-3">
        <h6>Algemene gegevens</h6>
        <div class="col">
            <div class="form-floating">
                <input type="text" name="klant_naam" id="klant_naam" class="form-control" required />
                <label for="klant_naam">Klantnaam</label> 
            </div>
        </div>
    </div>
    <div class="row py-3">
            <div class="col-md-12 form-floating">
                <select name="klant_type" id="klant_type" class="form-control">
                    <option value="onbekend">Onbekend</option>
                    <option value="bedrijf">Zakelijke klant (B2B)</option>
                    <option value="consument">Cosument (B2C)</option>
                    <option value="stichting">Stichting/Vereniging</option>
                </select>
                <label for="klant_type">Klanttype</label>
               
            </div>
        </div>
        <div class="row py-3">
            <h6>Zakelijke gegevens (alleen voor B2B klanten)</h6>
            <div class="col-md-6 form-floating">
                <input type="text" name="zakelijk_kvk" id="zakelijk_kvk" class="form-control" />
                <label for="zakelijk_kvk">KvK-nummer</label>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" name="zakelijk_btw" id="zakelijk_btw" class="form-control" />
                <label for="zakelijk_btw">BTW-ID</label>
            </div>
        </div>
    <div class="row py-3">
        <h6>Adresgegevens</h6>
            <div class="col-md-12 form-floating">
                <input type="text" name="straat" id="straat" class="form-control" required />
                <label for="straat">Straat en huisnummer</label>
            </div>
        </div>
        <div class="row py-3">
            <div class="col-md-3 form-floating">
                <input type="text" name="postcode" id="postcode" class="form-control" required />
                <label for="postcode">Postcode</label>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" name="plaats" id="plaats" class="form-control" required />
                <label for="plaats">Plaats</label>
            </div>
            <div class="col-md-3 form-floating">
                <input type="text" name="land" id="land" class="form-control" required />
                <label for="land">Land</label>
            </div>
        </div>
        <div class="row py-3">
            <h6>Contactgegevens algemeen</h6>
            <div class="col-md-6 form-floating">
                <div class="form-floating">
                    <input type="email" name="email" id="email" class="form-control" required />
                    <label for="email">E-mailadres algemeen</label> 
                </div>
            </div>
            <div class="col-md-6 form-floating">
               <div class="form-floating">
                    <input type="text" name="telefoonnummer" id="telefoonnummer" class="form-control" />
                    <label for="telefoonnummer">Telefoonnummer</label>
                </div>
            </div>
        </div>
        <div class="row py-3">
            <h6>Contactgegevens facturatie</h6>
            <div class="col-md-6 form-floating">
                <input type="text" name="factuur_email" id="factuur_email" class="form-control" />
                <label for="factuur_email">E-mailadres facturen</label>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" name="factuur_tav" id="factuur_tav" class="form-control" />
                <label for="factuur_tav">Tenaamstelling factuurberichten</label>
            </div>
        </div>
    
    <div class="row py-3">
        <div class="col">
            <div class="form-floating">
                    <input type="hidden" name="aangemaakt_door" id="aangemaakt_door" value="<?php print $account->getUserData()->linked_crew; ?>" />
                     <input type="hidden" name="status" id="status" value="1" />
                    <button type="submit" class="btn btn-success" name="nieuweRelatie">Aanmaken</button>
            </div>
        </div>
    </div>
</form>
<?php
    require_once FOOTER;
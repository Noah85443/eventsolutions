<?php
 $accessLevel = array("admin");
 require_once '../core/system.init.php';
 require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
 require_once FRAMEWORK;
 
 // handler
if (isset($_POST['updateRelatie'])){
 $dataset = filter_input_array(INPUT_POST);
 
 try {
  $action = relaties::bewerkRelatie($dataset,$dataset['id']);
 }
 catch (Exception $e) {
   print '<div class="alert alert-danger" role="alert">
            Er ging iets fout...: '.$e->getMessage().'
         </div>';
 }
 
 if(!empty($action)) {
   print '<div class="alert alert-success" role="alert">
            Relatie met succes bewerkt Relatienummer: '.$action.' 
          </div>';
 }
}

 $data_id =  filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
 $dataset = relaties::perRelatie($data_id);
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">business</span>
       <span class="text-secondary">Relaties &nbsp; > &nbsp; 
       <?php print $dataset->klant_naam; ?> &nbsp; > &nbsp; </span>
       <span>Bewerken</span>
   </h4> 
</div>
<nav class="mb-5">
    <ul class="nav nav-pills" >
        <li class="nav-item"><a class="nav-link text-secondary" href="/relaties/dashboard">Alle relaties</a></li>
        <li class="nav-item"><a class="nav-link " href="/relaties/overzicht/<?php print $dataset->id; ?>">Overzicht</a></li>       
        <li class="nav-item"><a class="nav-link active" href="/relaties/bewerken/<?php print $dataset->id; ?>">Bewerken</a></li>
    </ul>
</nav>
<form method="post">
    <div class="row py-3">
        <h6>Algemene gegevens</h6>
        <div class="col">
            <div class="form-floating">
                <input type="text" name="klant_naam" id="klant_naam" class="form-control"  value="<?php print $dataset->klant_naam; ?>" required />
                <label for="klant_naam">Klantnaam</label> 
            </div>
        </div>
    </div>
    <div class="row py-3">
            <div class="col-md-12 form-floating">
                <select name="klant_type" id="klant_type" class="form-control">
                    <option <?php if($dataset->klant_type == "bedrijf"){print "selected=\"selected\"";} ?> value="bedrijf">Zakelijke klant (B2B)</option>
                    <option <?php if($dataset->klant_type == "consument"){print "selected=\"selected\"";} ?>value="consument">Cosument (B2C)</option>
                </select>
                <label for="klant_type">Klanttype</label>
               
            </div>
        </div>
        <div class="row py-3">
            <h6>Zakelijke gegevens (alleen voor B2B klanten)</h6>
            <div class="col-md-6 form-floating">
                <input type="text" name="zakelijk_kvk" id="zakelijk_kvk" class="form-control" value="<?php print $dataset->zakelijk_kvk; ?>"  />
                <label for="zakelijk_kvk">KvK-nummer</label>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" name="zakelijk_btw" id="zakelijk_btw" class="form-control" value="<?php print $dataset->zakelijk_btw; ?>"  />
                <label for="zakelijk_btw">BTW-ID</label>
            </div>
        </div>
    <div class="row py-3">
        <h6>Adresgegevens</h6>
            <div class="col-md-12 form-floating">
                <input type="text" name="straat" id="straat" class="form-control"  value="<?php print $dataset->straat; ?>" required />
                <label for="straat">Straat en huisnummer</label>
            </div>
        </div>
        <div class="row py-3">
            <div class="col-md-3 form-floating">
                <input type="text" name="postcode" id="postcode" class="form-control" value="<?php print $dataset->postcode; ?>"  required />
                <label for="postcode">Postcode</label>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" name="plaats" id="plaats" class="form-control" value="<?php print $dataset->plaats; ?>"  required />
                <label for="plaats">Plaats</label>
            </div>
            <div class="col-md-3 form-floating">
                <input type="text" name="land" id="land" class="form-control" value="<?php print $dataset->land; ?>"  required />
                <label for="land">Land</label>
            </div>
        </div>
        <div class="row py-3">
            <h6>Contactgegevens algemeen</h6>
            <div class="col-md-6 form-floating">
                <div class="form-floating">
                    <input type="email" name="email" id="email" class="form-control" value="<?php print $dataset->email; ?>"  required />
                    <label for="email">E-mailadres algemeen</label> 
                </div>
            </div>
            <div class="col-md-6 form-floating">
               <div class="form-floating">
                    <input type="text" name="telefoonnummer" id="telefoonnummer" class="form-control" value="<?php print $dataset->telefoonnummer; ?>"  />
                    <label for="telefoonnummer">Telefoonnummer</label>
                </div>
            </div>
        </div>
        <div class="row py-3">
            <h6>Contactgegevens facturatie</h6>
            <div class="col-md-6 form-floating">
                <input type="text" name="factuur_email" id="factuur_email" class="form-control" value="<?php print $dataset->factuur_email; ?>"  />
                <label for="factuur_email">E-mailadres facturen</label>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" name="factuur_tav" id="factuur_tav" class="form-control" value="<?php print $dataset->factuur_tav; ?>"  />
                <label for="factuur_tav">Tenaamstelling factuurberichten</label>
            </div>
        </div>
    <div class="row py-3">
            <div class="col-md-6 form-floating">
                <input type="text" name="moneybirdId" id="moneybirdId" class="form-control" value="<?php print $dataset->moneybirdId; ?>" readonly />
                <label for="moneybirdId">Moneybird-ID</label>
            </div>
        </div>
    
    <div class="row py-3">
        <div class="col">
            <div class="form-floating">
                    <input type="hidden" name="id" value="<?php print $dataset->id; ?>"  />
                    <button type="submit" class="btn btn-success" name="updateRelatie">Wijzigen</button>
            </div>
        </div>
    </div>
</form>
<?php
    require_once FOOTER;
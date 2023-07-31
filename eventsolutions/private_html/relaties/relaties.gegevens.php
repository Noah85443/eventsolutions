<?php
    $accessLevel = array("relatie");
    require_once '../core/system.init.php';
    require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
    require_once FRAMEWORK;
 
    if (isset($_POST['editCompany'])){
        $dataset = filter_input_array(INPUT_POST);
        try {
            $action = relaties::bewerkRelatie($dataset, $dataset['id']);
        }
        catch (Exception $e) {
               print '<div class="alert alert-danger" role="alert">
                Er ging iets fout...: '.$e->getMessage().'
                </div>';
        }
        
        if(!empty($action)) {
            print '<div class="alert alert-success" role="alert">
            Gegevens zijn succesvol verwerkt. 
          </div>';
        }
    }
    $userData = $account->getUserData();
    $data = relaties::perRelatie($userData->linked_customer);
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">manage_accounts</span>
       <span class="text-secondary">Klantgegevens &nbsp; > &nbsp;</span>
       <span>Bewerken</span>
   </h4> 
</div>
<form method="post">
    <div class="row">
        <div class="col-6 p-4">
             <div class="form-floating mb-3">
                <select name="klant_type" id="klant_type" class="form-select">
                    <option <?php if($data->klant_type == "bedrijf"){print "selected=\"selected\"";} ?> value="bedrijf">Zakelijke klant (B2B)</option>
                    <option <?php if($data->klant_type == "consument"){print "selected=\"selected\"";} ?>value="consument">Consument (B2C)</option>
                </select>
                <label for="klant_type">Klanttype</label>
            </div>
            <div class="form-floating">
                <input type="text" name="klant_naam" id="klant_naam" class="form-control" value="<?php print $data->klant_naam ?>" />
                <label for="klant_naam">Naam</label>
            </div>
        </div>
        <div class="col-6 p-4">
            <div class="form-floating mb-3">
                <input type="text" name="straat" id="straat" class="form-control" value="<?php print $data->straat ?>" required />
                <label for="straat">Straatnaam + Huisnummer (+ Toevoeging)</label>
            </div>
            <div class="row  mb-3">
                <div class="form-floating col-4">
                    <input type="text" name="postcode" id="postcode" class="form-control" value="<?php print $data->postcode ?>" required />
                    <label for="postcode" class="ms-2">Postcode</label>
                </div>
                <div class="form-floating col-8">
                    <input type="text" name="plaats" id="plaats" class="form-control" value="<?php print $data->plaats ?>" required />
                    <label for="plaats" class="ms-2">Plaats</label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6 p-4">
            <div class="form-floating mb-3">
                <input type="email" name="email" id="email" class="form-control" value="<?php print $data->email ?>" />
                <label for="email">E-mailadres</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="telefoonnummer" id="telefoonnummer" class="form-control" value="<?php print $data->telefoonnummer ?>" />
               <label for="telefoonnummer">Telefoonnummer</label>
            </div>
        </div>
        <div class="col-6 p-4">
            <div class="form-floating mb-3">
                <input type="email" name="factuur_email" id="factuur_email" class="form-control" value="<?php print $data->factuur_email ?>" />
                <label for="factuur_email">E-mailadres facturen</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="factuur_tav" id="factuur_tav" class="form-control" value="<?php print $data->factuur_tav ?>" />
                <label for="factuur_tav">Contactpersoon facturen</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6 p-4">
            <p class="fst-italic mb-1">Alleen voor zakelijke klanten:</p>
            <div class="form-floating mb-3">
                <input type="text" name="zakelijk_kvk" id="zakelijk_kvk" class="form-control" value="<?php print $data->zakelijk_kvk ?>" />
                <label for="zakelijk_kvk">KVK Nummer</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="zakelijk_btw" id="zakelijk_btw" class="form-control" value="<?php print $data->zakelijk_btw ?>" />
                <label for="zakelijk_btw">BTW-Id</label>
            </div>
        </div>
        <div class="col-6 p-4">
            <input type="number" name="id" value="<?php print $data->id; ?>" hidden />
            <input type="number" name="moneybirdId" value="<?php print $data->moneybirdId; ?>" hidden />
            <button type="submit" name="editCompany" class="btn btn-success float-end">Wijzig gegevens</button>
        </div>
    </div>
</form>
<?php
 require_once FOOTER;
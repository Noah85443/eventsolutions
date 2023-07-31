<?php
 $accessLevel = array("admin");
 require_once '../core/system.init.php';
 require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
 require_once FRAMEWORK;

// handler
if (isset($_POST['nieuweLocatie'])){
 $dataset = filter_input_array(INPUT_POST);
 
 try {
  $action = locaties::nieuweLocatie($dataset);
 }
 catch (Exception $e) {
   print '<div class="alert alert-danger" role="alert">
            Er ging iets fout...: '.$e->getMessage().'
         </div>';
 }
 
 if(!empty($action)) {
   print '<div class="alert alert-success" role="alert">
            Nieuwe locatie aangemaakt. Locatienummer: '.$action.' 
          </div>';
 }
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">place</span>
       <span class="text-secondary">Locaties &nbsp; > &nbsp; </span>
       <span>Nieuw</span>
   </h4> 
</div>
<form method="post">
    <div class="row py-3">
        <h6>Algemene gegevens</h6>
        <div class="col">
            <div class="form-floating">
                <input type="text" name="locatieNaam" id="locatieNaam" class="form-control" required />
                <label for="locatieNaam">Naam</label> 
            </div>
        </div>
    </div>
    <div class="row py-3">
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
        <h6>Relatie</h6>
        <div class="col">
            <div class="form-floating">
                    <select name="klantId" id="klantId" class="form-control">
                        <option value="0">Geen gekoppelde klant</option>
                        <?php 
                        $relaties = relaties::alleRelaties();
                        for($x=0;$x<count($relaties);$x++) {
                            print "<option value=\"{$relaties[$x]->id}\">{$relaties[$x]->klant_naam}, {$relaties[$x]->plaats} ({$relaties[$x]->klant_type})</option>";
                        }
                        ?>
                    </select>
                    <label for="klantId">Klant</label>
            </div>
        </div>
    </div>
    <div class="row py-3">
        <div class="col">
            <div class="form-floating">
                <input type="text" name="website" id="website" class="form-control" required />
                <label for="website">Website</label> 
            </div>
        </div>
    </div>
    <div class="row py-3">
        <div class="col">
            <div class="form-floating">
                    <input type="hidden" name="aangemaakt_door" id="aangemaakt_door" value="<?php print $account->getUserData()->linked_crew; ?>" />
                    <button type="submit" class="btn btn-success" name="nieuweLocatie">Aanmaken</button>
            </div>
        </div>
    </div>
</form>
<?php
    require_once FOOTER;
<?php
 $accessLevel = array("admin");
 require_once '../core/system.init.php';
 require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
 require_once FRAMEWORK;
 
 if (isset($_POST['updateLocatie'])){
 $dataset = filter_input_array(INPUT_POST);

 
 try {
  $action = locaties::bewerkLocatie($dataset,$dataset['id']);
 }
 catch (Exception $e) {
  print '<div class="alert alert-danger" role="alert">
            Er ging iets fout...: '.$e->getMessage().'
            </div>';
 }
 
 if(!empty($action)) {
    print '<div class="alert alert-success" role="alert">
            Locatie met succes bewerkt! 
            </div>';
 }
}
 
 $data_id =  filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
 $dataset = locaties::perLocatie($data_id);
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">place</span>
       <span class="text-secondary">Locaties &nbsp; > &nbsp;
       <?php print $dataset->locatieNaam; ?> &nbsp; > &nbsp;</span>
       <span>Bewerken</span>
   </h4> 
</div>
<nav class="mb-5">
    <ul class="nav nav-pills" >
        <li class="nav-item"><a class="nav-link text-secondary" href="/locaties/dashboard">Alle locaties</a></li>
        <li class="nav-item"><a class="nav-link " href="/locaties/overzicht/<?php print $dataset->id; ?>">Overzicht</a></li>       
        <li class="nav-item"><a class="nav-link active" href="/locaties/bewerken/<?php print $dataset->id; ?>">Bewerken</a></li>
    </ul>
</nav>
<form method="post">
    <div class="row py-3">
        <h6>Algemene gegevens</h6>
        <div class="col">
            <div class="form-floating">
                <input type="text" name="locatieNaam" id="locatieNaam" class="form-control" value="<?php print $dataset->locatieNaam; ?>" required />
                <label for="locatieNaam">Naam</label> 
            </div>
        </div>
    </div>
    <div class="row py-3">
            <div class="col-md-12 form-floating">
                <input type="text" name="straat" id="straat" class="form-control" value="<?php print $dataset->straat; ?>" required />
                <label for="straat">Straat en huisnummer</label>
            </div>
        </div>
        <div class="row py-3">
            <div class="col-md-3 form-floating">
                <input type="text" name="postcode" id="postcode" class="form-control" value="<?php print $dataset->postcode; ?>" required />
                <label for="postcode">Postcode</label>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" name="plaats" id="plaats" class="form-control" value="<?php print $dataset->plaats; ?>" required />
                <label for="plaats">Plaats</label>
            </div>
            <div class="col-md-3 form-floating">
                <input type="text" name="land" id="land" class="form-control" value="<?php print $dataset->land; ?>" required />
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
                            if($dataset->klantId == $relaties[$x]->id) {
                                print "<option selected=\"selected\"value=\"{$relaties[$x]->id}\">{$relaties[$x]->klant_naam}, {$relaties[$x]->plaats} ({$relaties[$x]->klant_type})</option>".PHP_EOL;
                            }
                            else {
                                print "<option value=\"{$relaties[$x]->id}\">{$relaties[$x]->klant_naam}, {$relaties[$x]->plaats} ({$relaties[$x]->klant_type})</option>";
                            }
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
                <input type="text" name="website" id="website" class="form-control" value="<?php print $dataset->website; ?>" />
                <label for="website">Website</label> 
            </div>
        </div>
    </div>
    <div class="row py-3">
        <div class="col">
            <div class="form-floating">
                    <input type="hidden" name="aangemaakt_door" id="aangemaakt_door" value="<?php print $account->getUserData()->linked_crew; ?>" />
                    <input type="hidden" name="id" id="id" value="<?php print $dataset->id; ?>" />
                    <button type="submit" class="btn btn-success" name="updateLocatie">Aanmaken</button>
            </div>
        </div>
    </div>
</form>
<?php
    require_once FOOTER;
?>
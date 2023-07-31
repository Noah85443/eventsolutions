<?php
 $accessLevel = array("admin");
 require_once '../core/system.init.php';
 require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
 require_once FRAMEWORK;
?>

<main>
<?php
// handler
if (isset($_POST['updateProject'])){
 $dataset = filter_input_array(INPUT_POST);
 unset($dataset['updateProject']);
 
 try {
  $action = projecten::updateProject($dataset,$dataset['id']);
 }
 catch (Exception $e) {
  print '<div class="alert alert-danger" role="alert">
            Er ging iets fout...: '.$e->getMessage().'
            </div>';
 }
 
 if(!empty($action)) {
    print '<div class="alert alert-success" role="alert">
            Project met succes bewerkt! 
            </div>';
 }
}

$projectId =  filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$dataset = projecten::perProject($projectId);
$dataset->locatie = json_decode($dataset->locatie);
$locaties = locaties::alleLocaties();
$relaties = relaties::alleRelaties();
$status = projecten::statusId();

?>
    
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">fact_check</span>
       <span class="text-secondary">Projecten &nbsp; > &nbsp; 
       <?php print $dataset->projectNaam; ?> &nbsp; > &nbsp; </span>
       <span>Bewerken</span>
   </h4> 
</div>
<nav class="mb-5">
    <ul class="nav nav-pills" >
        <li class="nav-item"><a class="nav-link" href="/projecten/overzicht/<?php print $dataset->id; ?>">Overzicht</a></li>       
        <li class="nav-item"><a class="nav-link active" href="/projecten/bewerken/<?php print $dataset->id; ?>">Gegevens</a></li>
        <li class="nav-item"><a class="nav-link" href="/projecten/materialen/<?php print $dataset->id; ?>">Materialen</a></li>
        <li class="nav-item"><a class="nav-link" href="/projecten/planning/<?php print $dataset->id; ?>">Planning</a></li>
        <li class="nav-item"><a class="nav-link" href="/projecten/uren/<?php print $dataset->id; ?>">Uren</a></li>
        <li class="nav-item"><a class="nav-link" href="/projecten/declaraties/<?php print $dataset->id; ?>">Declaraties</a></li>
    </ul>
</nav>
<form method="post">
    <div class="row py-3">
        <h6>Algemene gegevens</h6>
        <div class="col-md-8">
            <div class="form-floating">
                <input type="text" name="projectNaam" id="projectNaam" class="form-control" value="<?php print $dataset->projectNaam; ?>" required />
                <label for="projectNaam">Naam</label> 
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-floating">
                <input type="text" name="klantKenmerk" id="klantKenmerk" class="form-control" value="<?php print $dataset->klantKenmerk; ?>" />
                <label for="klantKenmerk">Eigen kenmerk klant</label> 
            </div>
        </div>
    </div>
    <div class="row py-3">
        <div class="col-md">
            <div class="form-floating">
                    <input type="date" name="datumBegin" id="datumBegin" class="form-control" value="<?php print $dataset->datumBegin; ?>" required  />
                    <label for="datumBegin">Begindatum</label>
            </div>
        </div>
        <div class="col-md">
            <div class="form-floating">
                    <input type="date" name="datumEind" id="datumEind" class="form-control" value="<?php print $dataset->datumEind; ?>" required  />
                    <label for="datumEind">Einddatum</label>
            </div>
        </div>
    </div>
    <div class="row py-3">
        <h6>Locatie</h6>
        <div class="row">
        <div class="col">
            <div class="form-floating">
                <select name="locatie_id" id="locatie_id" onchange="toonLocatie(this.value)" class="form-control">
                        <option value="0">Selecteer bestaande locatie of wijzig hieronder</option>
                        <?php 
                        for($x=0;$x<count($locaties);$x++) {
                            if($dataset->locatie->locatieId == $locaties[$x]->id) {
                                print "<option selected=\"selected\" value=\"{$locaties[$x]->id}\">{$locaties[$x]->locatieNaam} ({$locaties[$x]->plaats})</option>".PHP_EOL;
                            }
                            else {
                                print "<option value=\"{$locaties[$x]->id}\">{$locaties[$x]->locatieNaam} ({$locaties[$x]->plaats})</option>";
                            }
                        }
                        ?>
                </select>
                <label for="locatie_id">Locatie</label>
            </div>
        </div>
    </div>
        <div class="row py-3">
            <div id="locatiedata"></div>
            <div class="col-md-12 form-floating">
                <input type="text" name="locatie_straat" id="locatie_straat" class="form-control" value="<?php print $dataset->locatie->straat; ?>" required />
                <label for="locatie_straat">Straat en huisnummer</label>
            </div>
        </div><div class="row py-3">
            <div class="col-md-3 form-floating">
                <input type="text" name="locatie_postcode" id="locatie_postcode" class="form-control" value="<?php print $dataset->locatie->postcode; ?>" required />
                <label for="locatie_postcode">Postcode</label>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" name="locatie_plaats" id="locatie_plaats" class="form-control" value="<?php print $dataset->locatie->plaats; ?>" required />
                <label for="locatie_plaats">Plaats</label>
            </div>
            <div class="col-md-3 form-floating">
                <input type="text" name="locatie_land" id="locatie_land" class="form-control" value="<?php print $dataset->locatie->land; ?>" required />
                <label for="locatie_land">Land</label>
            </div>
        </div>
    </div>
    <div class="row py-3">
        <h6>Relatie</h6>
        <div class="col">
            <div class="form-floating">
                    <select name="relatie" id="relatie" class="form-control">
                        <?php 
                        for($x=0;$x<count($relaties);$x++) {
                           if($dataset->relatie == $relaties[$x]->id) {
                                print "<option selected=\"selected\" value=\"{$relaties[$x]->id}\">{$relaties[$x]->klant_naam} ({$relaties[$x]->plaats})</option>".PHP_EOL;
                            }
                            else {
                               print "<option value=\"{$relaties[$x]->id}\">{$relaties[$x]->klant_naam} ({$relaties[$x]->plaats})</option>".PHP_EOL; 
                            }
                        }
                        ?>
                    </select>
                    <label for="relatie">Klant</label>
            </div>
        </div>
    </div>
     <div class="row py-3">
        <h6>Status</h6> 
        <div class="col-md-6">
            <div class="form-floating">
                <select name="status" id="status" class="form-control">
                        <?php 
                        
                        foreach($status as $statusId => $data) {
                            if($dataset->status == $statusId) {
                                print "<option selected=\"selected\" value=\"{$statusId}\">{$data['txt']}</option>".PHP_EOL;
                            }
                            else {
                                print "<option value=\"{$statusId}\">{$data['txt']}</option>";
                            }
                        }
                        ?>
                    </select>
                <label for="status">Status</label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-floating">
                                        
                <select name="toonProject" id="toonProject" class="form-control">
                        <option value="1" <?php if($dataset->toonProject == 1) {print "selected=\"selected\"";} ?>>Zichtbaar</option>
                        <option value="0" <?php if($dataset->toonProject == 0) {print "selected=\"selected\"";} ?>>Niet zichtbaar</option>
                    </select>
                <label for="toonProject">Zichtbaarheid</label>
            </div>
        </div>
     </div>
        <div class="row py-3">
        <div class="col">
            <div class="form-floating">
                    <input type="hidden" name="projectAdmin" id="projectAdmin" value="<?php print $account->getUserData()->linked_crew; ?>" />
                     <input type="hidden" name="id" id="id" value="<?php print $dataset->id; ?>" />
                     <button type="submit" class="btn btn-success" name="updateProject">
                        <span class="material-icons-outlined float-start pe-3">assignment_turned_in</span> 
                        Wijzigingen opslaan
                     </button>
            </div>
        </div>
    </div>
</form>
</main>
<?php
    require_once FOOTER;
?>
<script>
function toonLocatie(str) {
  if (str === "") {
    document.getElementById("locatie_straat").value= "";
    document.getElementById("locatie_postcode").value= "";
    document.getElementById("locatie_plaats").value= "";
    document.getElementById("locatie_land").value= "";
    return;
  }
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    var dataset = JSON.parse(this.responseText);
    document.getElementById("locatie_straat").value= dataset.straat;
    document.getElementById("locatie_postcode").value= dataset.postcode;
    document.getElementById("locatie_plaats").value= dataset.plaats;
    document.getElementById("locatie_land").value= dataset.land;
    
    
  }
  xhttp.open("GET", "/handlers/handler.locaties.php?actie=locatiedata&locatieId="+str);
  xhttp.send();
}
</script>

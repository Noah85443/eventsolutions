<?php
 $accessLevel = array("admin");
 require_once '../core/system.init.php';
 require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
 require_once FRAMEWORK;

if (isset($_POST['nieuwProject'])){
    $dataset = filter_input_array(INPUT_POST);
    unset($dataset['nieuwProject']);
    try {
        $action = projecten::nieuwProject($dataset);
    }
    catch (Exception $e) {
        print '<div class="alert alert-danger" role="alert">
            Er ging iets fout...: '.$e->getMessage().'
            </div>';
    }
    if(!empty($action)) {
        print '<div class="alert alert-success" role="alert">
            Nieuw project aangemaakt. Projectnummer: '.$action.' 
            </div>';
    }
}
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">fact_check</span>
       <span class="text-secondary">Projecten &nbsp; > &nbsp; </span>
       <span class="">Nieuw</span>
   </h4> 
</div>
<form method="post">
    <div class="row py-3">
        <h6>Algemene gegevens</h6>
        <div class="col">
            <div class="form-floating">
                <input type="text" name="projectNaam" id="projectNaam" class="form-control" required />
                <label for="projectNaam">Naam</label> 
            </div>
        </div>
    </div>
    <div class="row py-3">
        <div class="col-md">
            <div class="form-floating">
                    <input type="date" name="datumBegin" id="datumBegin" class="form-control" required  />
                    <label for="datumBegin">Begindatum</label>
            </div>
        </div>
        <div class="col-md">
            <div class="form-floating">
                    <input type="date" name="datumEind" id="datumEind" class="form-control" required  />
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
                        <option value="0">Kies hier een bestaande locatie of voer hieronder een adres is</option>
                        <?php 
                        $locaties = locaties::alleLocaties();
                        for($x=0;$x<count($locaties);$x++) {
                            print "<option value=\"{$locaties[$x]->id}\">{$locaties[$x]->locatieNaam} ({$locaties[$x]->plaats})</option>";
                        }
                        ?>
                </select>
                <label for="locatie_id">Locatie</label>
            </div>
        </div>
    </div>
        <div class="row py-3">
            <div class="col-md-12 form-floating">
                <input type="text" name="locatie_straat" id="locatie_straat" class="form-control" required />
                <label for="locatie_straat">Straat en huisnummer</label>
            </div>
        </div>
        <div class="row py-3">
            <div class="col-md-3 form-floating">
                <input type="text" name="locatie_postcode" id="locatie_postcode" class="form-control" required />
                <label for="locatie_postcode">Postcode</label>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" name="locatie_plaats" id="locatie_plaats" class="form-control" required />
                <label for="locatie_plaats">Plaats</label>
            </div>
            <div class="col-md-3 form-floating">
                <input type="text" name="locatie_land" id="locatie_land" class="form-control" required />
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
                        $relaties = relaties::alleRelaties();
                        for($x=0;$x<count($relaties);$x++) {
                            print "<option value=\"{$relaties[$x]->id}\">{$relaties[$x]->klant_naam}, {$relaties[$x]->plaats} ({$relaties[$x]->klant_type})</option>";
                        }
                        ?>
                    </select>
                    <label for="relatie">Klant</label>
            </div>
        </div>
    </div>
     <div class="row py-3">
        <h6>Status</h6> 
        <div class="col-md">
            <div class="form-floating">
                <select name="status" id="status" class="form-control">
                        <?php 
                        $status = projecten::statusId();
                        foreach($status as $statusId => $data) {
                            print "<option value=\"{$statusId}\">{$data['txt']}</option>";
                        }
                        ?>
                    </select>
                <label for="status">Status</label>
            </div>
        </div>
        <div class="col-md">
            <div class="form-floating">
                                        
                <select name="toonProject" id="toonProject" class="form-control">
                        <option value="1">Zichtbaar</option>
                        <option value="0">Niet zichtbaar</option>
                    </select>
                <label for="toonProject">Zichtbaarheid</label>
            </div>
        </div>
    </div>
     <div class="row py-3">
        <div class="col">
            <div class="form-floating">
                    <input type="hidden" name="projectAdmin" id="projectAdmin" value="<?php print $account->getUserData()->linked_crew; ?>" />
                    <input type="submit" name="nieuwProject" value="Aanmaken" />
            </div>
        </div>
    </div>
</form>
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
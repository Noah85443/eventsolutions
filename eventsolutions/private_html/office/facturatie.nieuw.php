<?php  
    $accessLevel = array("admin");
    require_once '../core/system.init.php';
    require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
    
    $input = filter_input(INPUT_POST, "nieuweFactuur");
    if(isset($input) && trim($input) != "") {
        $dataset = filter_input_array(INPUT_POST);
        try {
            $action = facturatie::nieuweFactuur($dataset);
        }
        catch (Exception $e) {
            print "<div class=\"notification error\">Er ging iets fout...: ".$e->getMessage()."</div>";
        }
 
        if(!empty($action)) {
            facturatie::updateStatus($action, 1);
            header('Location: /facturatie/nieuw/'.$action);
        }
    }
    
    require_once FRAMEWORK;
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">payments</span>
       <span class="text-secondary">Facturatie &nbsp; > &nbsp; </span>
       <span class="">Nieuw</span>
   </h4> 
</div>
<form method="post">
    <div class="row py-3">
        <div class="col px-3">
            <h6>1. Kies klant</h6>
            <div class="form-floating">
                <select name="relatie" id="relatie" class="form-select">
                    <option value="0">Kies een klant voor facturatie</option>
                    <?php 
                        $relaties = relaties::alleRelaties();
                        for($x=0;$x<count($relaties);$x++) {
                            print "<option value=\"{$relaties[$x]->id}\">{$relaties[$x]->klant_naam} ({$relaties[$x]->plaats})</option>";
                        }
                    ?>
                </select>
                <label for="relatie">Kies een actieve klant</label>
            </div>
        </div>
        <div class="col px-3">
            <h6>2. Kies projecten</h6>
            <div class="form-floating">
                <?php
                            $projecten = projecten::perStatus("project_data_goedgekeurd"); 
                            for($i=0;$i<count($projecten);$i++) { 
				print "
                                    <p><label for=\"projecten{$projecten[$i]->id}\">
                                        <input type=\"checkbox\" name=\"projecten[]\" id=\"projecten{$projecten[$i]->id}\" value=\"{$projecten[$i]->id}\" class=\"form-check-input\" />
                                        <span>{$projecten[$i]->projectNaam}</span>
                                    </label></p>
                                ";
                            } 
                        ?>
            </div>
        </div>
        <div class="col px-3">
            <h6>3. Kies data</h6>
            <div class="form-floating">
                <input type="date" name="datum" value="<?php print date('Y-m-d'); ?>" class="form-control">
                <label for="datum">Factuurdatum</label>
            </div>
            <div class="form-floating mt-3">
                <input type="date" name="vervaldatum" value="<?php print date('Y-m-d', strtotime(' + 8 days')); ?>" class="form-control">
                <label for="vervaldatum">Vervaldatum</label>
            </div>
        </div>
    </div>
    <div class="row py-3">
        <div class="col">
            <input type="submit" name="nieuweFactuur" class="btn btn-info float-end" />
        </div>
    </div>
</form>
<?php require_once FOOTER;
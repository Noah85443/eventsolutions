<?php
require_once '../core/system.init.php';
require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
require_once FRAMEWORK;

$dataset = crewUren::perMedewerker($userData->linked_crew);
 
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">receipt</span>
       Declaraties &nbsp; > &nbsp
       <span class="text-secondary">Voeg toe aan uren
       </span>
   </h4> 
</div>
<div class="row equal-height-grid">
    <?php
        for($x=0; $x<count($dataset); $x++) {            
            $projectInfo = projecten::perProject($dataset[$x]['projectId']);
            if($projectInfo->status == "project_wachten_op_data") {
                $dienstInfo = crewDiensten::perDienst($dataset[$x]['dienstNr']);
                $locatieData = json_decode($projectInfo->locatie);
                $dienstNaam = crewProducten::perProduct($dataset[$x]['dienstId'])->productNaam;
                $locatieNaam = locaties::perLocatie($locatieData->locatieId)->locatieNaam;
                ?>
    <div class="row bg-secondary-subtle rounded-3 p-4 mb-4">
        <div class="col-12 mb-3">
            <h6><?php print $projectInfo->projectNaam; ?></h6>
        </div>
        <div class="col-12">
            <div class="list-group">
                <div class="list-group-item py-4 hstack gap-0">
                    <div class="col-4 ms-3">
                        <?php 
                            print $dienstInfo->datum.'<br />'.convert::datumKort($dienstInfo->tijdBegin).' - '.convert::datumKort($dienstInfo->tijdEinde);
                        ?> 
                    </div>
                    <div class="col-4">
                        <?php
                            print '<ul class="badge-updates">
                                    <li>'.$dienstNaam.'</li>
                                    <li>'.$locatieNaam.'</li>
                                </ul>';
                        ?>
                    </div>
                    <div class="col-4">
                        <a onclick="window.open('/declaratie-nieuw/<?php print $dataset[$x]['id']; ?>','_blank','height=750,width=500');" class="btn btn-outline-secondary float-end me-4">Declaratie invoeren</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
              <?php      
               
            }
        }
    ?>
</div>
<?php
 require_once FOOTER;

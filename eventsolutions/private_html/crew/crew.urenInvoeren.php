<?php
$accessLevel = array("crew");
require_once '../core/system.init.php';
require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
require_once FRAMEWORK;

$data = crewUren::perMedewerkerOpenstaand($userData->linked_crew);
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">schedule</span>
       Urenoverzicht &nbsp; > &nbsp
       <span class="text-secondary">Uren invoeren
       </span>
   </h4> 
</div>
<?php 
for($x=0; $x<count($data); $x++) { 
    $dienstInfo = crewDiensten::perDienst($data[$x]->dienstNr);   
    $projectInfo = projecten::perProject($dienstInfo->projectId);
    $locatieData = json_decode($projectInfo->locatie);
    $dienstNaam = crewProducten::perProduct($dienstInfo->functieId)->productNaam;
    $locatieNaam = locaties::perLocatie($locatieData->locatieId)->locatieNaam;
	
	if($projectInfo->status == "project_wachten_op_data") {
?>
    <div class="row bg-secondary-subtle rounded-3 p-4 mb-4">
        <div class="col-12 mb-3">
            <h6><?php print $dienstNaam; ?></h6>
            <?php
                print $projectInfo->projectNaam; 
            ?>
        </div>
        <div class="col-12">
            <div class="list-group">
                <div class="list-group-item py-4 hstack gap-0">
                    <div class="col-4 ms-3">
                        <?php 
                            print '<span class="fw-semibold">'.$dienstInfo->datum.'</span><br />'.
                            convert::tijdKort($dienstInfo->tijdBegin) . ' - ' . convert::tijdKort($dienstInfo->tijdEinde); 
                        ?> 
                    </div>
                    <div class="col-4">
                        <?php
                            print $dienstNaam.'<br />';
                            print $locatieNaam;
                        ?>
                    </div>
                    <div class="col-4">
                        <a onclick="window.open('/uren-nieuw/<?php print $data[$x]->dienstNr; ?>','_blank','height=520,width=325');" class="btn btn-outline-secondary float-end me-4">+ Uren invoeren</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
	}
}
 require_once FOOTER;
?>
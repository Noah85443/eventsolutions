<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

    $accessLevel = array("crew");
    require_once '../core/system.init.php';
    require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
    require_once FRAMEWORK;
     
    $dataset = crewPlanning::perMedewerker($userData->linked_crew,"ingepland");
	for($x=0; $x < count($dataset); $x++) {
		$dataset[$x]->datum = crewDiensten::perDienst($dataset[$x]->dienstNr)->datum;
	}
function date_compare($element1, $element2) {
    $datetime1 = strtotime($element1->datum);
    $datetime2 = strtotime($element2->datum);
    return $datetime1 - $datetime2;
} 
usort($dataset, 'date_compare');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">event_available</span>
       <span class="text-secondary">Planning &nbsp; > &nbsp; </span>
       <span class="">Agenda</span>
   </h4> 
</div>

 <?php
        for($x=0; $x < count($dataset); $x++) {
			$dienst = crewDiensten::perDienst($dataset[$x]->dienstNr);			
            $projectInfo = projecten::perProject($dataset[$x]->projectId);
            $locatieNaam = locaties::perLocatie($projectInfo->locatie)->locatieNaam;
            (object) $adres = json_decode($projectInfo->locatie);
            $dienstNaam = crewProducten::perProduct($dienst->functieId)->productNaam;
            $klantNaam = relaties::perRelatie($projectInfo->relatie)->klant_naam;
    ?>
    <div class="row bg-secondary-subtle rounded-3 p-4 mb-4">
        <div class="col-12 mb-3">
            <h6><?php print $dienstNaam . ' - ' . $projectInfo->projectNaam ; ?></h6>
            <?php
                print $klantNaam; 
            ?>
        </div>
        <div class="col-12">
            <div class="list-group">
                <div class="list-group-item py-4 hstack gap-0">
                    <div class="col-4 ms-3">
                        <?php 
                            print '<span class="fw-semibold">'.convert::datumKort($dienst->datum).'</span><br />'.
                            convert::tijdKort($dienst->tijdBegin) . ' - ' . convert::tijdKort($dienst->tijdEinde); 
                        ?> 
                    </div>
                    <div class="col-4">
                        <?php if(!empty($locatieNaam)) {print '<span class="fw-semibold">'.$locatieNaam .'</span><br />';} 
                        print $adres->straat . '<br />' . $adres->postcode . ' ' . $adres->plaats; ?>
                    </div>
                    <div class="col-4">
                        <a href="/planning/<?php print $dienst->id; ?>" class="btn btn-outline-secondary float-end me-5">Bekijk details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
        } 
 
        require_once FOOTER;
    
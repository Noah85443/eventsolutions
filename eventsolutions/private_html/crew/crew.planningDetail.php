<?php
    $accessLevel = array("crew");
    require_once '../core/system.init.php';
    require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
    require_once FRAMEWORK;
    
    $dienstNr = filter_input(INPUT_GET, "dienstNr", FILTER_VALIDATE_INT);
    $data = crewDiensten::perDienst($dienstNr);
    $projectInfo = projecten::perProject($data->projectId);
    $admin = crewMembers::getCrew($projectInfo->projectAdmin);
    $functieNaam = crewProducten::perProduct($data->functieId)->productNaam;
    $locatie = locaties::perLocatie($projectInfo->locatie);

?>
<div class="row">
    <div class="col s12">
        <h5>Dienstdetails</h5>
        <div class="card">
            <div class='card-content'>
                <h6>Dienstdetails</h6>
                Functie: <?php print $functieNaam; ?><br />
                Datum: <?php print convert::datumKort($data->datum); ?><br />
                Begintijd: <?php print convert::tijdKort($data->tijdBegin); ?><br />
                Eindtijd: <?php print convert::tijdKort($data->tijdEinde); ?>
                <br /><br />
                Notities:<br />
                <?php 
                    if(!empty($data->notitiesCrew)) {
                        print $data->notitiesCrew;
                    }
                    else {
                        print "<i>Geen notities voor deze dienst</i>";
                    }
                ?>
                <br /><br />
                Specifieke Briefing:<br />
                <?php 
                    if(!empty($data->briefing)) {
                        print $data->briefing;
                    }
                    else {
                        print "<i>Geen specifieke briefing-elementen voor deze dienst gevonden</i>";
                    }
                ?>
                <br /><br />
                Declaraties:<br />
                <?php 
                    if($data->declaratiesToegestaan == 1) {
                        print "Declaraties toegestaan voor deze dienst";
                    }
                    else {
                        print "<i>Voor deze dienst gelden afwijkende regels voor declaraties.<br />Vraag ernaar bij de projectmanager</i>";
                    }
                ?>
                <br /><br />
                Laatste wijziging: <?php print $data->lastUpdated; ?>    
            </div>
        </div>
        <div class="card">
            <div class='card-content'>
                <h6>Locatie</h6>
                <strong><?php print $locatie->locatieNaam; ?></strong><br />
                <?php print $locatie->straat . '<br />' . $locatie->postcode . ' ' . $locatie->plaats; ?>
                <br /><br />
                Website: <?php print '<a href="'.$locatie->website.'" target="_blank">'.$locatie->website.'</a>'; ?>  
            </div>
        </div>
         <div class="card">
            <div class='card-content'>
                <h6>Projectdetails</h6>
                Projectnaam: <?php print $projectInfo->projectNaam; ?><br />
                Projectperiode: <?php print convert::datumKort($projectInfo->datumBegin) . ' - ' . convert::datumKort($projectInfo->datumEind); ?><br />
                Projectmanager: <?php print $admin->voornaam . ' ' . $admin->tussenvoegsel . ' ' . $admin->achternaam; ?>
                <br /><br />
                Laatste wijziging: <?php print $projectInfo->lastUpdated; ?>    
            </div>
        </div>
    </div>
</div> 
<?php
    require_once FOOTER;
?>
<?php
    $accessLevel = array("crew");
    require_once '../core/system.init.php';
    require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
    require_once FRAMEWORK;
    
    $dataset = projecten::perStatus("project_in_behandeling");
    $medewerker = crewMembers::getCrew($userData->linked_crew);  
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">event_available</span>
       <span class="text-secondary">Planning &nbsp; > &nbsp; </span>
       <span class="">Beschikbaarheid</span>
   </h4> 
</div>
    <?php
        for($x=0; $x < count($dataset); $x++) {
            $locatieNaam = locaties::perLocatie($dataset[$x]->locatie)->locatieNaam;
            (object) $adres = json_decode($dataset[$x]->locatie);
            $diensten = crewDiensten::perProject($dataset[$x]->id);
    ?>
    <div class="row bg-secondary-subtle rounded-3 p-4 mb-4">
        <div class="col-12 mb-3">
            <?php
                print '<h5 class="mb-2">'.$dataset[$x]->projectNaam.'</h5>
                '.convert::datumKort($dataset[$x]->datumBegin).' t/m '.convert::datumKort($dataset[$x]->datumEind).'<br /> 
                Locatie: '.$locatieNaam .' ('.$adres->straat . ', ' . $adres->postcode . ' ' . $adres->plaats . ')'; 
            ?>
        </div>
        <div class="col-12">
            <div class="list-group">
        <?php
            foreach($diensten as $dienst => $info) {
                $beschikbaarheid = crewBeschikbaarheid::checkDienstStatus($dienst, $medewerker->id);
                $data = crewDiensten::perDienst($dienst);
                $dienstNaam = crewProducten::perProduct($data->functieId)->productNaam;
        ?>
                <div class="list-group-item py-4 hstack gap-3">
                    <div class="col-4 ms-3">
                        <h6><?php print $dienstNaam; ?></h6>
                    </div>
                    <div class="col-4">
                        Datum: <?php print convert::datumKort($info->datum); ?><br />
                        Werktijd: <?php print convert::tijdKort($info->tijdBegin) . ' - ' . convert::tijdKort($info->tijdEinde); ?> 
                    </div>
                    <div id="<?php print "dienst".$dienst; ?>" class="col-4">
                    <?php 
                        if($beschikbaarheid == 1) {print "<div class=\"btn btn-success\">Beschikbaar</div>";}
                        elseif($beschikbaarheid == 2) {print "<div class=\"btn btn-danger\">Niet Beschikbaar</div>";}
                        elseif($beschikbaarheid == 3) {print "<div class=\"btn btn-info\">Ingepland</div>";}
                        else {
                            print " 
                                <a onclick=\"updateBeschikbaarheid({$dataset[$x]->id},{$dienst},1,{$medewerker->id})\" class=\"btn btn-outline-success me-2\">Beschikbaar</a>
                                <a onclick=\"updateBeschikbaarheid({$dataset[$x]->id},{$dienst},2,{$medewerker->id})\" class=\"btn btn-outline-danger\">Niet beschikbaar</a>
                            ";
                        }
                    ?>
                    </div>
                </div>
        <?php 
            } 
        ?>
            </div>
        </div>
    </div>
    <?php 
        } 
 
        require_once FOOTER;
    ?>

<script>
function updateBeschikbaarheid(projectId,dienstNr,status,medewerkerId)
{
   $.ajax({

     type: "GET",
     url: '/handlers/handler.crewBeschikbaarheid.php',
     data: "projectId=" + projectId + "&dienstNr=" + dienstNr + "&status=" + status + "&medewerkerId=" + medewerkerId,
     success: function(data) {
          $('#dienst' + dienstNr).html(data);
     }

   });

}
</script>

<?php
    $accessLevel = array("admin");
    require_once '../core/system.init.php';
    require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
    require_once FRAMEWORK;
 
    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    $data_project = projecten::perProject($id);
    $diensten = crewDiensten::perProject($id);
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">fact_check</span>
       <span class="text-secondary">Projecten &nbsp; > &nbsp;
       <?php print $data_project->projectNaam; ?> &nbsp; > &nbsp; </span>
       <span>Planning</span>
   </h4> 
</div>
<nav class="mb-5">
    <ul class="nav nav-pills" >
        <li class="nav-item"><a class="nav-link" href="/projecten/overzicht/<?php print $data_project->id; ?>">Overzicht</a></li>       
        <li class="nav-item"><a class="nav-link" href="/projecten/bewerken/<?php print $data_project->id; ?>">Gegevens</a></li>
        <li class="nav-item"><a class="nav-link" href="/projecten/materialen/<?php print $data_project->id; ?>">Materialen</a></li>
        <li class="nav-item"><a class="nav-link active" href="/projecten/planning/<?php print $data_project->id; ?>">Planning</a></li>
        <li class="nav-item"><a class="nav-link" href="/projecten/uren/<?php print $data_project->id; ?>">Uren</a></li>
        <li class="nav-item"><a class="nav-link" href="/projecten/declaraties/<?php print $data_project->id; ?>">Declaraties</a></li>
    </ul>
</nav>

<a class="btn btn-sm btn-outline-secondary mb-4 " onclick="window.open('/projecten/planning/<?php print $id; ?>/nieuwe-dienst','_blank','height=620,width=400');">+ Nieuwe dienst</a>
<?php
$aantalDiensten = count($diensten);
if($aantalDiensten != 0) { 
    foreach($diensten as $dienst => $info) {
        $dienstNaam = crewProducten::perProduct($info->functieId)->productNaam;
        $beschikbaarheid = crewBeschikbaarheid::checkPerDienst($dienst);
        $planning = crewPlanning::perDienst($dienst);
            
        if(array_key_exists(1,$planning)) {
            $aantalGepland = count($planning[1]);
        } else {$aantalGepland = 0;}
                            
        print "
            <div class=\"row\">
                <div class=\"col-sm-12 pb-4\">
                    <h6>{$aantalGepland} / {$info->aantal} | {$dienstNaam}</h6>
                    <span class=\"mb-2\">".convert::datumKort($info->datum)." &nbsp; | &nbsp; ".convert::tijdKort($info->tijdBegin)." - ".convert::tijdKort($info->tijdEinde)." &nbsp; | &nbsp; 
					<a onclick=\"window.open('/projecten/planning/{$dienst}/wijzig-dienst','_blank','height=620,width=400');\">Wijzig dienst</a></span>
                </div>
            </div>
            <div class=\"row pb-5\">
                <div class=\"col-sm-3 px-4\" id=\"beschikbaar{$dienst}\">
                    <h6>Beschikbaar</h6>";
                    if(array_key_exists(1,$beschikbaarheid)) {
                        for($x=0;$x<count($beschikbaarheid[1]);$x++) {
                            $medewerker = crewMembers::getCrew($beschikbaarheid[1][$x]->medewerkerId);
                            $medewerkerNaam = $medewerker->voornaam.' '.$medewerker->tussenvoegsel.' '.$medewerker->achternaam;                    
                            print "
                                <a onclick=\"planMedewerker({$dienst},{$medewerker->id},3,{$beschikbaarheid[1][$x]->id},'{$medewerkerNaam}')\"
                                    id=\"beschikbaar{$dienst}{$medewerker->id}\" class=\"btn btn-sm btn-outline-success p-2 mb-2 w-100
                            "; 
                            if($data_project->status != "project_in_behandeling") {
                                print " disabled";
                            }
                            print " \">
                                {$medewerkerNaam}
                            </a>";
                        }
                    }
            print "
                </div>
                <div class=\"col-sm-3 px-4\" id=\"ingepland{$dienst}\">
                    <h6>Ingepland</h6>";
                    if(array_key_exists(1,$planning)) {
                        for($x=0;$x<count($planning[1]);$x++) {
                            $medewerker = crewMembers::getCrew($planning[1][$x]->medewerkerId);
                            $medewerkerNaam = $medewerker->voornaam.' '.$medewerker->tussenvoegsel.' '.$medewerker->achternaam;
                            print " 
                                <a onclick=\"unplanMedewerker({$dienst},{$medewerker->id},2,{$planning[1][$x]->id},'{$medewerkerNaam}')\"
                                id=\"ingepland{$dienst}{$medewerker->id}\" class=\"btn btn-sm btn-outline-dark p-2 mb-2 w-100
                            "; 
                            if($data_project->status != "project_in_behandeling") {
                                print " disabled";
                            }
                                print " \">
                                    {$medewerkerNaam}
                                </a>";
                        }
                    }
                    if($data_project->status == "project_in_behandeling") {
                        print "
                            <a class=\"btn btn-sm btn-outline-secondary w-100 p-2 mb-2\" onclick=\"window.open('/projecten/plan-medewerker/{$data_project->id}','_blank','height=620,width=400');\">+ Medewerker inplannen</a>
                        ";
                    }
            print " 
                </div>
                <div class=\"col-sm-3 px-4\" id=\"nietbeschikbaar{$dienst}\">
                    <h6>Niet beschikbaar</h6>";
                    if(array_key_exists(2,$beschikbaarheid)) {
                        for($x=0;$x<count($beschikbaarheid[2]);$x++) {
                            $medewerker = crewMembers::getCrew($beschikbaarheid[2][$x]->medewerkerId);
                            print " 
                                <div class=\"btn btn-sm btn-outline-danger p-2 mb-2 w-100"; 
                            if($data_project->status != "project_in_behandeling") {
                                print " disabled";
                            }
                            print "
                                id=\"nietbeschikbaar{$dienst}{$medewerker->id}\">{$medewerker->voornaam} {$medewerker->tussenvoegsel} {$medewerker->achternaam}</div>
                            ";
                        }
                    }
            print "
                </div>
                <div class=\"col-sm-3 px-4\" id=\"uitgepland{$dienst}\">
                    <h6>Uitgepland</h6>";
                    if(array_key_exists(2,$planning)) {
                        for($x=0;$x<count($planning[2]);$x++) {
                            $medewerker = crewMembers::getCrew($planning[2][$x]->medewerkerId);
                            $medewerkerNaam = $medewerker->voornaam.' '.$medewerker->tussenvoegsel.' '.$medewerker->achternaam;
                            print "
                                <a onclick=\"replanMedewerker({$dienst},{$medewerker->id},1,{$planning[2][$x]->id},'{$medewerkerNaam}')\"
                                id=\"uitgepland{$dienst}{$medewerker->id}\" class=\"btn btn-sm btn-outline-secondary p-2 mb-2 w-100
                            "; 
                            if($data_project->status != "project_in_behandeling") {
                                print " disabled";
                            }
                            print " \">
                                {$medewerkerNaam}
                            </a>";
                        }
                    }               
            print "
                </div>
            </div>
            ";
    }
}
    ?>
</div>
<?php if ($data_project->status <= 3) { ?>
<a class="btn btn-sm btn-outline-success mt-5" href="/diensten/nieuw/<?php print $data_project->id; ?>">
    <span class="material-icons-outlined float-start pe-3">add</span> 
    Dienst toevoegen
</a>
    <?php } ?>


<?php
 require_once FOOTER;
?>
<script>
function planMedewerker(dienstNr,medewerkerId,status,beschikbaarId,medewerkerNaam)
{
   $.ajax({
     type: "GET",
     url: '/handlers/handler.projectPlanning.php',
     data: "task=plan&dienstNr=" + dienstNr + "&medewerkerId=" + medewerkerId + "&status=" + status + "&beschikbaarId=" + beschikbaarId,
     success: function() { 
        $('#beschikbaar' + dienstNr + medewerkerId).hide();
        $('#ingepland' + dienstNr).append('<div class="btn btn-sm btn-outline-warning p-2 mb-2 w-100">' + medewerkerNaam + '</div>');
     }
   });
}

function unplanMedewerker(dienstNr,medewerkerId,status,planningId,medewerkerNaam)
{
   $.ajax({
     type: "GET",
     url: '/handlers/handler.projectPlanning.php',
     data: "task=unplan&dienstNr=" + dienstNr + "&medewerkerId=" + medewerkerId + "&status=" + status + "&planningId=" + planningId,
     success: function() {
        $('#ingepland' + dienstNr + medewerkerId).hide();
        $('#uitgepland' + dienstNr).append('<div class="btn btn-sm btn-outline-warning p-2 mb-2 w-100">' + medewerkerNaam + '</div>');
     }
   });
}

function replanMedewerker(dienstNr,medewerkerId,status,planningId,medewerkerNaam)
{
   $.ajax({
     type: "GET",
     url: '/handlers/handler.projectPlanning.php',
     data: "task=replan&planningId=" + planningId + "&status=" + status,
     success: function() {
        $('#uitgepland' + dienstNr + medewerkerId).hide();
        $('#ingepland' + dienstNr).append('<div class="btn btn-sm btn-outline-warning p-2 mb-2 w-100">' + medewerkerNaam + '</div>');
     }
   });
}
</script>
<?php
    $accessLevel = array("admin");
    require_once '../core/system.init.php';
    require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
    require_once FRAMEWORK;
 
    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    $data_project = projecten::perProject($id);
 
    $uren = crewUren::perDienstInProject($data_project->id);
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">fact_check</span>
       <span class="text-secondary">Projecten &nbsp; > &nbsp;
       <?php print $data_project->projectNaam; ?> &nbsp; > &nbsp; </span>
       <span>Urenoverzicht</span>
   </h4> 
</div>
<nav class="mb-5">
    <ul class="nav nav-pills" >
        <li class="nav-item"><a class="nav-link" href="/projecten/overzicht/<?php print $data_project->id; ?>">Overzicht</a></li>       
        <li class="nav-item"><a class="nav-link" href="/projecten/bewerken/<?php print $data_project->id; ?>">Gegevens</a></li>
        <li class="nav-item"><a class="nav-link" href="/projecten/materialen/<?php print $data_project->id; ?>">Materialen</a></li>
        <li class="nav-item"><a class="nav-link" href="/projecten/planning/<?php print $data_project->id; ?>">Planning</a></li>
        <li class="nav-item"><a class="nav-link active" href="/projecten/uren/<?php print $data_project->id; ?>">Uren</a></li>
        <li class="nav-item"><a class="nav-link" href="/projecten/declaraties/<?php print $data_project->id; ?>">Declaraties</a></li>
    </ul>
</nav>
<?php
    if ($data_project->status == "project_wachten_op_data") {
        print " 
            <div class=\"alert alert-secondary\" id=\"urenstatus\">
                <div class=\"pb-3\">" . projecten::statusId('project_wachten_op_data')['ico'] . projecten::statusId('project_wachten_op_data')['txt'] . "</div>
                <a class=\"btn btn-sm btn-outline-success\" data-bs-toggle=\"modal\" data-bs-target=\"#popup\">Aanbieden aan klant</a>                
                <a class=\"btn btn-sm btn-outline-primary\" onclick=\"wijzigStatus({$data_project->id},'project_data_goedgekeurd')\" >Direct goedkeuren</a>
            </div>
        ";
    }
    if ($data_project->status == "project_wachten_op_goedkeuring_data") {
        print " 
            <div class=\"alert alert-warning\" id=\"urenstatus\">
                <div class=\"pb-3\">" . projecten::statusId('project_wachten_op_goedkeuring_data')['ico'] . projecten::statusId('project_wachten_op_goedkeuring_data')['txt'] . "</div>  
                <a onclick=\"wijzigStatus({$data_project->id},'project_data_goedgekeurd')\" class=\"btn btn-sm btn-outline-dark\" >Overrule afwachting</a>
            </div> 
        ";
    }
    
    print "<div class=\"row\">";
    if(count($uren) != 0) {
        foreach($uren as $dienstNr => $info) {
            $functieId = crewDiensten::perDienst($dienstNr);
            $dienstNaam = crewProducten::perProduct($functieId->functieId)->productNaam;
            $regelUren = 0;
            print "
                <div class=\"col-12 py-3\">
                    <table class=\"table table-hover\">
                     <thead class=\"table-light\">
                         <tr><td colspan=\"6\">{$dienstNr} &nbsp; - &nbsp; {$dienstNaam}</td></tr>
                    </thead>
                    <tbody>
                ";
                
                for($x=0;$x<count($info);$x++) {

                    $urenData = crewUren::dataPerRegel($info[$x]->id);
                    $urenstatus = crewUren::statusId($urenData['status']);
                    $medewerker = crewMembers::getCrew($urenData['medewerker']);
                    $regelUren += $urenData['uren']['komma'];
                    print " 
                        <tr>
                            <td>{$medewerker->voornaam} {$medewerker->tussenvoegsel} {$medewerker->achternaam}</td>
                            <td>{$urenData['uren']['datum']}</td>
                            <td>{$urenData['uren']['begin']} &nbsp; - &nbsp; {$urenData['uren']['eind']}</td>
                            <td>{$urenData['uren']['pauze']}</td>
                            <td>{$urenData['uren']['totaal']} &nbsp; ({$urenData['uren']['komma']})</td>
                    ";
                            
                    if($urenstatus['nr'] == 1) {
                        print "
                            <td id=\"{$info[$x]->id}\" class=\"right\">
                                <a onclick=\"wijzigUrenStatus({$info[$x]->id},2)\" class=\"btn green darken-2\"><i class=\"material-icons white-text\">check</i></a>
                                <a onclick=\"wijzigUrenStatus({$info[$x]->id},4)\" class=\"btn red darken-2\"><i class=\"material-icons white-text\">clear</i></a>
                            </td> 
                        ";
                    }
                    else {
                        print "<td>{$urenstatus['txt']}</td> ";
                    }
                    print "</tr>";
                }
                
                print "</tbody><tfoot class=\"table-light\">
                         <tr><td>";
                if ($data_project->status == "project_wachten_op_data") { 
            print "<a class=\"btn btn-outline-success btn-sm\" onclick=\"window.open('".BASE_OFFICE."/projecten/uren/{$data_project->id}/nieuw','_blank','height=620,width=400');\">+ Uren toevoegen</a>"; 
                        }
                        print "</td><td colspan=\"3\"></td><td>{$regelUren}</td><td></td></tr>
                    </tfoot></table></div>";
                
            }
            
            
        }
        else {  
            print "Er zijn nog geen uren beschikbaar voor dit project.";
        }
        
        print " 
            </div>
        ";
    ?>
</div>
<?php 
                        
                    ?>
<div class="modal fade" id="popup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="popupLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title" id="popupLabel">Urengegevens aanbieden aan klant</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Let op: Deze actie kan niet ongedaan gemaakt worden.<br /><br />
            Na het bevestigen van deze actie is het niet meer mogelijk om uren en declaraties toe te voegen of te wijzigen.<br /><br />
            De volgende acties worden uitgevoerd:<br />
            - Invoer door medewerkers en administratie wordt geblokkeerd<br />
            - Projectstatus veranderd naar: Uren in afwachting van goedkeuring klant<br />
            - Klant wordt per e-mail geinformeerd over het verzoek.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
        <a type="button" class="btn btn-primary" onclick="urenAanbieden(<?php print $data_project->id; ?>)">Versturen</a>
      </div>
    </div>
  </div>
</div>

<?php
    require_once FOOTER;
?>

<script>

  
function wijzigUrenStatus(urenId,status)
{
   $.ajax({
     type: "GET",
     url: '/handlers/handler.projecten.php',
     data: "actie=wijzigUrenStatus&urenId=" + urenId + "&status=" + status,
     success: function() {
        $('td#' + urenId).html('<span class="orange-text">! Gewijzigd</span>');
     }
   });
}

function wijzigStatus(projectId,status)
{
   $.ajax({
     type: "GET",
     url: '/handlers/handler.projecten.php',
     data: "actie=wijzigStatus&projectId=" + projectId + "&status=" + status,
     success: function() {
        $('#urenstatus').html('<div class=\"card-content green white-text\">Projectstatus gewijzigd! - Vernieuw de pagina om verder te gaan</div>');
     }
   });
}

function urenAanbieden(projectId)
{
   var myModalEl = document.getElementById('popup');
   var modal = bootstrap.Modal.getInstance(myModalEl)
   modal.hide();
   
   $.ajax({
     type: "GET",
     url: '/handlers/handler.projecten.php',
     data: "actie=urenAanbieden&projectId=" + projectId,
     success: function() {
        $('#urenstatus').hide();
     }
   });
   
}
</script>
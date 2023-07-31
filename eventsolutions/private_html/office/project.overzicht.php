<?php
    $accessLevel = array("admin");
    require_once '../core/system.init.php';
    require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
    require_once FRAMEWORK;
 
    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    $dataset = projecten::perProject($id);
    $locatie = locaties::perLocatie($dataset->locatie);
    $relatie = relaties::perRelatie($dataset->relatie);
    $diensten = crewDiensten::perProject($id);
    $status = projecten::statusId($dataset->status);
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">fact_check</span>
       <span class="text-secondary">Projecten &nbsp; > &nbsp; </span>
       <?php print $dataset->projectNaam; ?>
   </h4> 
</div>
<nav class="mb-5">
    <ul class="nav nav-pills" >
        <li class="nav-item"><a class="nav-link active" href="/projecten/overzicht/<?php print $dataset->id; ?>">Overzicht</a></li>       
        <li class="nav-item"><a class="nav-link" href="/projecten/bewerken/<?php print $dataset->id; ?>">Gegevens</a></li>
        <li class="nav-item"><a class="nav-link" href="/projecten/materialen/<?php print $dataset->id; ?>">Materialen</a></li>
        <li class="nav-item"><a class="nav-link" href="/projecten/planning/<?php print $dataset->id; ?>">Planning</a></li>
        <li class="nav-item"><a class="nav-link" href="/projecten/uren/<?php print $dataset->id; ?>">Uren</a></li>
        <li class="nav-item"><a class="nav-link" href="/projecten/declaraties/<?php print $dataset->id; ?>">Declaraties</a></li>
    </ul>
</nav>

<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4">
    <div class="col p-3" id="projectStatus">
       <h6>Status</h6>
       <?php 
        print "<div class=\"pb-1\">" . $status['ico'] . "&nbsp;" . $status['txt'] . "</div>";
        
        print "<div class=\"btn-group-vertical mt-3\">";
        
        if ($dataset->status == "nieuwe_aanvraag") {
            print "
                <a onclick=\"wijzigStatus({$dataset->id},'aanvraag_goedgekeurd')\" class=\"btn btn-sm btn-success\">
                    <span class=\"material-icons-outlined float-start pe-2\">done</span>
                    Aanvraag goedkeuren
                </a>
            ";
        }
        elseif ($dataset->status == "aanvraag_goedgekeurd") {
            print "
                <a onclick=\"wijzigStatus({$dataset->id},'project_in_behandeling')\" class=\"btn btn-sm btn-info btn-outline\">
                    <span class=\"material-icons-outlined float-start pe-2\">pending</span>
                    In behandeling nemen
                </a>
            ";
        }
        elseif ($dataset->status == "project_in_behandeling") {
            print "
                <a onclick=\"wijzigStatus({$dataset->id},'project_klaar_voor_uitvoering')\" class=\"btn btn-sm btn-outline-success\">
                    <span class=\"material-icons-outlined float-start pe-2\">done_all</span>
                    Klaar voor uitvoering
                </a>
            ";
        }
        elseif ($dataset->status == "project_klaar_voor_uitvoering") {
            print "
                <a onclick=\"wijzigStatus({$dataset->id},'project_wachten_op_data')\" class=\"btn btn-sm btn-outline-success\">
                    <span class=\"material-icons-outlined float-start pe-2\">hourglass_top</span>
                    Open gegevens-invoer
                </a>
                <a onclick=\"wijzigStatus({$dataset->id},'verhuur_geleverd')\" class=\"btn btn-sm btn-outline-success\">
                    <span class=\"material-icons-outlined float-start pe-2\">local_shipping</span>
                    Materialen geleverd
                </a>
                <a onclick=\"wijzigStatus({$dataset->id},'project_in_behandeling')\" class=\"btn btn-sm btn-outline-secondary\">
                    <span class=\"material-icons-outlined float-start pe-2\">arrow_back</span>
                    Opnieuw behandelen
                </a>
            ";
        }
        elseif ($dataset->status == "verhuur_geleverd") {
            print "
                <a onclick=\"wijzigStatus({$dataset->id},'verhuur_wachten_op_telling')\" class=\"btn btn-sm btn-outline-warning\">
                    <span class=\"material-icons-outlined float-start pe-2\">list_alt</span>
                    Retour melden
                </a>
                <a onclick=\"wijzigStatus({$dataset->id},'project_wachten_op_data')\" class=\"btn btn-sm btn-outline-warning\">
                    <span class=\"material-icons-outlined float-start pe-2\">hourglass_top</span>
                    Open gegevens-invoer
                </a>
            ";
        }
        elseif ($dataset->status == "verhuur_wachten_op_telling") {
            print "
               <a onclick=\"wijzigStatus({$dataset->id},'project_wachten_op_data')\" class=\"btn btn-sm btn-outline-warning\">
                    <span class=\"material-icons-outlined float-start pe-2\">hourglass_top</span>
                    Open gegevens-invoer
                </a>
            ";
        }
        print "<a onclick=\"wijzigStatus({$dataset->id},'project_geannuleerd')\" class=\"btn btn-sm btn-outline-danger \">
                <span class=\"material-icons-outlined float-start pe-2\">delete</span>
                Annuleer project
              </a></div>";
       ?>
    </div>
    <div class="col p-3">
        <h6>Projectinfo</h6>
        Projectnummer<br />
        <?php print $dataset->projectNummer; ?><br /><br /> 
        Datum <br />
        <?php print convert::datumKort($dataset->datumBegin) . " - " . convert::datumKort($dataset->datumEind); ?>
        <br /><br />
        Eigen kenmerk klant<br />
        <?php print $dataset->klantKenmerk; ?>
    </div>
    <div class="col p-3">
        <h6>Klant</h6>
        <?php
        print "
            {$relatie->klant_type}<br /><br />
            {$relatie->klant_naam}<br />
            {$relatie->straat}<br />
            {$relatie->postcode} {$relatie->plaats} ({$relatie->land})
        ";
        ?>
    </div>
    <div class="col p-3">
        <h6>Locatie</h6>
        <?php
        print "
            {$locatie->locatieNaam}<br /><br />
            {$locatie->straat}<br />
            {$locatie->postcode} {$locatie->plaats} ({$locatie->land})
        ";
        if(!empty($locatie->website)) {
            print "<br /><br /><a href=\"{$locatie->website}\" target=\"_blank\">{$locatie->website}</a>";
        }
        ?>
    </div>
</div>
<div class="row pt-4">
    <div class="col-sm-6 p-3">
        <h6>Diensten</h6>
        <?php
            $aantalDiensten = count($diensten);
            if($aantalDiensten != 0) {
                foreach($diensten as $dienst => $info) {
                    $dienstNaam = crewProducten::perProduct($info->functieId)->productNaam;
                    print   "
                        <strong>{$dienstNaam} ({$dienst})</strong><br />
                        {$info->datum} | {$info->tijdBegin} - {$info->tijdEinde}<br />
                        Uitvraag: {$info->aantal} medewerker(s)
                        <br /><br />
                    ";
                }
            }
            else { 
                print "Er zijn nog geen diensten gekoppeld aan dit project.";
            }
        ?>
    </div>
    <div class="col-sm-6 p-3">
        <h6>Materialen en Verbruik</h6>
        Dat overzicht komt binnenkort hier..
    </div>
</div>
<?php
 require_once FOOTER;
?>

<script>
function wijzigStatus(projectId,status)
{
   $.ajax({
     type: "GET",
     url: '/handlers/handler.projecten.php',
     data: "actie=wijzigStatus&projectId=" + projectId + "&status=" + status,
     success: function() {
        $('#projectStatus').html('<div class=\"notification success\">Projectstatus gewijzigd! - Vernieuw de pagina om verder te gaan</div>');
     }
   });
}
</script>
<?php
    $accessLevel = array("admin");
    require_once '../core/system.init.php';
    require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
    require_once FRAMEWORK;
 
    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    $data_project = projecten::perProject($id);
    $declaraties = crewDeclaraties::perProject($data_project->id);
    
    
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">fact_check</span>
       <span class="text-secondary">Projecten &nbsp; > &nbsp;
       <?php print $data_project->projectNaam; ?> &nbsp; > &nbsp; </span>
       <span>Declaraties</span>
   </h4> 
</div>
<nav class="mb-5">
    <ul class="nav nav-pills" >
        <li class="nav-item"><a class="nav-link" href="/projecten/overzicht/<?php print $data_project->id; ?>">Overzicht</a></li>       
        <li class="nav-item"><a class="nav-link" href="/projecten/bewerken/<?php print $data_project->id; ?>">Gegevens</a></li>
        <li class="nav-item"><a class="nav-link" href="/projecten/materialen/<?php print $data_project->id; ?>">Materialen</a></li>
        <li class="nav-item"><a class="nav-link" href="/projecten/planning/<?php print $data_project->id; ?>">Planning</a></li>
        <li class="nav-item"><a class="nav-link" href="/projecten/uren/<?php print $data_project->id; ?>">Uren</a></li>
        <li class="nav-item"><a class="nav-link active" href="/projecten/declaraties/<?php print $data_project->id; ?>">Declaraties</a></li>
    </ul>
</nav>
<div class="row">
<?php 
    if ($data_project->status == "project_wachten_op_data") { 
        print "<div class=\"mb-3\"><a class=\"btn btn-outline-success btn-sm m-0\" onclick=\"window.open('".BASE_OFFICE."/projecten/declaraties/{$data_project->id}/nieuw','_blank','height=750,width=500');\">"
        . "<i class=\"material-icons float-start pe-2\">add</i> Declaratie"
        . "</div></a>"; 
    }
                    
    if(count((array)$declaraties) != 0) {
        print "<div class=\"table-responsive-sm\">"
        . "<table class=\"table\">";
        foreach($declaraties as $productId => $data) { 
            for($x=0;$x<count($data);$x++) {
                $status = crewDeclaraties::statusId($data[$x]->status);
                $medewerker = crewMembers::getCrew($data[$x]->medewerker);
                $product_type = new instellingen();
                print "
                    <tr class=\"align-middle\">
                        <td class=\"py-4\">{$medewerker->voornaam} {$medewerker->tussenvoegsel} {$medewerker->achternaam}</td>
                        <td>{$product_type->productTypes($data[$x]->product_type)->naam}</td>
                        <td>{$data[$x]->aantal}x {$data[$x]->naam}<br />";
                        if(!empty($data[$x]->specificatie)) {
                            print "<span class=\"fw-light\">{$data[$x]->specificatie}</span>";
                        }
                 print "</td>
                        <td>".convert::toEuro($data[$x]->waarde)."</td>
                        <td>{$data[$x]->uren_id}</td>
                        <td id=\"{$data[$x]->id}\">
                        ";
                        if($status['nr'] == 1) {
                            print " 
                                <a onclick=\"wijzigDeclaratieStatus({$data[$x]->id},2)\" class=\"btn btn-success btn-sm pb-1 pt-2 \"><i class=\"material-icons fs-6\">check</i></a>
                                <a onclick=\"wijzigDeclaratieStatus({$data[$x]->id},4)\" class=\"btn btn-danger btn-sm pb-1 pt-2\"><i class=\"material-icons fs-6\">clear</i></a>
                            ";
                        }
                        else {
                            print $status['ico'];
                        }
                print " 
                        </td>
                        <td id=\"factuur{$data[$x]->id}\">
                        ";
                        if($data[$x]->opFactuur == 1) {
                            print " 
                                <a onclick=\"wijzigFactuurStatus({$data[$x]->id},0)\" class=\"btn btn-outline-success btn-sm pb-1 pt-2 border-0 \"><i class=\"material-icons-outlined fs-4\">request_quote</i></a>  
                            ";
                        }
                        else {
                            print "<a onclick=\"wijzigFactuurStatus({$data[$x]->id},1)\" class=\"btn btn-outline-dark btn-sm pb-1 pt-2 border-0\"><i class=\"material-icons-outlined fs-4 \">request_quote</i></a>";
                        }
                print " 
                        </td>
                    </tr>
                ";
            } 
        }
        print "</table></div>";
    }
    else { 
        print "Er zijn nog geen declaraties ingevoerd voor deze dienst.";
    }
    ?>    
</div>
<?php
 require_once FOOTER;
?>

<script>
function wijzigDeclaratieStatus(declaratieId,status)
{
   $.ajax({
     type: "GET",
     url: '/handlers/handler.projecten.php',
     data: "actie=wijzigDeclaratieStatus&declaratieId=" + declaratieId + "&status=" + status,
     success: function() {
        $('td#' + declaratieId).html('<i class=\"material-icons btn btn-warning btn-sm py-2 fs-6\">sync_alt</i>');
     }
   });
}

function wijzigFactuurStatus(declaratieId,status)
{
   $.ajax({
     type: "GET",
     url: '/handlers/handler.projecten.php',
     data: "actie=wijzigFactuurStatus&declaratieId=" + declaratieId + "&status=" + status,
     success: function() {
        $('td#factuur' + declaratieId).html('<i class=\"material-icons btn btn-warning btn-sm py-2 fs-6\">sync_alt</i>');
     }
   });
}
</script>
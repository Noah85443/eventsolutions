<?php
 $accessLevel = array("relatie");
 require_once '../core/system.init.php';
 require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
 require_once FRAMEWORK;
 
 $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
 $dataset = projecten::perProject($id);
 $locatie = locaties::perLocatie($dataset->locatie);
 $relatie = relaties::perRelatie($dataset->relatie);
 $diensten = crewDiensten::perProject($id);
 $status = projecten::statusId($dataset->status);
 
 $aantalDiensten = count($diensten);
 $uren = crewUren::perDienstInProject($dataset->id);
 $declaraties = crewDeclaraties::perProject($dataset->id);
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">list_alt</span>
       <span class="text-secondary">Projecten &nbsp; > &nbsp; </span>
       <span>Details</span>
   </h4> 
</div>
<div class="row mb-3">
    <div class="col-12">
        <h5 class="pb-1">
            <?php 
                if ($dataset->status == "project_wachten_op_goedkeuring_data") {print '<span class="badge text-bg-warning me-3">ACTIE VEREIST</span>';}  
                print $dataset->projectNaam; 
            ?> 
        </h5>
        <p class="mt-4"><?php print projecten::statusId($dataset->status)['ico']." ". projecten::statusId($dataset->status)['txt']; ?></p>
    </div>
</div>
<nav class="navbar navbar-expand bg-body-tertiary p-2 mb-4">
    <ul class="navbar-nav">
        <li class="nav-item"><a class="tablinks nav-link" onclick="openPage(event,'overzicht')">Overzicht</a></li>
        <li class="nav-item"><a class="tablinks nav-link" onclick="openPage(event,'planning')">Planning</a></li>
        <li class="nav-item"><a class="tablinks nav-link" onclick="openPage(event,'uren')">Urenoverzicht</a></li>
        <li class="nav-item"><a class="tablinks nav-link" onclick="openPage(event,'declaraties')">Declaraties</a></li>
    </ul>
</nav>
<div class="row">
    <div class="col-12 page" id="overzicht" style="display: block;">
        <ul class="list-group list-group-horizontal">
            <li class="list-group-item col-3">
                <p class="fst-italic pb-1 mb-0">Projectnummer</p>
                <?php print $dataset->projectNummer; ?>
            </li>
            <li class="list-group-item col-3">
                <p class="fst-italic pb-1 mb-0">Eigen kenmerk klant</p>
                <?php print $dataset->klantKenmerk; ?>
            </li>
            <li class="list-group-item col-3">
                <p class="fst-italic pb-1 mb-0">Datum</p>
                <?php print convert::datumKort($dataset->datumBegin)." t/m ".convert::datumKort($dataset->datumEind); ?>
            </li>
            <li class="list-group-item col-3">
                <p class="fst-italic pb-1 mb-0">Locatie</p>
                <?php 
                    if(!empty($locatie->locatieNaam)) {print $locatie->locatieNaam.'<br />';}
                    print $locatie->straat . '<br />' . $locatie->postcode . '&nbsp;' . $locatie->plaats . ' ('.$locatie->land.')'; ?>
            </li>   
        </ul>
    </div>
    <div class="col page" id="planning" style="display:none;">
        <h6 class="mt-2">Planning</h6>
        <?php 
        if($dataset->status != "nieuwe_aanvraag" OR "aanvraag_goedgekeurd" OR "project_in_behandeling") {
            if($aantalDiensten != 0) {
                print '<ul class="list-group">';
                foreach($diensten as $dienst => $info) {
                    $dienstNaam = crewProducten::perProduct($info->functieId)->productNaam;
                    $beschikbaarheid = crewBeschikbaarheid::checkPerDienst($dienst);
                    $planning = crewPlanning::perDienst($dienst);
                    $aantalGepland = count($planning[1]);
                    print "
                        <li class=\"list-group-item p-3\">
                            <div class=\"row\">
                                <div class=\"col-6\">
                                    <span class=\"badge text-bg-light float-start me-3 fw-normal fs-6\">{$aantalGepland} / {$info->aantal}</span> <div class=\"fw-semibold fs-6 pb-3\">{$dienstNaam}</div>
                                    ".convert::datumKort($info->datum)." | ".convert::tijdKort($info->tijdBegin)." - ".convert::tijdKort($info->tijdEinde)."
                                </div>
                                <div class=\"col-6\">
                                    <ul class=\"list-group list-group-flush\">";
                                    if(array_key_exists(1,$planning)) {
                                        for($x=0;$x<count($planning[1]);$x++) {
                                            $medewerker = crewMembers::getCrew($planning[1][$x]->medewerkerId);
                                            $medewerkerNaam = $medewerker->voornaam.' '.$medewerker->tussenvoegsel.' '.$medewerker->achternaam;
                                            print "<li class=\"list-group-item\">".$medewerkerNaam."</li>";
                                        }
                                        print "</ul>";
                                    }
                                print "
                                </div>
                            </div>
                        </li>
                    ";
                }
                print '</ul>';
            }
            else { 
                print "Er zijn (nog) geen diensten gekoppeld aan dit project.";
            }
        }
        else {
            print "De planning is nog niet vrijgegeven.";
        }     
    ?>
    </div>
    <div class="col page" id="uren" style="display:none;">
        <h6 class="mt-2">Urenoverzicht</h6>
        <?php 
        if($dataset->status != "nieuwe_aanvraag" OR "aanvraag_goedgekeurd" OR "project_in_behandeling") {
            if(count($uren) != 0) {
                if($dataset->status == "project_wachten_op_goedkeuring_data") {
                    print "<div class=\"alert alert-danger\" id=\"urenmelding\"><span class=\"material-icons-outlined float-start pe-3\">checklist</span><span class=\"lh-lg\">Uren en declaraties in afwachting van controle en goedkeuring."
                    . "<button class=\"btn btn-sm btn-success float-end\" data-bs-toggle=\"modal\" data-bs-target=\"#urenGoedkeuren\">Goedkeuren</a></span></div>";
                }
                foreach($uren as $dienstNr => $info) {
                    $functieId = crewDiensten::perDienst($dienstNr);
                    $dienstNaam = crewProducten::perProduct($functieId->functieId)->productNaam;
                    
                    print "
                        <div class=\"innerBlock-100\">
                            <h5>{$dienstNaam}</h5>
                            <p>Gepland: ".count($info)."</p>
                            <table class=\"table\">";
                             
                            for($x=0;$x<count($info);$x++) {
                                $urenData = crewUren::dataPerRegel($info[$x]->id);
                                $urenstatus = crewUren::statusId($urenData['status']);
                                $medewerker = crewMembers::getCrew($urenData['medewerker']);
                                print "<tr>"
                                    . "<td>{$medewerker->voornaam} {$medewerker->tussenvoegsel} {$medewerker->achternaam}</td>"
                                    . "<td>{$urenData['uren']['datum']}</td>"
                                    . "<td>{$urenData['uren']['begin']} - {$urenData['uren']['eind']}</td>"
                                    . "<td>{$urenData['uren']['pauze']}</td>"
                                    . "<td>{$urenData['uren']['totaal']} ({$urenData['uren']['komma']})</td>"
                                    . "</tr>";
                            }
                            print "</table></div>";
                }
            }
            else {  
                print "Er zijn nog geen uren toegevoegd aan dit project.";
            }
        }
        else {
            print "De urenlijst is nog niet vrijgegeven";
        }
        
        ?>
    </div>
    <div class="col page" id="declaraties" style="display:none;">
        <h6 class="mt-2">Declaraties</h6>
            <?php
                if($dataset->status != "nieuwe_aanvraag" OR "aanvraag_goedgekeurd" OR "project_in_behandeling") {
                    if($dataset->status == "project_wachten_op_goedkeuring_data") {
                        print "<div class=\"notification warning\" id=\"urenmelding\">Uren en declaraties in afwachting van controle en goedkeuring.</div>";
                    }
                    if(count((array)$declaraties) != 0) {
                        print "<div class=\"table-responsive-sm\">"
                            . "<table class=\"table\">";
                            foreach($declaraties as $productId => $data) { 
                                for($x=0;$x<count($data);$x++) {
                                    $status = crewDeclaraties::statusId($data[$x]->status);
                                    $medewerker = crewMembers::getCrew($data[$x]->medewerker);
                                    if($data[$x]->opFactuur == 1) {
                                        print "
                                            <tr class=\"align-middle\">
                                                <td class=\"py-4\">{$medewerker->voornaam} {$medewerker->tussenvoegsel} {$medewerker->achternaam}</td>
                                                <td>{$data[$x]->aantal}x {$data[$x]->naam}<br />";
                                                if(!empty($data[$x]->specificatie)) {
                                                    print "<span class=\"fw-light\">{$data[$x]->specificatie}</span>";
                                                }
                                                print "</td>
                                                <td>".convert::toEuro($data[$x]->waarde)."</td>
                                            </tr>
                                        ";
                                    } 
                                }
                            }
                        print "</table></div>";
                    }
                    else {
                        print "Er zijn nog geen declaraties bekend";
                    }
                }
                else {
                    print "Het declaratieoverzicht is nog niet vrijgegeven";
                }
        ?>
    </div>
</div>

<div class="modal fade" id="urenGoedkeuren" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="GoedkeurenUren" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Uren en declaraties goedkeuren</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Let op: Deze actie kan niet ongedaan gemaakt worden.<br /><br />
        Door op 'Goedkeuren' te drukken ga je ermee akkoord<br />
        dat zowel de urenlijst als het declaratieoverzicht<br /> 
        zijn gecontroleerd en akkoord bevonden.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="updateStatus(<?php print $dataset->id; ?>)">Goedkeuren</button>
      </div>
    </div>
  </div>
</div>
<?php
 require_once FOOTER;
?>

<script>
    function openPage(evt, pageName) {
        var i, tabcontent, tablinks;
        
        tabcontent = document.getElementsByClassName("page");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        
        document.getElementById(pageName).style.display = "block";
        evt.currentTarget.className += " active";
    }
    
    
    function updateStatus(projectId){
        
   $.ajax({
     type: "GET",
     url: '/handlers/handler.projecten.php',
     data: "actie=urenGoedkeuren&projectId=" + projectId,
     success: function() {
        $('#urenGoedkeuren').modal('hide');
        $('#urenmelding').replaceWith('<div class=\"alert alert-success\">Uren en declaraties succesvol goedgekeurd.</div>');
        
     }
   });
    }
</script>
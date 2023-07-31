<?php
    $accessLevel = array("crew");
    require_once '../core/system.init.php';
    require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
    require_once FRAMEWORK;
    
    $data = crewDeclaraties::perMedewerker($userData->linked_crew);
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">receipt</span>
       Declaraties &nbsp; > &nbsp
       <span class="text-secondary">Overzicht
       </span>
   </h4> 
        <div class="btn-toolbar mb-2 mb-md-0">
          <a href="/declaratie-toevoegen" class="btn btn-outline-success">
            <span class="material-icons-outlined float-start pe-2">add</span>
            Declaratie toevoegen
          </a>
        </div>
</div>

<?php 
for($x=0; $x<count($data); $x++) { 
    if(($data[$x]->uren_id > 0) AND (!empty($data[$x]->uren_id))) {
        $dienstNr = crewUren::perUrenId($data[$x]->uren_id)['dienstNr'];
        $dienstNaam = crewProducten::perProduct(crewDiensten::perDienst($dienstNr)->functieId)->productNaam;
    }
    $projectInfo = projecten::perProject($data[$x]->project_id);
    
    $datum = date('d-m-Y', strtotime($data[$x]->timestamp));
    $tijd = date('H:i', strtotime($data[$x]->timestamp));
    
    if($data[$x]->product_type == 4) {
        $aantal = 1;
        $waarde = $data[$x]->waarde;
    }
    else {
        $aantal = $data[$x]->aantal;
        $waarde = crewProducten::perProduct($data[$x]->product_id)->inkoopprijs * $aantal;
    }
    ?>
    <div class="row bg-secondary-subtle rounded-3 p-4 mb-4">
        <div class="col-12 mb-3">
            <h6><?php print $projectInfo->projectNaam; ?></h6>
            <?php
                    if(($data[$x]->uren_id > 0) AND (!empty($data[$x]->uren_id))) {
                        print $dienstNaam; 
                    }
            ?>
        </div>
        <div class="col-12">
            <div class="list-group">
                <div class="list-group-item py-4 hstack gap-0">
                    <div class="col-4 ms-3">
                        <?php 
                            print $datum.'<br />'.$tijd;
                        ?> 
                    </div>
                    <div class="col-4">
                        <?php
                            print '<ul class="badge-updates">
                                    <li><i class="material-icons left orange-text text-lighten-2">calculate</i> '.$aantal.' x</li>
                                    <li><i class="material-icons left orange-text text-lighten-2">euro</i> '.$waarde.'</li>
                                </ul>';
                        ?>
                    </div>
                    <div class="col-4">
                        <?php 
                        print '<ul class="badge-updates">
                                    <li><i class="material-icons left orange-text text-lighten-2">work</i> '.$data[$x]->naam.'</li>
                                    <li>'.$data[$x]->specificatie.'</li>
                                </ul>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
} 
 require_once FOOTER;

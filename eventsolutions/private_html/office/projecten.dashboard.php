<?php
    $accessLevel = array("admin");
    $accessArea = "projecten";
    require_once '../core/system.init.php';
    require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
    require_once FRAMEWORK;
    
    $dataset = projecten::alleProjecten();
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">fact_check</span>
       Projecten
   </h4> 
   <div class="btn-toolbar mb-2 mb-md-0">
          <a href="/projecten/nieuw" class="btn btn-outline-success">
            <span class="material-icons-outlined float-start pe-2">add</span>
            Nieuw project
          </a>
        </div>
</div>

<?php
    for($x=0; $x < count($dataset); $x++) {
        
        $locatie = locaties::perLocatie($dataset[$x]->locatie);
        $status = projecten::statusId($dataset[$x]->status);
        print ' 
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="/projecten/overzicht/'.$dataset[$x]->id.'" class="text-primary text-decoration-none">
                            '.$dataset[$x]->projectNaam.'
                        </a>
                    </h5>
                    <h6 class="card-subtitle mb-2 text-muted">
                        ' . $status['ico'] . '&nbsp;' . $status['txt'] . '
                    </h6>
                    <p class="card-text">
                        ' . convert::datumKort($dataset[$x]->datumBegin) . ' - ' . convert::datumKort($dataset[$x]->datumEind) . '<br />
                        ' . $locatie->straat . ', &nbsp;' . $locatie->plaats . '
                    </p>
                </div>
            </div>
        ';
    }

require_once FOOTER;
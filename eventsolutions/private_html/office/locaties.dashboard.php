<?php
 $accessLevel = array("admin");
 require_once '../core/system.init.php';
 require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
 require_once FRAMEWORK;
 
 $dataset = locaties::alleLocaties();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">place</span>
       Locaties
   </h4> 
   <div class="btn-toolbar mb-2 mb-md-0">
          <a href="/locaties/nieuw" class="btn btn-outline-success">
            <span class="material-icons-outlined float-start pe-2">add</span>
            Nieuwe locatie
          </a>
        </div>
</div>

<?php
    for($x=0; $x < count($dataset); $x++) {
        print ' 
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="/locaties/overzicht/'.$dataset[$x]->id.'" class="text-primary text-decoration-none">
                            '.$dataset[$x]->locatieNaam.'
                        </a>
                    </h5>
                    <p class="card-text">
                        ' . $dataset[$x]->straat.' - '.$dataset[$x]->postcode.' '.$dataset[$x]->plaats.' ('.$dataset[$x]->land.')<br />
                    </p>
                </div>
            </div>
        ';
    }

require_once FOOTER;
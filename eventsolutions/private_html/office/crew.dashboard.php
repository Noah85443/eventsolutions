<?php
 $accessLevel = array("admin");
 require_once '../core/system.init.php';
 require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
 require_once FRAMEWORK;
 
 $dataset = crewMembers::alleMedewerkers();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">emoji_emotions</span>
       Medewerkers
   </h4> 
   <div class="btn-toolbar mb-2 mb-md-0">
          <a href="/crew/nieuw" class="btn btn-outline-success">
            <span class="material-icons-outlined float-start pe-2">add</span>
            Nieuwe medewerker
          </a>
        </div>
</div>

<?php
    for($x=0; $x < count($dataset); $x++) {
        print ' 
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="/crew/overzicht/'.$dataset[$x]->id.'" class="text-primary text-decoration-none">
                            '.$dataset[$x]->voornaam.' '.$dataset[$x]->tussenvoegsel.' '.$dataset[$x]->achternaam.'
                        </a>
                    </h5>
                    <p class="card-text">
                        Woonplaats: ' . $dataset[$x]->woonplaats.' <br /> In dienst: '.$dataset[$x]->startdatum.'<br />
                    </p>
                </div>
            </div>
        ';
    }

require_once FOOTER;
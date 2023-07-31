<?php
 $accessLevel = array("admin");
 require_once '../core/system.init.php';
 require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
 require_once FRAMEWORK;
 
 $data_id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
 $dataset = relaties::perRelatie($data_id);
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">business</span>
       Relaties
   </h4> 
   <div class="btn-toolbar mb-2 mb-md-0">
          <a href="/relaties/nieuw" class="btn btn-outline-success">
            <span class="material-icons-outlined float-start pe-2">add</span>
            Nieuwe relatie
          </a>
        </div>
</div>
<nav class="mb-5">
    <ul class="nav nav-pills" >
        <li class="nav-item"><a class="nav-link text-secondary" href="/relaties/dashboard">Alle relaties</a></li>
        <li class="nav-item"><a class="nav-link active" href="/relaties/overzicht/<?php print $dataset->id; ?>">Overzicht</a></li>       
        <li class="nav-item"><a class="nav-link" href="/relaties/bewerken/<?php print $dataset->id; ?>">Bewerken</a></li>
    </ul>
</nav>
<?php
   if($dataset->klant_type == "bedrijf") {$icon = "work_outline";}
   elseif($dataset->klant_type == "consument") {$icon = "face";}
   else {$icon = "question_mark";}
        print ' 
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">
                        <span class="material-icons-outlined float-start pe-3">'.$icon.'</span>
                        '.$dataset->klant_naam.'
                    </h5>
                    <p class="card-text">
                        ' . $dataset->straat.' - '.$dataset->postcode.' '.$dataset->plaats.' ('.$dataset->land.')<br />
                    </p>
                </div>
            </div>
        ';

require_once FOOTER;
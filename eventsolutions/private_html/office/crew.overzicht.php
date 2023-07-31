<?php
 $accessLevel = array("admin");
 require_once '../core/system.init.php';
 require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
 require_once FRAMEWORK;
 
 $data_id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
 $dataset = crewMembers::getCrew($data_id);
 
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">emoji_emotions</span>
       <span class="text-secondary">Medewerkers &nbsp; > &nbsp; </span>
       <span class=""><?php print $dataset->voornaam.' '.$dataset->tussenvoegsel.' '.$dataset->achternaam; ?></span>
   </h4> 
       <div class="btn-toolbar mb-2 mb-md-0">
          <a href="/crew/bewerken/<?php print $dataset->id; ?>" class="btn btn-outline-warning">
            <span class="material-icons-outlined float-start pe-2">edit</span>
            Bewerken
          </a>
        </div>
</div>
<div class="container">
    <div class="row">
        <div class="col">
            <ul>
                <li>ID: <?php print $dataset->id; ?></li>
                <li>Naam: <?php print $dataset->voornaam.' '.$dataset->tussenvoegsel.' '.$dataset->achternaam; ?></li>
                <li>E-mail: <?php print $dataset->email; ?></li>
            </ul>
        </div>
        <div class="col">
            
        </div>
        <div class="col">
            
        </div>
    </div>
</div>

<?php
    require_once FOOTER;
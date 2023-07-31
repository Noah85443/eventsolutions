<?php
 $accessLevel = array("admin");
 require_once '../core/system.init.php';
 require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
 require_once FRAMEWORK;
 
 $data_id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
 $dataset = locaties::perLocatie($data_id);
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">place</span>
       <span class="text-secondary">Locaties &nbsp; > &nbsp; </span>
       <span><?php print $dataset->locatieNaam; ?></span>
   </h4> 
</div>
<nav class="mb-5">
    <ul class="nav nav-pills" >
        <li class="nav-item"><a class="nav-link text-secondary" href="/locaties/dashboard">Alle locaties</a></li>
        <li class="nav-item"><a class="nav-link active" href="/locaties/overzicht/<?php print $dataset->id; ?>">Overzicht</a></li>       
        <li class="nav-item"><a class="nav-link" href="/locaties/bewerken/<?php print $dataset->id; ?>">Bewerken</a></li>
    </ul>
</nav>
<?php
print ' 
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">
                '.$dataset->locatieNaam.'
            </h5>
            <p class="card-text">
                ' . $dataset->straat.' - '.$dataset->postcode.' '.$dataset->plaats.' ('.$dataset->land.')<br />
            </p>
        </div>
    </div>
 ';

require_once FOOTER;
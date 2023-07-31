<?php
    $accessLevel = array("relatie");
    require_once '../core/system.init.php';
    require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
    require_once FRAMEWORK;
    
    $dataset = projecten::perRelatie($account->getUserData()->linked_customer);
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">list_alt</span>
       Projecten
   </h4> 
</div>


<?php
    for($x=0; $x < count($dataset); $x++) {
    $locatie = locaties::perLocatie($dataset[$x]->locatie);
?>
<div class="row mb-5">
    <div class="col-12">
        <a href="/project/<?php print $dataset[$x]->id; ?>" class="text-black fst-normal text-decoration-none">
        <h5 class="pb-1">
            <?php 
                if ($dataset[$x]->status == "project_wachten_op_goedkeuring_data") {print '<span class="badge text-bg-warning me-3">ACTIE VEREIST</span>';}  
                print $dataset[$x]->projectNaam; 
            ?> 
        </h5>
        <ul class="list-group list-group-horizontal">
            <li class="list-group-item col-2">
                <p class="fst-italic pb-1 mb-0">Projectnummer</p>
                <?php print $dataset[$x]->projectNummer; ?>
            </li>
            <li class="list-group-item col-3">
                <p class="fst-italic pb-1 mb-0">Datum</p>
                <?php print convert::datumKort($dataset[$x]->datumBegin)." t/m ".convert::datumKort($dataset[$x]->datumEind); ?>
            </li>
            <li class="list-group-item col-3">
                <p class="fst-italic pb-1 mb-0">Locatie</p>
                <?php 
                    if(!empty($locatie->locatieNaam)) {print $locatie->locatieNaam.'<br />';}
                    print $locatie->straat . '<br />' . $locatie->postcode . '&nbsp;' . $locatie->plaats . ' ('.$locatie->land.')'; ?>
            </li> 
            <li class="list-group-item col-4">
                <p class="fst-italic pb-1 mb-0">Status</p>
                <?php print projecten::statusId($dataset[$x]->status)['ico']." ". projecten::statusId($dataset[$x]->status)['txt']; ?>
            </li>    
        </ul>
    </a>
    </div>
</div>
<?php }
 require_once FOOTER;

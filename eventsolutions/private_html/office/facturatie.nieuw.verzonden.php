<?php
 $accessLevel = array("admin");
 require_once '../core/system.init.php';
 require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
 require_once FRAMEWORK;

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$factuurData = facturatie::opFactuurNummer($id);

$relatie = relaties::perRelatie($factuurData->relatie);
$projecten = json_decode($factuurData->projecten);

$factuurDatum = convert::datumKort($factuurData->datum);
$vervalDatum = convert::datumKort($factuurData->vervaldatum);

    ?>  
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">payments</span>
       <span class="text-secondary">Facturatie &nbsp; > &nbsp; Nieuw &nbsp; > &nbsp; </span>
       <span class="">Verzonden</span>
   </h4> 
</div>
<div class="my-4 mx-5 p-4 shadow bg-body rounded">
    <div class="alert alert-success" role="alert">
        De factuur is met succes verzonden!
    </div>
    <div class="pt-4">
        <?php 
            print " 
                Factuur verzonden aan:<br />
                <span class=\"fw-semibold\">{$relatie->klant_naam}</span><br />
                {$relatie->straat}<br>
                {$relatie->postcode} &nbsp; {$relatie->plaats}, {$relatie->land}<br /><br />
                t.a.v. {$relatie->factuur_tav}<br />
                {$relatie->factuur_email}    
            ";
        ?>
    </div>
    <div class="pt-4">
        <span class="fw-semibold">Factuurgegevens</span><br />
        Factuurnummer: <?php print $factuurData->nummer; ?><br />
        Totaalbedrag:  <?php print convert::toEuro($factuurData->totaal); ?><br /><br />
        Factuurdatum: <?php print $factuurDatum; ?><br />
        Vervaldatum: <?php print $vervalDatum; ?><br />
    </div>
    <div class="pt-4">
        <a href="<?php print "https://" . HOST . $factuurData->pdfLocatie; ?>" class="btn btn-primary">Download factuur</a>
    </div>
</div>
<?php
    require_once FOOTER;
?>
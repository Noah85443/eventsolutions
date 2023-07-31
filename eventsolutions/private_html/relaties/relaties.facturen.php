<?php
    $accessLevel = array("relatie");
    require_once '../core/system.init.php';
    require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
    require_once FRAMEWORK;
 
    $dataset = facturatie::perRelatie($account->getUserData()->linked_customer);
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">payments</span>
       Facturen
   </h4> 
</div>
    <?php
        for($x=0; $x < count($dataset); $x++) {
    ?>
    <div class="row mb-5 px-2 pt-3 pb-5 bg-secondary-subtle">
        <div class="col-12">
        <?php
            print '<p class="fw-semibold fs-6">Factuur ' . $dataset[$x]->nummer;
                if ($dataset[$x]->status >= 4 && $dataset[$x]->status <= 7) {print '<span class="badge text-bg-danger">ACTIE VEREIST</span>';}  
            print '</p>';
        ?>
        </div>
        <div class="col-5 pe-5">
            <ul class="list-group list-group-flush">
            <?php 
                $projecten = json_decode($dataset[$x]->projecten);
                for($y=0; $y < count($projecten); $y++) {
                    $projectNaam = projecten::perProject($projecten[$y])->projectNaam;
                    print '<li class="list-group-item">'.$projectNaam.'</li>'; 
                }
            ?>
            </ul>
        </div>
        <div class="col-5 pe-5">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Factuurdatum: <?php print convert::datumKort($dataset[$x]->datum); ?></li>
                <li class="list-group-item">Totaalbedrag: <?php print convert::toEuro($dataset[$x]->totaal); ?></li>
                <li class="list-group-item">Status: <?php print facturatie::statusId($dataset[$x]->status)['ico']." ".facturatie::statusId($dataset[$x]->status)['txt']; ?></li>    
            </ul>
        </div>
        <div class="col-2">
            <div class="btn-group-vertical">
                <?php
                    if (file_exists("..".$dataset[$x]->pdfLocatie)) {
                        print '<a href="https://' . HOST . $dataset[$x]->pdfLocatie.'" class="btn btn-outline-primary" target="_blank">
                            Download PDF
                        </a>';
                    }
                    if ($dataset[$x]->status <= 7) {
                        print '<a href="https://payments.' . HOST . '/betaling/' . $dataset[$x]->betaalcode.'" class="btn btn-outline-success" target="_blank">
                            Betaal factuur
                        </a>';
                    }
                ?>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<?php
 require_once FOOTER;
?>

<script>
    $(function(){
           $("a").each(function (index, element){
               var href = $(this).attr("href");
               $(this).attr("hiddenhref", href);
               $(this).removeAttr("href");
           });
           $("a").click(function(){
               url = $(this).attr("hiddenhref");
               window.location.href = url;
           })
       });
       </script>
<?php
    $accessLevel = array("relatie");
    require_once '../core/system.init.php';
    require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
    require_once FRAMEWORK;
    
    $dataset = relaties::perRelatie($userData->linked_customer);
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">dashboard</span>
       Overzicht
   </h4> 
</div>
<div class="row">
    <div class="col">
        <h6 class="pb-3">Accountgegevens</h6>
        <table class="table table-borderless">
            <tr>
                <td> <?php print $userData->account_name; ?></td>
            </tr>
            <tr>
                <td> <?php print $userData->account_realname; ?></td>
            </tr>
            <tr>
                <td> <?php print $userData->account_email; ?></td>
            </tr>
        </table>
    </div>
    <div class="col">
        <h6 class="pb-3">Klantgegevens</h6>
        <?php print $dataset->klant_type; ?><br />
       <?php print $dataset->klant_naam; ?><br /><br />
       <?php print $dataset->straat; ?><br />
       <?php print $dataset->postcode; ?> <?php print $dataset->plaats; ?> (<?php print $dataset->land; ?>)<br /><br />
       <?php print $dataset->email; ?>
    </div>
    <div class="col">
        <h6 class="pb-3">Acties</h6>
        <a href="<?php print BASE_ACCOUNTS."/wachtwoord-bewerken"; ?>" class="btn btn-outline-secondary col-12 py-3 mb-1">
            <span class="material-icons-outlined float-start pe-2">key</span>
            Wachtwoord wijzigen
        </a>
        <a href="<?php print BASE_ACCOUNTS."/bewerken"; ?>" class="btn btn-outline-secondary col-12 py-3 my-1">
            <span class="material-icons-outlined float-start pe-2">edit</span>
            Accountgegevens bewerken
        </a>
        <a href="<?php print BASE_RELATIES."/klantgegevens"; ?>" class="btn btn-outline-secondary col-12 py-3 my-1">
            <span class="material-icons-outlined float-start pe-2">home</span>
            Adresgegevens bewerken
        </a>
        <a href="<?php print BASE_ACCOUNTS."/uitloggen"; ?>" class="btn btn-outline-danger col-12 py-3 mt-1">
            <span class="material-icons-outlined float-start pe-2">logout</span>
            Uitloggen
        </a>
   </div>
</div>
<?php
 require_once FOOTER;

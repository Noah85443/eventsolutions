<?php
require_once '../core/system.init.php';
require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
require_once FRAMEWORK;
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">people</span>
       <span>Mijn account</span>
   </h4> 
</div>
<div class="row">
    <div class="col">
        <h6 class="pb-3">Accountgegevens</h6>
        <table class="table table-borderless">
            <tr>
                <td>ID</td>
                <td><?php print $userData->account_id; ?></td>
            </tr>
            <tr>
                <td>Gebruikersnaam</td>
                <td> <?php print $userData->account_name; ?></td>
            </tr>
            <tr>
                <td>Naam</td>
                <td> <?php print $userData->account_realname; ?></td>
            </tr>
            <tr>
                <td>E-mail</td>
                <td> <?php print $userData->account_email; ?></td>
            </tr>
        </table>
    </div>
    <div class="col">
        <h6 class="pb-3">Koppelingen</h6>
        <ul class="list-group">
                <?php
                    if(!empty($userData->linked_crew)) {print '<li class="list-group-item"><a href="https://crew.'.HOST.'/">Personeelsaccount</a></li>';} 
                    if(!empty($userData->linked_customer)) {print '<li class="list-group-item"><a href="https://relaties.'.HOST.'/">Klantaccount</a></li>';} 
                    else {print 'Bent u op dit moment al klant?<br /><a href="'.BASE_ACCOUNTS.'/onboarding/koppel-relatie" class="button blauw" style="width:200px;margin:15 auto;">Koppel dan hier uw klantaccount</a>';}
                ?>
                </ul>
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
        <a href="<?php print BASE_ACCOUNTS."/uitloggen"; ?>" class="btn btn-outline-danger col-12 py-3 mt-1">
            <span class="material-icons-outlined float-start pe-2">logout</span>
            Uitloggen
        </a>
   </div>
</div>
<?php
 require_once FOOTER;

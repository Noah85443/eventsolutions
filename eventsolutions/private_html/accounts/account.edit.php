<?php
require_once '../core/system.init.php';
require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
require_once FRAMEWORK;

if (isset($_POST['editAccount'])){
 $newUserData = filter_input_array(INPUT_POST);
 $enabled = true;
 
 try {
  $action = $account->editAccount($newUserData['account_id'], $newUserData['account_name'], $newUserData['account_realname'], $newUserData['account_email'], $enabled);
 }
 catch (Exception $e) {
        print '<div class="alert alert-danger" role="alert">
            Er ging iets fout: DB SYSTEM ERROR: '.$e->getMessage().'</div>';
    }
 
 if($action) {
     print '<div class="alert alert-success" role="alert">
            Account succesvol gewijzigd.
          </div>';
 }
 else {
    print '<div class="alert alert-danger" role="alert">
            Er ging iets fout.. Het account is niet gewijzigd.
          </div>';
 }
}
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">people</span>
       <span class="text-secondary">Accounts &nbsp; > &nbsp; </span>
       <span>Wijzigen</span>
   </h4> 
</div>
<form method="post">
    <div class="row">
        <div class="col px-4">
            <p>Hier kun je de gegevens van je account wijzigen.<br />Wil je je adres aanpassen, of de gegevens van je bedrijf? Ga dan naar de pagina 'Gegevens' in het onderdeel 'Relaties'.</p>
        </div>
        <div class="col px-4">
            <div class="mb-3 form-floating">
                <input type="text" class="form-control" name="account_name" value="<?php print $userData->account_name; ?>" required />
                <label for="account_name">Gebruikersnaam</label>
            </div>
        </div>
        <div class="col px-4">
            <div class="mb-3 form-floating">
                <input type="text" class="form-control" name="account_realname" value="<?php print $userData->account_realname; ?>" required />
                <label for="account_realname">Voor- en achternaam</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control" name="account_email" value="<?php print $userData->account_email; ?>" required />
                <label for="account_email">E-mailadres</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col pe-4 pt-4">
            <input type="number" name="account_id" value="<?php print $userData->account_id; ?>" hidden />
            <button type="submit" name="editAccount" class="btn btn-warning float-end">Wijzigen</button>
        </div>
    </div>
</form>
<?php
 require_once FOOTER;

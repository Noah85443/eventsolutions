<?php
	$accessLevel = array("admin");
	require_once '../core/system.init.php';
	require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;

	require_once FRAMEWORK;

if (isset($_POST['newAccount'])){
 $newUserData = filter_input_array(INPUT_POST);
 $enabled = true;
 
 try {
  $account_type = json_encode($newUserData['account_type']);
  $action = $account->addAccount($newUserData['account_name'], $newUserData['account_realname'], $newUserData['account_email'], $account_type, $newUserData['account_enabled']);
 }
 catch (Exception $e) {
 print '<div class="alert alert-danger" role="alert">
            Er ging iets fout: DB SYSTEM ERROR: '.$e->getMessage().'</div>';
 }
 
 if(!empty($action)) {
      print '<div class="alert alert-success" role="alert">
            Nieuw account succesvol aangemaakt.
            <br /><br />Het accountnummer is '.$action.'.</div>';
 }
}
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">people</span>
       <span class="text-secondary">Accounts &nbsp; > &nbsp; </span>
       <span>Nieuw</span>
   </h4> 
</div>
<form method="post">
    <div class="row">
        <div class="col px-4">
            <div class="mb-3 form-floating">
                <input type="text" class="form-control" name="account_name" required />
                <label for="account_name">Gebruikersnaam</label>
            </div>
        </div>
        <div class="col px-4">
            <div class="mb-3 form-floating">
                <input type="text" class="form-control" name="account_realname" required />
                <label for="account_realname">Voor- en achternaam</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control" name="account_email" required />
                <label for="account_email">E-mailadres</label>
            </div>
        </div>
        <div class="col px-4">
            <div class="form-check">
                <input class="form-check-input" name="account_type[]" type="checkbox" value="crew" id="crew"  />
                <label for="crew">Personeelslid</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="account_type[]" type="checkbox" value="klant" id="klant"  />
                <label for="klant">Relatie</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="account_type[]" type="checkbox" value="admin" id="admin"  />
                <label for="admin">Administrator</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-8">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="account_enabled" value="1" id="account_enabled" checked disabled>
                <label for="account_enabled">Account direct activeren</label>
            </div>
        </div>
        <div class="col pe-4 pt-4">
            <button type="submit" name="newAccount" class="btn btn-success float-end">Toevoegen</button>
        </div>
    </div>
</form>

<?php
 require_once FOOTER;
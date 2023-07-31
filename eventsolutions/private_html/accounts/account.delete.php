<?php
$accessLevel = array("admin");
require_once '../core/system.init.php';
require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
require_once FRAMEWORK;

if (isset($_POST['deleteAccount'])){
    $dataSet = filter_input_array(INPUT_POST);
    if ($dataSet['account_id'] !== $adminId) {
    try {
        $action = $account->deleteAccount($dataSet['account_id']);
    }
    catch (Exception $e) {
        print '<div class="alert alert-danger" role="alert">
            Er ging iets fout: DB SYSTEM ERROR: '.$e->getMessage().'</div>';
    }
   if($action) {
     print '<div class="alert alert-success" role="alert">
            Account succesvol verwijderd
          </div>';
 }
 else {
    print '<div class="alert alert-danger" role="alert">
            Er ging iets fout.. Het account is niet ontkoppeld en verwijderd.
          </div>';
 }
 }
 else {
        print '<div class="alert alert-warning" role="alert">
            Het is niet mogelijk om je eigen account te verwijderen als administrator.
          </div>';
 }
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">people</span>
       <span class="text-secondary">Accounts &nbsp; > &nbsp; </span>
       <span>Verwijderen</span>
   </h4> 
</div>
<span>
    <h6 class="pb-4">Weet je zeker dat je het volgende account wilt verwijderen?</h6>
    <form method="post">
        <div class="mb-3 form-floating">
            <input type="number" class="form-control-plaintext" name="account_id" value="<?php print $userData->account_id; ?>" readonly />
            <label for="account_id">Account ID</label>
        </div>
        <div class="mb-3 form-floating">
            <input type="text" class="form-control-plaintext" name="account_name" value="<?php print $userData->account_name; ?>" readonly />
            <label for="account_name">Accountnaam</label>
        </div>
        <div class="mb-3 form-floating">
            <input type="text" class="form-control-plaintext" name="account_realname" value="<?php print $userData->account_realname; ?>" readonly />
            <label for="account_realname">Accounteigenaar</label>
        </div>
        <div class="mb-3 form-floating">
            <button type="submit" name="deleteAccount" class="btn btn-danger">Verwijderen</button>
        </div>
    </form>
</span>
<?php
 require_once FOOTER;




<?php
require_once '../core/system.init.php';
require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
require_once FRAMEWORK;

if (isset($_POST['editPassword'])){
 $newUserData = filter_input_array(INPUT_POST);
 $enabled = true;
 
 try {
  $action = $account->editPassword($newUserData['account_id'], $newUserData['password_current'], $newUserData['password_new'], $newUserData['password_validate']);
 }
 catch (Exception $e) {
 print '<div class="alert alert-danger" role="alert">
            Er ging iets fout: DB SYSTEM ERROR: '.$e->getMessage().'</div>';
 }
 
 if($action) {
     print '<div class="alert alert-success" role="alert">
            Wachtwoord succesvol gewijzigd.
          </div>';
 }
 else {
    print '<div class="alert alert-danger" role="alert">
            Er ging iets fout.. Het wachtwoord is niet gewijzigd.
          </div>';
 }
}

$userData = $account->getUserData();
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">people</span>
       <span class="text-secondary">Accounts &nbsp; > &nbsp; </span>
       <span>Wachtwoord wijzigen</span>
   </h4> 
</div>
<form method="post">
    <div class="row">
        <div class="col">
            <div class="mb-3 form-floating">
                <input type="password" class="form-control" name="password_current" value="" autocomplete="off" required />
                <label for="password_current">Huidige wachtwoord</label>
            </div>
        </div>
        <div class="col">
            <div class="mb-3 form-floating">
                <input type="password" class="form-control" name="password_new" id="password_new" value="" autocomplete="off" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" min="8" max="100" required />
                <label for="password_new">Nieuwe wachtwoord</label>
            </div>
            <div class="mb-3 form-floating">
 		<input type="password" class="form-control" name="password_validate" value="" autocomplete="off" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required />
                <label for="password_validate">Herhaal nieuw wachtwoord</label>
            </div>
        </div>
        <div class="col">
            <p>Je nieuwe wachtwoord moet minstens aan de volgende eisen voldoen:</p>
            <div id="message">
                <p id="letter" class="invalid">1 <b>kleine</b> letter</p>
                <p id="capital" class="invalid">1 <b>hoofdletter</b></p>
                <p id="number" class="invalid">1 <b>cijfer</b></p>
                <p id="length" class="invalid">Minimaal <b>8 tekens</b></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col pt-4 pe-5">
            <input type="number" name="account_id" value="<?php print $userData->account_id; ?>" hidden />
            <button type="submit" name="editPassword" class="btn btn-success float-end">Wijzig wachtwoord</button>
        </div>
            
    </div>
</form>
       
                <div class="setting">
                       
                </div>
            </ul>
            </form>
        </div>
    </div>
</div>
<?php
 require_once FOOTER;
?>
<style>
#message p {
  padding: 0px 15px;
}

.valid {
  color: green;
  line-height: 18px;
}

.valid:before {
	font-family: "Material Icons"; 
	font-size: 18px;
  	position: relative;
  	left: -15px;
        top: 4px;
  	content: "check";
	font-weight: 900;
}

.invalid {
  color: red;
}

.invalid:before {
	font-family: "Material Icons"; 
	font-size: 18px;
  	position: relative;
  	left: -15px;
        top: 4px;
  	content: "close";
	font-weight: 900;
}
</style>
<script>
var myInput = document.getElementById("password_new");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

myInput.onkeyup = function() {
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
}
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
</script>


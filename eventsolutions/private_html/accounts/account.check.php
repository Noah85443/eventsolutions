<?php
require ACCOUNTS;
$account = new Account();

if(!$account->sessionLogin()) {
	$url = $_SERVER['HTTP_HOST'];
	$host = explode('.', $url)[0];
	
	header("Location:".LINK_LOGIN.'?source='.$host);
}
 
$userType = json_decode($account->getUserData()->account_type, true);

if((!empty($userType[0])) && (!empty($accessLevel))) {
    foreach($accessLevel as $level) {
     if (!in_array($level, $userType)) {
      print "Invalid user type";
      exit();
     }
    }
}

if(in_array("admin", $userType)) {
    $userId = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    if(!empty($userId)) {
        $userData = $account->getUserData($userId);
        $adminId = $account->getUserData()->account_id;
    } 
    if(empty($userData)) {
        $userData = $account->getUserData();
    }
}
else {
    $userData = $account->getUserData();
} 
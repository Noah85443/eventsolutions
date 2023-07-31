<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

 $accessLevel = array("admin");
 require_once 'system.init.php';
 require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;


?>
<main>
 <div class="blocks">
	<div class="block-25 grijs">
    	<h2>API Connect Moneybird</h2>
        <?php 
        
        
        $result = new Moneybird(); 
        $result = $result->toonToken();
  		print_r($result);?>
    </div>
 </div>
</main>

<?php
 require_once FOOTER;
?>

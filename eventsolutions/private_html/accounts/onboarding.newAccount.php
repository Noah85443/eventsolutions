<?php
require_once '../core/system.init.php';
require ACCOUNTS;

$account = new Account();
$login = FALSE;

$source = array(
    "name" => "EventSolutions",
    "url" => "https://accounts.".HOST."/overzicht"
);
$notificatie = null;

if (isset($_POST['newAccount'])){
 $newUserData = filter_input_array(INPUT_POST);
 $enabled = true;
 
 try {
  $action = $account->addAccount($newUserData['account_name'], $newUserData['account_realname'], $newUserData['account_email']);
 }
 catch (Exception $e) {
  $notificatie = "<div class=\"notification error\">Er ging iets fout...: ".$e->getMessage()."</div>";
 }
 
 if(!empty($action)) {
  $notificatie = "<strong>Nieuw account succesvol aangemaakt.</strong><br/ ><br />Het wachtwoord is verzonden naar het opgegeven e-mailadres.<br /><br /><a href=".BASE_ACCOUNTS.">Klik hier om in te loggen.</a>";
 }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>EventSolutions</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" />
        <style>
    html, body {padding: 0; margin: 0; width: 100%; background: linear-gradient(65deg,#ffa801,#f5bc3c); font-family:Tahoma, Geneva, sans-serif;
	font-size: 12px;}
    #container {}
    #content {width: 400px; margin: 100px auto 0 auto; box-shadow: 0 0 9px 0 rgba(0, 0, 0, 0.3);}
    #content > header {background-color: #FFF; padding: 25px 0 0 25px;}
    #content > main {background-color: #FFF; padding: 25px;}
    img.ident {width: 65%;}
    main form {
  	display: flex;
  	flex-wrap: wrap;
  	justify-content: center;
  	padding-top: 20px;
}
main form label {
  	display: flex;
  	justify-content: center;
  	align-items: center;
  	width: 50px;
  	height: 50px;
  	background-color: #3274d6;
  	color: #ffffff;
}
main form input[type="password"], main form input[type="text"] {
  	width: 260px;
  	height: 50px;
  	background-color: #FCFCFC;
        border: none;
  	margin-bottom: 20px;
  	padding: 0 15px;
}
main form input[type="submit"], main a {
  	width: 100%;
  	padding: 15px;
 	margin-top: 20px;
  	background-color: #3274d6;
  	border: 0;
  	cursor: pointer;
  	font-weight: bold;
  	color: #ffffff;
  	transition: background-color 0.2s;
}

main a {
    display: block;
    width: calc(100% - 20px);
    text-decoration: none;
    text-align: center;
}
main form input[type="submit"]:hover, main a:hover {
	background-color: #2868c7;
  	transition: background-color 0.2s;
}

div.forgotPw {
    margin-top: 25px;
}

div.forgotPw a {
    text-decoration: none;
    color: #000;
}

div.forgotPw a:hover {
    color: #ffa801;
}
</style>
    </head>
    <body>
        <div id="container">
            <div id="content">
                <header>
                    <img class="ident" src="https://<?php print HOST; ?>/styles/images/logo.png" alt="EventSolutions" />
                </header>
<?php
	    print '<main>';
            if(empty($notificatie)) {
            print ' 
                <span>Nieuw gebruikersaccount aanmaken<br></span>
                    <form action="" method="post">
                        <label for="username">
                            <i class="fas fa-user"></i>
			</label>
			<input type="text" name="account_name" placeholder="Gebruikersnaam" id="username" required>
                        <label for="realname">
                            <i class="fas fa-user"></i>
			</label>
			<input type="text" name="account_realname" placeholder="Voor- en Achternaam" id="realname" required>
			<label for="password">
                            <i class="fas fa-at"></i>
			</label>
			<input type="text" name="account_email" placeholder="E-mailadres" id="email" >
                        <input type="submit" value="Verstuur wachtwoord naar e-mailadres" name="newAccount">
			</form> ';
            }
            else {print $notificatie;}
            print ' 
                </main>';

?>
                <footer>    
                </footer>
            </div>
        </div>
    </body>
</html>
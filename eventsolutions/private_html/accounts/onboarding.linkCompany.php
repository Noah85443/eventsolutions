<?php
require_once '../core/system.init.php';
require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;


$source = array(
    "name" => "EventSolutions",
    "url" => "https://accounts.".HOST."/overzicht"
);
$notificatie = null;

if (isset($_POST['koppelAccount'])){
 $koppeldata = filter_input_array(INPUT_POST);
 $gebruiker = $account->getUserData()->account_id;
 
 try {
  $action = relaties::koppelAccount($gebruiker, $koppeldata['koppelcode']);
 }
 catch (Exception $e) {
  $notificatie = "<div class=\"notification error\">Er ging iets fout...: ".$e->getMessage()."</div>";
 }
 
 if(!empty($action)) {
  $notificatie = "<strong>Account succesvol gekoppeld aan:<br />{$action}.</strong><br/ ><br /><a href=".BASE_RELATIES.">Klik hier om verder te gaan.</a>";
  
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
                <span>Koppel account aan bestaande relatie<br></span>
                    <form action="" method="post"> 
			<label for="koppelcode">
                            <i class="fas fa-link"></i>
			</label>
			<input type="text" name="koppelcode" placeholder="Koppelcode" id="koppelcode" >
                        <input type="submit" value="Koppel bedrijf aan mijn account" name="koppelAccount">
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
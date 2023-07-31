<?php
require_once '../core/system.init.php';
require ACCOUNTS;

$account = new Account();

$return = $account->logout();

if(!$return) {$msg = 'Je bent met succes uitgelogd.<br /><br /> Tot de volgende keer!';}
elseif($return) {$msg = 'Uitloggen mislukt. Probeer het nogmaals ;-(';}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>EventSolutions</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" />
        <style>
    html, body {padding: 0; margin: 0; width: 100%; background: linear-gradient(65deg,#ffa801,#f5bc3c); font-family: Tahoma, Geneva, sans-serif;
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
main form input[type="submit"] {
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
main form input[type="submit"]:hover {
	background-color: #2868c7;
  	transition: background-color 0.2s;
}

.button {
	padding: 15px; 
	margin: 35px auto 0px;
	display: block;
	width: calc(80% - 30px);
	height: 20px;
	line-height: 20px;
	text-decoration: none;
	text-align: center;
	border: none;
        background: #9ACD32;
}

.button a {
    text-decoration: none;
    color: #FFF;
}
</style>
    </head>
    <body>
        <div id="container">
            <div id="content">
                <header>
                    <img class="ident" src="https://<?php print HOST; ?>/styles/images/logo.png"   alt="EventSolutions" />
                </header>
<main>
                <span><?php print $msg; ?><br></span> 
                <div class="button"><a href="https://<?php print HOST; ?>">Opnieuw inloggen</a></div>
                </main>
                <footer>    
                </footer>
            </div>
        </div>
    </body>
</html>
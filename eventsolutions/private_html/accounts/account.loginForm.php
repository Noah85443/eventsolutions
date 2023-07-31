<?php
require_once '../core/system.init.php';
require ACCOUNTS;

$account = new Account();
$login = FALSE;

// redir base
$redirect = filter_input(INPUT_POST, 'source', FILTER_DEFAULT);
if(empty($redirect)) {$redirect = filter_input(INPUT_GET, 'source', FILTER_DEFAULT);}
switch ($redirect){
    case 'plankie':
        $source = array(
            "name" => "Plankie",
            "url" => "https://www.plankie.shop"
        );
    break;
    case 'office':
        $source = array(
            "name" => "EventSolutions backoffice",
            "url" => "https://office.".HOST
        );
    break;
    case 'relaties':
        $source = array(
            "name" => "EventSolutions backoffice",
            "url" => "https://relaties.".HOST
        );
    break;
	case 'crew':
        $source = array(
            "name" => "EventSolutions Crewportal",
            "url" => "https://crew.".HOST
        );
    break;
	case 'accounts':
        $source = array(
            "name" => "EventSolutions Account Control",
            "url" => "https://accounts.".HOST."/overzicht"
        );
    break;
    default:
        $source = array(
            "name" => "EventSolutions",
            "url" => "https://accounts.".HOST."/overzicht"
        );
}

if($account->sessionLogin()) {
   $login = TRUE; 
}

if (filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_DEFAULT) === 'POST') {
$login = FALSE;

try {
    $username = filter_input(INPUT_POST, 'username', FILTER_DEFAULT); 
    $password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);
    
    $login = $account->login($username, $password);
}
catch (Exception $e) {echo $e->getMessage(); die();}
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
                    <img class="ident" src="https://<?php print HOST; ?>/images/logo.png"   alt="EventSolutions" />
                </header>
<?php
if ($login) {
	header("Location:".$source['url']);
}
else {
        $orgin = filter_input(INPUT_GET, "source", FILTER_VALIDATE_INT);
	    print '<main>
                <span>Inloggen voor: '.$source['name'].'<br></span>
                    <form action="" method="post">
                        <label for="username">
                            <i class="fas fa-user"></i>
			</label>
			<input type="text" name="username" placeholder="Gebruikersnaam" id="username" required>
			<label for="password">
                            <i class="fas fa-lock"></i>
			</label>
			<input type="password" name="password" placeholder="Wachtwoord" id="password" >
                        <input type="hidden" name="redir" id="redit" value="'. $orgin. '">
                        <input type="submit" value="Login">
                        <div class="forgotPw"><a href="/wachtwoord-vergeten">Wachtwoord vergeten?</a></div>
			</form> 
                </main>';
}
?>
                <footer>    
                </footer>
            </div>
        </div>
    </body>
</html>
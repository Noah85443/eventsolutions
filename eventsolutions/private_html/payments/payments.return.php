<?php
require_once '../core/system.init.php';
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
    #content {width: 400px; margin: 50px auto 0 auto; box-shadow: 0 0 9px 0 rgba(0, 0, 0, 0.3);}
    #content > header {background-color: #FFF; padding: 25px 0 0 25px;}
    #content > main {background-color: #FFF; padding: 25px;}
    img.ident {width: 65%;}
    
.button {
        display: block;
  	width: calc(100% - 30px);
  	padding: 15px;
 	margin-top: 20px;
  	background-color: #3274d6;
  	border: 0;
  	cursor: pointer;
  	font-weight: bold;
  	color: #ffffff;
  	transition: background-color 0.2s;
        text-decoration: none;
        text-align: center;
        border-radius: 8px;
}
.button:hover {
	background-color: #2868c7;
  	transition: background-color 0.2s;
}

.paymentMethod {
    width: 100%;
    padding: 10px 0px;
    margin: 10px 0px;
    height: 50px;
}

.paymentMethod:hover {
    background: #E9E9E9;
    margin: 10px -25px;
    padding: 10px 25px;
}

.paymentMethodIssuers {
    width: calc(100% - 40px);
    padding: 10px 0px;
    margin: 10px 0px 10px 40px;
    height: 24px;
    display: none;
}
.paymentIcon {
    float: left;
    width: 64px;
}

.paymentDescription {
    float: left;
    margin-left: 25px;
    font-size: 16px;
    width: calc(100%-94px);
    margin-left: 30px;
    display: block;
    line-height: 50px;
}

.paymentMethodIssuers > .paymentDescription {
    font-size: 14px;
    line-height: 24px;
    margin-left: 0px;
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
                <?php
                if(!empty(filter_input(INPUT_GET, 'betaalcode', FILTER_DEFAULT))) {
                    $betaalcode = filter_input(INPUT_GET, 'betaalcode', FILTER_DEFAULT);
                    $factuurData = betalingen::factuurData($betaalcode);
                    $betalingsStatus = facturatie::statusId($factuurData->status);
                    if($betalingsStatus["nr"] <= 7) {
                        $statusMsg = "Nog niet afgerond of mislukt.";
                        $buttonLink = "https://payments.".HOST."/betaling/".$betaalcode;
                        $buttonMsg = "Start betaling opnieuw";
                    }
                    elseif ($betalingsStatus["nr"] == 8) {
                        $statusMsg = "Succesvol ontvangen en verwerkt.";
                        $buttonLink = "https://www.eventsolutions.nu";
                        $buttonMsg = "Sluit dit venster";
                    } 
                    elseif ($betalingsStatus["nr"] == 9) {
                        $statusMsg = "Deze factuur is reeds gecrediteerd.";
                        $buttonLink = "https://www.eventsolutions.nu";
                        $buttonMsg = "Sluit dit venster";
                    } 
                    else {
                        $statusMsg = "Onbekend.<br>Neem contact op via administratie@eventsolutions.nu";
                        $buttonLink = "mailto://administratie@eventsolutions.nu";
                        $buttonMsg = "Mail ons";
                    } 
                    print " 
                        <h2>Online betaling factuur {$factuurData->nummer}</h2>
                        <br />
                        Factuurdatum: ".convert::datumKort($factuurData->datum)."
                        <br />
                        Vervaldatum: ".convert::datumKort($factuurData->vervaldatum)." 
                        <br /><br />
                        Totaalbedrag: &euro; {$factuurData->totaal}
                        <br /><br /><br />
                        Status van betaling:
                        <br />
                        <strong>{$statusMsg}</strong>
                        <br / ><br />
                        <a href=\"{$buttonLink}\" class=\"button\">{$buttonMsg}</a>
                    ";
                }
                ?>
                </main>

            </div>
        </div>
    </body>
</html>
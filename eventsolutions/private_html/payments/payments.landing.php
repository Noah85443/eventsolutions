<?php
require_once '../core/system.init.php';

if (isset($_POST['initPayment'])){
 $dataset = filter_input_array(INPUT_POST);

 $payment = new mollie();
 $dataLink = $payment->createPayment($dataset['betaalcode'], $dataset['method'], $dataset['issuer']);
 header('Location: '.$dataLink);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>EventSolutions</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
  	width: 100%;
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

#paymentMethods input[type=radio] {
    display: none;
}

#paymentMethods input[type=radio]:checked + label > .paymentMethod {
    background-color: #3274d6;
    margin: 10px -25px;
    padding: 10px 25px;
    color: #FFF;
    transition: background-color 0.3s;
}

#paymentMethods input[type=radio]:checked + label > .paymentMethodIssuers {
    background-color: #3274d6;
    padding: 10px 25px 10px 65px;
    margin: 10px 0px 0px -25px;
    color: #FFF;
    transition: background-color 0.3s;
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
                <form method="post">
<?php
            if(!empty(filter_input(INPUT_GET, 'betaalcode', FILTER_DEFAULT))) {
            $betaalcode = filter_input(INPUT_GET, 'betaalcode', FILTER_DEFAULT);
            $dataset = betalingen::factuurData($betaalcode);
            $mollie = new mollie();
            if($dataset->status < 8) {
            $dataset->totaal = number_format($dataset->totaal, 2,'.','');
	    print "

                    <h2>Online betaling factuur {$dataset->nummer}</h2>
                    <br />
                    Factuurdatum: ".convert::datumKort($dataset->datum)."
                    <br />
                    Vervaldatum: ".convert::datumKort($dataset->vervaldatum)."
                    <br /><br />
                    Totaalbedrag: &euro; {$dataset->totaal}
                    <br /><br /><br />
                    Kies een betalingsoptie:<br />
                    <div id=\"paymentMethods\">
            ";
                    $methods = $mollie->getMethods();
                    for($c=0; $c < count($methods->_embedded->methods); $c++) {
                        print "<input type=\"radio\" id=\"{$methods->_embedded->methods[$c]->id}\" name=\"method\" value=\"{$methods->_embedded->methods[$c]->id}\">";
                        print "<label for=\"{$methods->_embedded->methods[$c]->id}\">";
                        print "<div class=\"paymentMethod\" id=\"{$methods->_embedded->methods[$c]->id}\">".PHP_EOL
                        . "<div class=\"paymentIcon\"><img src=\"{$methods->_embedded->methods[$c]->image->size2x}\" /></div>".PHP_EOL
                        . "<div class=\"paymentDescription\">{$methods->_embedded->methods[$c]->description}</div>".PHP_EOL
                        . "</label>"
                        . "</div>".PHP_EOL;
                        if (isset($methods->_embedded->methods[$c]->issuers)) {
                            for($a=0; $a < count($methods->_embedded->methods[$c]->issuers); $a++) {
                                print "<input type=\"radio\" id=\"{$methods->_embedded->methods[$c]->issuers[$a]->id}\" name=\"issuer\" value=\"{$methods->_embedded->methods[$c]->issuers[$a]->id}\">".PHP_EOL
                                . "<label for=\"{$methods->_embedded->methods[$c]->issuers[$a]->id}\">".PHP_EOL
                                    . "<div class=\"paymentMethodIssuers\" id=\"{$methods->_embedded->methods[$c]->issuers[$a]->id}\">".PHP_EOL
                                        . "<div class=\"paymentIcon\"><img src=\"{$methods->_embedded->methods[$c]->issuers[$a]->image->size1x}\" /></div>".PHP_EOL
                                        . "<div class=\"paymentDescription\">{$methods->_embedded->methods[$c]->issuers[$a]->name}</div>".PHP_EOL
                                    . "</div>".PHP_EOL
                                ."</label>".PHP_EOL;

                            }
                        }
                    }
            print "
                    </div>
                    <input type=\"hidden\" name=\"betaalcode\" id=\"betaalcode\" value=\"{$dataset->betaalcode}\" />
                    <input type=\"submit\" class=\"button\" name=\"initPayment\" value=\"Betaal factuur\" />



            ";
            }
            else {
                print "<strong>Factuur is reeds betaald.</strong><br /><br /> Je kunt de factuur downloaden in je klantomgeving.";
 
            }
            }
            else {
                print "<strong>Er is geen data gevonden.</strong><br /><br /> Probeer het opnieuw of neem contact met ons op via administratie@eventsolutions.nu";
            }
?>

                    </form>
                </main>

            </div>
        </div>
    </body>
</html>
<script>
    $("div#ideal").click(function(){
        $("div.paymentMethodIssuers").toggle(300);
    });
</script>

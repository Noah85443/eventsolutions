<?php
require_once 'core/system.init.php';

if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    unset($_SESSION['cart'][$_GET['remove']]);
}

if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'aantal') !== false && is_numeric($v)) {
            $id = str_replace('aantal-', '', $k);
            $quantity = (int)$v;
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
    	        $_SESSION['cart'][$id] = $quantity;
            }
        }
    } 
}

if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    header('Location: /offerte-gegevens');
    exit;
}
?>

<!DOCTYPE html>
<html>
    <?php require_once AVJF_HEADERS; ?>
    <body>
        <?php require_once AVJF_NAVIGATION; ?>
        <div class="container">
            <div class="section">
            <form action="/winkelwagen" method="post">
                <?php
                    if (empty($_SESSION['cart'])) { 
                        
                        print "Je offerte is nog leeg! Voeg artikelen toe om een eerste prijsopgave te zien.";
                    }
                    else { 
                        $cart = $_SESSION['cart'];
                ?>
                <h4>Mijn gekozen materialen:</h4>
                <table>
                    <tr>
                    	<td colspan="2">Artikel</td>
                    	<td>Aantal</td>
                        <td>Stuk(s)</td>
                    	<td>Prijs</td>
                    	<td></td>
                    </tr>
                    <?php
                        $subTotaal = null; $btwTotaal = null;
			foreach($cart as $artikelId => $count) {
                            $artikel = API::Call("artikel",$artikelId);	
                    ?>
                    <tr>
                    	<td class="img">
                            <?php
                                if (!empty($artikel->afbeelding)) {
                                    $artikel->afbeelding = "https://eventsolutions.nu/images/rentalProducten/".$artikel->afbeelding;
                                    print "<img src=\"{$artikel->afbeelding}\" width=\"auto\" style=\"max-width:75px;\" height=\"60px\" />";
				}
				else {
                                    $artikel->afbeelding = "https://eventsolutions.nu/images/noimg-allesvoorjefeest.png";
                                    print "<img src=\"{$artikel->afbeelding}\" width=\"auto\" height=\"60px\" />";
                                }
                            ?>
                    	</td>
                    	<td>
                            <?php print $artikel->artikelnaam; ?>
                    	</td>
                    	<td class="aantal">
                            <input type="number" name="aantal-<?php print $artikel->id; ?>" value="<?php print $count; ?>" min="1" style="width:50px;float:left;padding-left:8px;margin-right:25px;background:#F5F5F5;" required> 
                    	</td>
                        <td class="aantal">
                            <?php print $artikel->stuksPerEenheid * $count; ?>
                    	</td>
                    	<td class="prijsTotaal">
                            <?php
                                $regelBruto = $artikel->prijs * $count;
                                $regelBtw = $regelBruto * ($artikel->btwTarief/100);
                                $regelTotaal = $regelBruto + $regelBtw;
                    		print $prijsNetto = convert::prijs($regelBruto, $artikel->btwTarief);
				$subTotaal += $regelBruto;
                                $btwTotaal += $regelBtw;
                            ?>
                        </td>
                        <td>
                            <a href="/winkelwagen/verwijder/<?php print $artikel->id; ?>" class="btn red">
                                <i class="material-icons">delete_forever</i>
                            </a>
                        </td>
                    </tr>
                    <?php 
                        }
                	$nettoTotaal = $subTotaal + $btwTotaal;
                    ?>
                    <tr>
                        <td colspan="4" class="subTotaal">
                            <br /><br />
                            <strong>Totale huurprijs:</strong><br /><br />
                            waarvan BTW:<br /><br />
                            Subtotaal (excl. BTW):<br /><br />
                            <i>* Eventuele kortingen en transportkosten worden berekend in de offerte die je per e-mail van ons ontvangt.</i>
                        </td>
                        <td>
                            <br /><br />
                            <strong><?php print convert::toEuro($nettoTotaal); ?></strong><br /><br />
                            <?php print convert::toEuro($btwTotaal); ?><br /><br />
                            <?php print convert::toEuro($subTotaal); ?><br /><br /> 
                        </td>
                    </tr>
                </table>
                <div class="row buttons">
                    <br><br>
                    <button type="submit" id="placeorder" name="placeorder" class="btn green accent-4 darken-2">
                        <i class="material-icons left">check_box</i>Gegevens invoeren
                    </button>
                    <button type="submit" id="update" name="update" class="btn yellow accent-4 darken-2">
                        <i class="material-icons left">cached</i>Update aantallen
                    </button>
                </div>
                <?php } ?>
            </form>
            </div>
       </div>
        <?php 
            require_once AVJF_FOOTER; 
            require_once AVJF_SCRIPTS;
        ?>
    </body>
</html>
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
<!doctype html>
<html lang="en">
    <?php require_once header; ?>  
    <body>
	<?php require_once navigation; ?>
        <div class="container">
   	
                <?php
                    if (empty($_SESSION['cart'])) { 
                        
                        print "Je hebt nog geen artikelen gekozen voor in je offerte.<br />Ga op toch door onze verhuurshop en vind alles wat je nodig hebt!.";
                    }
                    else { 
                        $cart = $_SESSION['cart'];
                ?>
                <form action="/offerte" method="post">
                <h4>Mijn offerte-aanvraag</h4>
                <table class="table table-hover align-middle">
                    <thead>
                    	<th scope="col" colspan="2">Artikel</th>
                    	<th scope="col">Aantal</th>
                        <th scope="col">Stuk(s)</th>
                    	<th scope="col">Prijs</th>
                    	<th scope="col"></th>
                    </thead>
                    <tbody>
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
                            <input type="number" name="aantal-<?php print $artikel->id; ?>" value="<?php print $count; ?>" min="1" class=form-control" style="border:1px;border-color:#CCC;rounded-border:5px;padding:5px;width:75px;" required /> 
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
                            <a href="/offerte/verwijder/<?php print $artikel->id; ?>" class="btn red">
                                <i class="material-symbols-outlined">delete_forever</i>
                            </a>
                        </td>
                    </tr>
                    <?php 
                        }
                	$nettoTotaal = $subTotaal + $btwTotaal;
                    ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td colspan="3">
                                <strong>Totale huurprijs:</strong>
                            </td>
                            <td><strong><?php print convert::toEuro($nettoTotaal); ?></strong></td>
                            <td></td>
                                
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="3">
                                BTW-Totaal:
                            </td>
                            <td><?php print convert::toEuro($btwTotaal); ?></td>
                            <td></td>
                                
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="3">
                                Subtotaal (excl. BTW):
                            </td>
                            <td><?php print convert::toEuro($subTotaal); ?></td>
                            <td></td>
                                
                        </tr>
                    </tfoot>
                </table>
                <div class="row mt-5">
                    <div class="col-12">
                        <button type="submit" id="placeorder" name="placeorder" class="btn btn-success">
                            <i class="material-symbols-outlined" style="float:left;padding-right:10px;">keyboard_double_arrow_right</i>Gegevens invoeren
                        </button>
                        <button type="submit" id="update" name="update" class="btn btn-outline-dark">
                            <i class="material-symbols-outlined" style="float:left;padding-right:10px;">sync</i><span>Update aantallen</span>
                        </button>
                    </div>
                </div>
                </form>
            <?php } ?>
            
        </div>
        <?php require_once footer; ?>
        <?php require_once scripts; ?>
    </body>
</html>
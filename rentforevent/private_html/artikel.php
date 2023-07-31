<?php 
    require_once './core/system.init.php'; 
    
    $data = filter_input(INPUT_GET, 'artikel');
    $artikel = API::Call("artikel",$data);
?>

<!doctype html>
<html lang="en">
    <?php require_once header; ?>  
    <body>
	<?php require_once navigation; ?>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3><?php print $artikel->artikelnaam; ?></h3>
                    <p>Artikelnr: <?php print $artikel->artikelnummer; ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <img src="<?php print IMG_Article . $artikel->afbeelding; ?>" alt="<?php print $artikel->artikelnaam; ?>" class="img-fluid"/>
                </div>
                <div class="col-2">
                </div>
                <div class="col-4">
                    <?php if($artikel->samengesteld == 2) {
                        print 'Verpakt per '.$artikel->stuksPerEenheid.' stuks<br />';
                    ?>
                        &euro; <?php print number_format($artikel->prijs/$artikel->stuksPerEenheid,2,',','.'); ?>
                        / stuk (excl. BTW)
                       	<br /><br />
                    <?php  } ?>
                    
                        <?php echo $artikel->artikelsoort; ?> (exclusief BTW):<br />
                        <span style="color:#71AF4F;">&euro; <?php print number_format($artikel->prijs,2,',','.'); ?></span>
                        / <?php print $artikel->stuksPerEenheid; ?> stuk(s)
                        <br />
                        extra huurdag: &euro; <?php print number_format(($artikel->prijs * (1 * $shopData['huurFactor'])),2,',','.'); ?>
                        <br /><br />
                        <?php echo $artikel->artikelsoort; ?> (inclusief BTW):<br />
                        <?php $btw = '1.'.$artikel->btwTarief; ?>
                        &euro; <?php print number_format($artikel->prijs * $btw,2,',','.'); ?>
                        / <?php print $artikel->stuksPerEenheid; ?> stuk(s)
                       	<br />
                        extra huurdag: &euro; <?php print number_format(($artikel->prijs * (1 * $shopData['huurFactor'])) * $btw,2,',','.'); ?>
                        <br /><br />
                        <div style="background:#EDA555; padding: 25px;" id="addToCartBlock">
							<form action="/core/scripts/winkelwagen.php" method="post" id="addToCart">
                                            <div class="row">
                                                <input type="number" name="aantal" id="aantal" value="1" min="1" style="width:50px;float:left;padding-left:8px;margin-right:25px;background:#F5F5F5;" required>
                                                <div class="aantal" style="line-height:3rem;">
                                                    x &nbsp; <span id="stuksPerEenheid"><?php print $artikel->stuksPerEenheid; ?></span> &nbsp; = &nbsp; <b id="totaalAantal"><?php print $artikel->stuksPerEenheid; ?></b><b>&nbsp; stuk(s)</b>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <input type="hidden" name="artikelId" id="artikelId" value="<?php print $artikel->id; ?>">
                                                <button type="submit" class="waves-effect waves-light btn green accent-4">
                                                    Toevoegen aan offerte
                                                </button>
                                            </div>
                                        </form>    
						</div>  
                    </div>
                </div>
            <div class="row">
                <div class="col-4">
                   <?php 
								print $artikel->beschrijving; 
								if($artikel->samengesteld == 2) {
									print "Let op: Dit artikel wordt verhuurd per <strong>{$artikel->stuksPerEenheid} stuks</strong>.<br /><br />";
								}
								if(!empty($artikel->onderdelen)) {
									print "Dit artikel bestaat uit:<br>";
									$onderdelen = json_decode($artikel->onderdelen);
									print "<table>";
									foreach($onderdelen as $onderdeel => $aantal) {
										$stmt = $conn->query("SELECT * FROM producten WHERE artikelId = '{$onderdeel}'");
										$onderdeel = $stmt->fetch(PDO::FETCH_OBJ);
										print "<tr><td><img src=\"/productImg/{$onderdeel->afbeeldingen}\" width=\"75px\" height=\"auto\" style=\"float:left;\"/></td>";
										print "<td><div style=\"line-height: 75px; float: left;\">".$aantal.'x '. $onderdeel->artikelnaam.'</div></td></tr>';
									}
									print "</table>";
								}
								
							?> 
                </div>
                <div class="col-4">
                    <?php 
                    
								if(!empty($artikel->emballage)) {
                                                                    print "<h4>Transport</h4>";
									print "Dit artikel is op de volgende manier verpakt:<br>";
									$emballage = json_decode($artikel->emballage);
									print "<table>";
									foreach($emballage as $onderdeel => $aantal) {
										$stmt = $conn->query("SELECT * FROM emballage WHERE artikelNr = '{$onderdeel}'");
										$onderdeel = $stmt->fetch(PDO::FETCH_OBJ);
										$formaat = json_decode($onderdeel->formaat);
										print "<tr><td><img src=\"/emballageImg/{$onderdeel->afbeeldingen}\" width=\"75px\" height=\"auto\" style=\"float:left;\"/></td>";
										print "<td><div style=\"line-height: 40px; float: left;\">".$aantal.'x&nbsp;&nbsp;'. $onderdeel->naam."</div><br>
											<div style=\"line-height: 18px; float: left; font-size: 13px;\">".$formaat->lengte.'cm (L) x '. $formaat->breedte.'cm (B) x '.$formaat->hoogte.'cm (H)</div></td></tr>';
									}
									print "</table>";
								}
                    ?>
                </div>
                <div class="col-4">
                    <?php 
                    	    	$kenmerken = json_decode($artikel->kenmerken, true);
                                if(!empty($artikel->kenmerken)) {print "<table>"; foreach($kenmerken as $kenmerk => $waarde) {
    								print "<tr class=\"kenmerkRegel\"><td>".$kenmerk."</td><td>".$waarde."</td></tr>"; //etc
                                } print "</table>";}
								?>
                </div>
            </div>
            </div>
        <?php require_once footer; ?>
        <?php require_once scripts; ?>
    </body>
</html>
<script>
$(document).on('input', '#aantal', function(){
    var aantal = $('#aantal').val();
	var stuksPerEenheid = $('#stuksPerEenheid').text();
	var totaalAantal = aantal * stuksPerEenheid;
    $("#totaalAantal").text(totaalAantal);
})
</script>
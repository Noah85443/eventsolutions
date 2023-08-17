<?php
require_once 'core/system.init.php';
$id = filter_input(INPUT_GET, "id");

$artikel = API::Call("artikel",$id);
$categorie = API::Call("artikelgroep",$artikel->artikelgroep);

if(empty($artikel->afbeelding)) {
    $artikel->afbeelding = "https://eventsolutions.nu/images/noimg-allesvoorjefeest.png";
}
else {
    $artikel->afbeelding = "https://eventsolutions.nu/images/rentalProducten/".$artikel->afbeelding;
}

$prijsNetto = convert::prijs($artikel->prijs, $artikel->btwTarief);
?>

<!DOCTYPE html>
<html>
    <?php require_once AVJF_HEADERS; ?>
    <body>
        <?php require_once AVJF_NAVIGATION; ?>
        <main>
        <div class="container">
            <div class="section">
                <nav class="clean">
                    <div class="nav-wrapper">
                        <div class="col s12">
                            <a href="/" class="breadcrumb">Startpagina</a>
                            <a href="/verhuur/alle-categorieen" class="breadcrumb">Verhuur</a>
                            <?php if($info->toplevel != 0) { ?>
                                <a href="/verhuur/categorie/<?php print $categorie->naam; ?>" class="breadcrumb"><?php print $info->toplevelName; ?></a>
                            <?php } ?>
                            <a href="/verhuur/categorie/<?php print $categorie->alias; ?>" class="breadcrumb"><?php print $categorie->naam; ?></a>
                            <a href="/verhuur/artikel/<?php print $artikel->alias; ?>" class="breadcrumb"><?php print $artikel->artikelnaam; ?></a>
                        </div>
                    </div>
                </nav>
                
            </div>
            <div class="section">
                <div class="row">
                    <?php if(!empty($id)) {
                        print ' 
                            <div class="row">
                                <h5 class="header col s12">'.$artikel->artikelnaam.'</h5>
                                <div class="col m6 s12">
                                    <div class="card">
                                        <div class="card-image" style="max-height:100%;">
                                            <img src="'.$artikel->afbeelding.'">
                                        </div>
                                    </div>
                                </div>
                                <div class="col m6 s12">
                                    <div class="card-panel grey lighten-4">
                                        <div class="row">
                                            <div class="col s6">Aantal/Stuks<br><h6>'.$artikel->stuksPerEenheid.'</h6></div>
                                            <div class="col s6">Prijs (incl. BTW)<br><h6 class="strong">'.$prijsNetto.'</h6></div>
                                        </div>
                                    </div>
                                    
                                    <div class="card-panel orange lighten-2" id="addToCartBlock">
                                        <form action="/actions/winkelwagen.php" method="post" id="addToCart">
                                            <div class="row">
                                                <input type="number" name="aantal" id="aantal" value="1" min="1" style="width:50px;float:left;padding-left:8px;margin-right:25px;background:#F5F5F5;" required>
                                                <div class="aantal" style="line-height:3rem;">
                                                    x &nbsp; <span id="stuksPerEenheid">'.$artikel->stuksPerEenheid.'</span> &nbsp; = &nbsp; <b id="totaalAantal">'.$artikel->stuksPerEenheid.'</b><b>&nbsp; stuk(s)</b>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <input type="hidden" name="artikelId" id="artikelId" value="'.$artikel->id.'">
                                                <button type="submit" class="waves-effect waves-light btn green accent-4">
                                                    <i class="material-icons left">add_box</i>Voeg toe aan mijn aanvraag
                                                </button>
                                            </div>
                                        </form>    
                                    </div>
                                </div>
                            </div>    
                            <div class="row">
                                <div class="col m6 s12">
                                    <p class="light">';
                                        if($artikel->samengesteld == 2) {
                                            print "Let op: Dit artikel wordt verhuurd per <strong>{$artikel->stuksPerEenheid} stuks</strong>.<br /><br />";
                                        }
                                        print $artikel->beschrijving.'
                                    </p>
                                </div>
                                <div class="col m6 s12">
                                    ';
                                        if(!empty($artikel->onderdelen)) {
                                            print "Dit artikel bestaat uit:<br>";
                                            $onderdelen = json_decode($artikel->onderdelen);
                                            print '<ul class="collection">';
                                                foreach($onderdelen as $onderdeel => $aantal) {
                                                    $product = API::Call("artikel",$onderdeel);
                                                    print '
                                                        <li class="collection-item avatar">
                                                            <img src="https://eventsolutions.nu/images/rentalProducten/'.$product->afbeelding.'" class="circle">
                                                            <span class="title">'.$aantal .'x '. $product->artikelnaam.'</span>
                                                        </li>
                                                    ';
                                                }
                                            print '</ul>';
					}
                                        if(!empty($artikel->emballage)) {
                                            print "<br /><br />Dit artikel is als volgt verpakt:<br>";
                                            $emballage = json_decode($artikel->emballage);
                                            print '<ul class="collection">';
                                                foreach($emballage as $onderdeel => $aantal) {
                                                    $emballage = //rentalEndpoint::emballageArtikel($onderdeel);
                                                    $formaat = json_decode($emballage->formaat);
                                                    print '
                                                        <li class="collection-item avatar">
                                                            <img src="https://'.HOST.'/images/rentalProducten/emballage/'.$emballage->afbeelding.'" class="circle">
                                                            <span class="title">'.$aantal .'x '. $emballage->naam.'</span>
                                                            <p>'.$formaat->lengte.'cm (L) x '. $formaat->breedte.'cm (B) x '.$formaat->hoogte.'cm (H)</p>
                                                        </li>
                                                    ';
						}
                                            print '</ul>';
					}
                            print '</div>
                            </div>
                            ';
                    } ?>
                </div>   
            </div>
        </div>
    </main>
       <?php 
            require_once AVJF_FOOTER; 
            require_once AVJF_SCRIPTS;
        ?>
        <script>
            $(document).on('input', '#aantal', function(){
             var aantal = $('#aantal').val();
	     var stuksPerEenheid = $('#stuksPerEenheid').text();
	     var totaalAantal = aantal * stuksPerEenheid;
             $("#totaalAantal").text(totaalAantal);
            });
        </script>
    </body>
</html>
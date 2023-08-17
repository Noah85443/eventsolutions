<?php
require_once 'core/system.init.php';

$categories = API::Call("artikelgroepen/voorpagina");

$showFeaturedCards = null;

for($x=0;$x<count($categories);$x++) {
    if(empty($categories[$x]->afbeelding)) {$categories[$x]->afbeelding = "/noImg.jpg";}
    $showFeaturedCards .= ' 
        <div class="col s12 m6 l4">
            <div class="card">
                <div class="card-image card-category">
                    <a href="/verhuur/categorie/'.$categories[$x]->alias.'">
                        <img src="https://eventsolutions.nu/images/rentalProducten/groupImg/'.$categories[$x]->afbeelding.'">
                        <span class="card-title">'.$categories[$x]->naam.'</span>
                    </a>
                </div>
            </div>
        </div>
    ';
}
  
 ?>

<!DOCTYPE html>
<html>
    <?php require_once AVJF_HEADERS; ?>
    <body>
        <?php require_once AVJF_NAVIGATION; ?>
        <main>
        <div class="container">
            <div class="section">
                <div class="row center">
                    <h5 class="header col s12 light">Van amuselepel tot zitzak: je vind het hier</h5>
                    <p class="light">
                        Liever alles zelf in de hand? Ook dan is allesvoorjefeest.nl de perfecte partner voor je feest!<br><br>
                        Duik in ons verhuurassortiment via de categoriën en thema's die je op deze pagina vind,<br>vul je winkelwagen (of vrachtwagen) en vraag eenvoudig een offerte aan.<br>
                        Weet je al zeker wat je nodig hebt? Reserveer en huur direct vanuit je winkelwagen! (onder voorbehoud van beschikbaarheid)
                    </p>
                </div>
            </div>
            <div class="row center">
                    <a href="/verhuur/alle-categorieen" id="download-button" class="btn-large waves-effect waves-light cyan">Naar volledig assortiment >></a>
                </div>
            <div class="divider"></div>
            <div class="section">
                <div class="row">
                    <h5 class="orange-text">Populaire categoriën en thema's</h5><br><br>
                    <?php print $showFeaturedCards; ?>
                </div>   
            </div>
        </div>
    </main>
        <?php 
            require_once AVJF_FOOTER; 
            require_once AVJF_SCRIPTS;
        ?>     
    </body>
</html>
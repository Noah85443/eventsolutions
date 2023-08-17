<?php
require_once 'core/system.init.php';
$categories = API::Call("artikelgroepen");

for($x=0;$x<count($categories);$x++) {
    if($categories[$x]->toplevel == 0) {
    if(empty($categories[$x]->afbeelding)) {$categories[$x]->afbeelding = "noImg.jpg";}
    $showSubcategories .= ' 
        <div class="col s12 m6 l4">
            <div class="card small">
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
                <div class="row">
                    <h5 class="header col s12">Alle categoriën</h5>
                </div>
                <nav class="clean">
                    <div class="nav-wrapper">
                        <div class="col s12 ">
                            <a href="/" class="breadcrumb">Startpagina</a>
                            <a href="/verhuur" class="breadcrumb">Verhuur</a>
                            <a href="/verhuur/alle-categorieen" class="breadcrumb">Alle categoriën</a>
                        </div>
                    </div>
                </nav>
                <p class="light">
                </p>
            </div>
            <div class="section">
                <div class="row equal-height-grid">
                    <?php print_r($showSubcategories); ?>
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
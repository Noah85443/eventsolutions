<?php
require_once 'core/system.init.php';
$categorie = filter_input(INPUT_GET, "id");
$artikelGroep = API::Call("artikelgroep",$categorie);
$subgroepen = API::Call("artikelgroepen/subgroepen",$categorie);


$showSubcategories = null;
if(!array_key_exists("message",$subgroepen)) {
for($x=0;$x<count($subgroepen);$x++) {
    if(empty($subgroepen[$x]->afbeelding)) {$subgroepen[$x]->afbeelding = "/noImg.jpg";}
    $showSubcategories .= ' 
        <div class="col s12 m6 l4">
            <div class="card">
                <div class="card-image card-category">
                    <a href="/verhuur/categorie/'.$subgroepen[$x]->alias.'">
                        <img src="https://eventsolutions.nu/images/rentalProducten/groupImg/'.$subgroepen[$x]->afbeelding.'">
                        <span class="card-title">'.$subgroepen[$x]->naam.'</span>
                    </a>
                </div>
            </div>
        </div>
    ';
}
}

$toonArtikelen = null;
$artikelen = API::Call("artikelgroepen/artikelen",$artikelGroep->id);

if(!array_key_exists("message",$artikelen)) {
for($x=0;$x<count($artikelen);$x++) {
    if(empty($artikelen[$x]->afbeelding)) {$artikelen[$x]->afbeelding = "https://eventsolutions.nu/images/noimg-allesvoorjefeest.png";}
    else {$artikelen[$x]->afbeelding = "https://eventsolutions.nu/images/rentalProducten/".$artikelen[$x]->afbeelding;}
    $toonArtikelen .= ' 
        <div class="col s12 m6 l3">
            <div class="card hoverable small" style="height:300px;">
                <div class="card-image" style="max-height:100%;">
                    <img src="'.$artikelen[$x]->afbeelding.'">
                </div>
                <div class="card-action">
                    <a href="/verhuur/artikel/'.$artikelen[$x]->alias.'">'.$artikelen[$x]->artikelnaam.'</a>
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
                    <h5 class="header col s12"><?php print $info->naam; ?></h5>
                </div>
                <nav class="clean">
                    <div class="nav-wrapper">
                        <div class="col s12">
                            <a href="/" class="breadcrumb">Startpagina</a>
                            <a href="/verhuur/alle-categorieen" class="breadcrumb">Verhuur</a>
                            <?php if($info->toplevel != 0) { ?>
                                <a href="/verhuur/categorie/<?php print $info->toplevelAlias; ?>" class="breadcrumb"><?php print $info->toplevelName; ?></a>
                            <?php } ?>
                            <a href="/verhuur/categorie/<?php print $info->alias; ?>" class="breadcrumb"><?php print $info->naam; ?></a>
                        </div>
                    </div>
                </nav>
                <p class="light">
                    <?php print $info->beschrijving; ?>
                </p>
            </div>
            <div class="section">
                <div class="row">
                    <?php print_r($showSubcategories); ?>
                </div> 
                 <div class="row">
                    <?php print_r($toonArtikelen); ?>
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
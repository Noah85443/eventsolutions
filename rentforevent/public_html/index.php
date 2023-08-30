<?php
require_once './core/system.init.php';

$items = api::Call("artikelgroepen/voorpagina");
?>

<!doctype html>
<html lang="en">


<?php require_once header; ?>


<body style="margin: 0; overflow-x: hidden;">
    <div class="bg-image-wrapper">
        <div class="bg-image" style="background-image: url('https://www.rentforevents.nl/images/background.jpeg');">
        </div>
        <div class="navigation-overlay">
            <?php require_once navigation; ?>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row text-left">
            <h1>Onze beste producten</h1>
        </div>
        <div class="row">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
                <?php
                for ($x = 0; $x < count($items); $x++) {
                    print ' 
                        <div class="col">
                        <div class="card shadow-sm">
                            <img src="' . IMG_Category . $items[$x]->afbeelding . '" />
                            <div class="card-body">
                                <p class="card-text">' . $items[$x]->naam . '</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="verhuur/' . $items[$x]->alias . '/">Bekijk</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
                }
                ?>
            </div>
        </div>
    </div>

    <?php require_once footer; ?>
    <?php require_once scripts; ?>
</body>

</html>
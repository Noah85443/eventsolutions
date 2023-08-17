<?php
require_once './core/system.init.php';

if (!empty($_GET['groep'])) {
    $alias = $_GET['groep'];
    $pageType = 'groep';
    $path = '/verhuur/' . $_GET['artikelgroep'] . '/' . $_GET['subgroep'] . '/' . $_GET['groep'];
} elseif (!empty($_GET['subgroep'])) {
    $alias = $_GET['subgroep'];
    $pageType = 'subGroep';
    $path = '/verhuur/' . $_GET['artikelgroep'] . '/' . $_GET['subgroep'] . '/';
} else {
    $alias = $_GET['artikelgroep'];
    $pageType = 'artikelGroep';
    $path = '/verhuur/' . $_GET['artikelgroep'] . '/';
}

$artikelGroep = api::Call("artikelgroep", $alias);
$subgroepen = api::Call("artikelgroepen/subgroepen", $alias);
$artikelen = api::Call("artikelgroepen/artikelen", $artikelGroep->id);
?>

<!doctype html>
<html lang="en">
<?php require_once header; ?>

<body>
    <?php require_once navigation; ?>
    <div class="container">
        <div class="row text-center">
            <h3>
                <?php print $artikelGroep->naam; ?>
            </h3>
            <p><img src="<?php print logo; ?>" ?>
        </div>
        <div class="row">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
                <?php
                if (!isset($subgroepen->message)) {
                    for ($x = 0; $x < count($subgroepen); $x++) {
                        print ' 
                        <div class="col d-flex align-items-stretch">
                        <div class="card shadow-sm">
                            <img src="' . IMG_Category . $subgroepen[$x]->afbeelding . '" />
                            <div class="card-body">
                                <p class="card-text">' . $subgroepen[$x]->naam . '</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="' . $path . $subgroepen[$x]->alias . '/">Bekijk</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
                    }
                }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
                <?php
                if (!isset($artikelen->message)) {
                    for ($x = 0; $x < count($artikelen); $x++) {
                        print ' 
                        <div class="col d-flex align-items-stretch">
                        <div class="card shadow-sm">
                            <img src="' . IMG_Article . $artikelen[$x]->afbeelding . '" />
                            <div class="card-body">
                                <p class="card-text">' . $artikelen[$x]->artikelnaam . '</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="/verhuur/artikel/' . $artikelen[$x]->alias . '">Bekijk</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <?php require_once footer; ?>
    <?php require_once scripts; ?>
</body>

</html>
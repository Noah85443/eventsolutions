<?php
require_once './core/system.init.php';

$zoekterm = filter_input(INPUT_GET, "s", FILTER_SANITIZE_URL);
if (!empty($zoekterm)) {
    $artikelen = api::Call("artikelen/zoeken", $zoekterm);
} else {
    $errorMsg = "Geen zoekterm gevonden probeer het opnieuw";
}
?>

<!doctype html>
<html lang="en">
<?php require_once header; ?>

<body>
    <?php require_once navigation; ?>
    <?php print $zoekterm ?>
    <div class="container">
        <div class="row text-center">
            <?php
            if (!empty($errorMsg)) {
                print $errorMsg;
                exit;
            }

            ?>
            <h3>Zoekresultaten voor
                <?php print $zoekterm; ?>
            </h3>
        </div>
        <div class="row">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
                <?php
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
                ?>
            </div>
        </div>
    </div>
    <?php require_once footer; ?>
    <?php require_once scripts; ?>
</body>

</html>
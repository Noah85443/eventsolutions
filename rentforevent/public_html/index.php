<?php
require_once './core/system.init.php';

$items = api::Call("artikelgroepen/voorpagina");
?>

<!doctype html>
<html lang="en">
<?php require_once header; ?>

<body style="margin: 0; overflow-x: hidden;">
    <div class="bg-image" style="background-image: url('https://www.rentforevents.nl/images/background.png');
        background-size: contain;
        background-repeat: no-repeat;
        background-position: top center;
        height: 100vh;
        width: 100vw;">
        <?php require_once navigation; ?>
    </div>
    <?php require_once footer; ?>
    <?php require_once scripts; ?>
</body>

</html>
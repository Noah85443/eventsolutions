<?php
require_once './core/system.init.php';

$items = api::Call("artikelgroepen/voorpagina");
?>

<!doctype html>
<html lang="en">
<?php require_once header; ?>

<body>
    <?php require_once navigation; ?>
    <?php require_once footer; ?>
    <?php require_once scripts; ?>
</body>

</html>
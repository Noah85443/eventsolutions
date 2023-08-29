<?php
if (isset($_SESSION['cart'])) {
    if (count($_SESSION['cart']) == 0) {
        $cart = 0;
    } else {
        $cart = count($_SESSION['cart']);
    }
} else {
    $cart = 0;
}

$artikelgroepen = api::Call("artikelgroepen");
?>

<!-- <style>
    .navbar-nav .nav-link {
        color: white;
    }

    /* Lichtgrijze tekst voor de navbar-items bij hover */
    .navbar-nav .nav-link:hover {
        color: lightgray;
    } -->
</style>

<nav class="navbar navbar-expand-lg">
    <div class="container">

        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand" href="index.php">
            <img src="https://www.rentforevents.nl/images/logo.png" alt="..." height="36">
        </a>
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">

            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Sluiten"></button>
            </div>

            <div class="offcanvas-body">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown d-none d-lg-block">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ons assortiment
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php
                            for ($x = 0; $x < count($artikelgroepen); $x++) {
                                if ($artikelgroepen[$x]->toplevel == 0) {
                                    echo '<a href="/verhuur/' . $artikelgroepen[$x]->alias . '" class="nav-link text-bg px-3">' . $artikelgroepen[$x]->naam . '</a>';
                                }
                            }
                            ?>
                    </li>
                    <li class="nav-item d-block d-lg-none">
                        <a class="nav-link" href="assortiment.php">Assortiment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="inspiratie.php">Inspiratie </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="over-ons.php">Over ons</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                </ul>
            </div>
        </div>

        <form class="form-inline my-2 my-lg-0" role="search" method="get" action="/verhuur/zoeken/">
            <input type="search" class="form-control" placeholder="Zoeken in artikelen" aria-label="Search" name="">
        </form>

        <a class="btn btn-success mx-2" href='/offerte'>
            <i class="bi bi-cart"></i>
            <?php if ($cart > 0) {
                print $cart;
            } ?>
        </a>

    </div>
</nav>

<!-- <div class="sticky-top mb-5" style="background:#FFF;">
    <header class="py-3 mb-1 mt-2" style="background:#FFF;">
        <div class="container flex-wrap d-flex justify-content-center">
            <a href="/" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto text-dark text-decoration-none">
                <img src="" width="250px;" />
            </a>
            <form class="col-12 col-lg-auto mb-3 mb-lg-0" role="search" method="get" action="/verhuur/zoeken/">
                <input type="search" class="form-control" placeholder="Zoeken in artikelen" aria-label="Search" name="s">
            </form>
        </div>
    </header>
    <nav class="navbar navbar-expand-lg" style="background:#6FAD47;">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav  flex-grow-1 pe-3">
                    <?php
                    for ($x = 0; $x < count($artikelgroepen); $x++) {
                        if ($artikelgroepen[$x]->toplevel == 0) {
                            print '<li class="nav-item"';
                            if ($artikelgroepen[$x]->alias == $artikelgroep) {
                                print ' class="active"';
                            }
                            print '><a href="/verhuur/' . $artikelgroepen[$x]->alias . '" class="nav-link text-bg px-3">' . $artikelgroepen[$x]->naam . '</a></li>';
                        }
                    }
                    ?>
                    </ul>
                </div>
            </div>
            <a class="btn btn-warning" href='/offerte'>Mijn Offerte (<?php print $cart; ?>)</a>
        </div>
    </nav>
</div> -->
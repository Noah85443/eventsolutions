<?php 
if(isset($_SESSION['cart'])) {
	if(count($_SESSION['cart']) == 0) {$cart = 0;}
	else {$cart = count($_SESSION['cart']);}
}
else {
	$cart = 0;
}

$artikelgroepen = API::Call("artikelgroepen");
$artikelgroep = filter_input(INPUT_GET,"artikelgroep",FILTER_NULL_ON_FAILURE);
?>

<div class="sticky-top mb-5" style="background:#FFF;">
    <header class="py-3 mb-1 mt-2" style="background:#FFF;">
        <div class="container flex-wrap d-flex justify-content-center">
            <a href="/" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto text-dark text-decoration-none">
                <img src="<?php print logo; ?>" width="250px;" />
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
                            for($x=0;$x<count($artikelgroepen);$x++) {
                                if($artikelgroepen[$x]->toplevel == 0) {
                                    print '<li class="nav-item"'; 
                                    if($artikelgroepen[$x]->alias == $artikelgroep) {print ' class="active"';}
                                    print '><a href="/verhuur/'.$artikelgroepen[$x]->alias.'" class="nav-link text-bg px-3">'.$artikelgroepen[$x]->naam.'</a></li>';
                                }
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <a class="btn btn-warning" href='/offerte'>Mijn Offerte (<?php print $cart; ?>)</a>
        </div>
    </nav>
</div>
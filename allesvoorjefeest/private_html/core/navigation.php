<?php 
if(isset($_SESSION['cart'])) {
    if(count($_SESSION['cart']) == 0) {$cart = 0;}
    else {$cart = count($_SESSION['cart']);}
}
else {
    $cart = 0;
}
?>
<div class="navbar-fixed">
            <nav class="green accent-4" role="navigation">
                <div class="container">
                    <a id="logo-container" href="/" class="brand-logo"><img src="/img/logo.png" height="125px" /></a>
                    <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                    <a href="/winkelwagen" class="sidenav-trigger right cyan accent-4">
                        <i class="material-icons">shopping_basket</i>
                         <?php if($cart > 0) {print "&nbsp;<span class=\"new badge orange darken-4 white-text\" data-badge-caption=\"item(s)\" id=\"cartCount\">{$cart}</span>";} ?>
                    </a>
                    
                    <ul class="right hide-on-med-and-down">
                        <li><a href="/verhuur">Assortiment</a></li>
                        <!-- <li><a href="/partyplanners">Volledig ontzorgd</a></li> -->
                        <li><a href="/contact">Contact</a></li>
                        <li class="cyan accent-4">
                            <a href="/winkelwagen">Mijn aanvraag
                                <?php if($cart > 0) {print "&nbsp;<span class=\"new badge orange darken-4 white-text\" data-badge-caption=\"item(s)\" id=\"cartCount\">{$cart}</span>";} ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <ul id="nav-mobile" class="sidenav">
            <li><a href="/verhuur">Assortiment</a></li>
            <!-- <li><a href="/partyplanners">Volledig ontzorgd</a></li> -->
            <li><a href="/contact">Contact</a></li>
        </ul>
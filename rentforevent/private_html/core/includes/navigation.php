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

<style>
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {
  overflow: hidden;
}

.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #999999;
  color: black;
}

.profile-image{
    height:auto;
    width:auto;
    float: left;
    padding-left: 2%;
    margin: 0 auto; 
    padding: 10px 0;
} 

.profile-image img{
    object-fit:cover;
}


</style>
<div class=
<a> <img src="core/images/logo.png" height="40" width="250" alt="Image resize"> </a>
<div class="topnav">
    <a class="btn btn-warning" href='/offerte'>Mijn Offerte (<?php print $cart; ?>)</a>
</div>

<!-- <?php
    for($x=0;$x<count($artikelgroepen);$x++) {
        if($artikelgroepen[$x]->toplevel == 0) {
            print '<li class="nav-item"'; 
            if($artikelgroepen[$x]->alias == $artikelgroep) {print ' class="active"';}
            print '><a href="/verhuur/'.$artikelgroepen[$x]->alias.'" class="nav-link text-bg px-3">'.$artikelgroepen[$x]->naam.'</a></li>';
        }
    }
?> -->
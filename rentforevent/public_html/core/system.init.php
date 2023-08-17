<?php
header('Access-Control-Allow-Origin: *');

define('header', 'core/includes/header.php');
define('navigation', 'core/includes/navigation.php');
define('footer', 'core/includes/footer.php');
define('scripts', 'core/scripts/external.php');

define('logo', 'images/logo.png');

define('IMG_Category', 'https://eventsolutions.nu/images/rentalProducten/groupImg/');
define('IMG_Article', 'https://eventsolutions.nu/images/rentalProducten/');

setlocale(LC_MONETARY, 'nl_NL.UTF-8');
setlocale(LC_TIME, 'NL_nl');
setlocale(LC_ALL, 'nl_NL');
setlocale(LC_ALL, 'nld_NLD');
setlocale(LC_ALL, 'nl_NL.ISO8859-1');
setlocale(LC_NUMERIC, 'en_US.UTF-8');

session_start();

spl_autoload_register(function ($class) {
    require 'classes/' . $class . '.php';
});

$shopData = array(
    'huurFactor' => '0.2'
);



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
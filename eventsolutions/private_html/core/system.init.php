<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods:GET');
header('Access-Control-Allow-Headers:*');

// EXPANDER FOR REWRITE HOST FOR DEV
$host = $_SERVER['HTTP_HOST'];
preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);

define('SERVER','/home/u10448d24532/domains/');

if($matches[0] === "eventsolutionsdev.online") {
    define('HOST','eventsolutionsdev.online');
    $mode = "dev";
}
elseif($matches[0] === "eventsolutions.nu") {
   define('HOST','eventsolutions.nu'); 
   $mode = "live";
}
else {
    die('Invalid HOST access token');
}

if ($mode === "dev") {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

ini_set('session.cookie_domain', '.'.HOST);

setlocale(LC_MONETARY, 'nl_NL.UTF-8');
setlocale(LC_TIME, 'NL_nl');
setlocale(LC_ALL, 'nl_NL');
setlocale(LC_ALL, 'nld_NLD');
setlocale(LC_ALL, 'nl_NL.ISO8859-1');
setlocale(LC_NUMERIC, 'en_US.UTF-8');

session_start();

define('LINK_LOGIN','https://accounts.'.HOST.'/');
define('BASE_ACCOUNTS','https://accounts.'.HOST);
define('BASE_OFFICE','https://office.'.HOST);
define('BASE_RELATIES','https://relaties.'.HOST);
define('BASE_CREW','https://crew.'.HOST);

define('ROOT_ACCOUNTS',SERVER.HOST.'/public_html/accounts');
define('ACCOUNTS','classes/account.class.php');
define('ACCOUNT_CHECK','/account.check.php');

define('FRAMEWORK',SERVER.HOST.'/public_html/core/header.php');
define('FOOTER',SERVER.HOST.'/public_html/core/footer.php');

define('STYLE_CSS','https://'.HOST.'/css');
define('STYLE_CSS_BOOTSTRAP', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css');
define('STYLE_JS','https://'.HOST.'/js');
define('STYLE_IMAGES','https://'.HOST.'/images');

define('DOCS_DOWNLOAD','https://'.HOST.'/docs');

require_once 'db.connect.php';

define('COMPOSER_VENDOR',SERVER.HOST.'/public_html/vendor/autoload.php');
require_once COMPOSER_VENDOR;

spl_autoload_register(function($class) {
    require SERVER.HOST.'/public_html/core/classes/class.'.$class.'.php';
});

$accessLevel = '';
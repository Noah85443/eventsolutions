<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
include_once '../core/database.php';
include_once '../core/tokenAuth.php';
include_once '../objects/product.php';

checkBearerToken();
  
$database = new Database();
$db = $database->getConnection();
  
$product = new Product($db);
$product->id = isset($_GET['id']) ? $_GET['id'] : die();
  
$product->readOne();
  
if($product->artikelnaam!=null) {
    $product_arr = array(
            "id" => $product->id,
            "artikelnaam" => $product->artikelnaam,
            "artikelnummer" => $product->artikelnr,
            "artikelsoort" => $product->artikelsoort,
            "stuksPerEenheid" => $product->stuksPerEenheid,
            "prijs" => $product->prijs,
            "btwTarief" => $product->btwTarief,
            "inhuurartikel" => $product->inhuurartikel,
            "afbeelding" => $product->afbeelding,
            "alias" => $product->alias,
            "samengesteld" => $product->samengesteld,
            "onderdelen" => $product->onderdelen,
            "kenmerken" => $product->kenmerken,
            "beschrijving" => $product->beschrijving
    );
  
    http_response_code(200);
    echo json_encode($product_arr);
}
  
else {
    http_response_code(404);
    echo json_encode(array("message" => "Product niet gevonden."));
}
?>
<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../core/database.php';
include_once '../core/tokenAuth.php';
include_once '../objects/product.php';

checkBearerToken();
  
$database = new Database();
$db = $database->getConnection();
  
$product = new Product($db);
  
$stmt = $product->read();
$num = $stmt->rowCount();
  
if($num>0){
    $products_arr=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
  
        $product_item=array(
            "id" => $id,
            "artikelnaam" => $artikelnaam,
            "artikelsoort" => $artikelsoort,
            "stuksPerEenheid" => $stuksPerEenheid,
            "prijs" => $prijs,
            "btwTarief" => $btwTarief,
            "inhuurartikel" => $inhuurartikel
        );
  
        array_push($products_arr, $product_item);
    }
  
    http_response_code(200);
    echo json_encode($products_arr, true);
}
  
else {
    http_response_code(404);

    echo json_encode(
        array("message" => "Geen producten gevonden.")
    );
}
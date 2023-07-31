<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../core/database.php';
include_once '../core/tokenAuth.php';
include_once '../objects/product.php';
include_once '../objects/category.php';

checkBearerToken();
  
$database = new Database();
$db = $database->getConnection();
  
$groupId = new Category($db);
$groupId->id = isset($_GET['id']) ? $_GET['id'] : die();
$groupId->readOne();

$product = new Product($db);
$product->artikelgroep = $groupId->id;  
$stmt = $product->readFromCategory();
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
            "inhuurartikel" => $inhuurartikel,
            "afbeelding" => $afbeelding,
            "alias" => $alias
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
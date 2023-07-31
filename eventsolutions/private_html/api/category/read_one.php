<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
include_once '../core/database.php';
include_once '../core/tokenAuth.php';
include_once '../objects/category.php';

checkBearerToken();
  
$database = new Database();
$db = $database->getConnection();
  
$category = new Category($db);
if(isset($_GET['id'])) {
    if(is_numeric($_GET['id'])) {
        $category->id = isset($_GET['id']) ? $_GET['id'] : die();
    }
    else {
       $category->alias = isset($_GET['id']) ? $_GET['id'] : die(); 
    }
}

$category->readOne();
  
if($category->naam!=null) {
    $product_arr = array(
            "id" => $category->id,
            "naam" => $category->naam,
            "toplevel" => $category->toplevel,
            "alias" => $category->alias,
            "afbeelding" => $category->afbeelding,
            "opVoorpagina" => $category->opVoorpagina,
            "beschrijving" => $category->beschrijving
    );
  
    http_response_code(200);
    echo json_encode($product_arr);
}
  
else {
    http_response_code(404);
    echo json_encode(array("message" => "Categorie niet gevonden 2."));
}
?>
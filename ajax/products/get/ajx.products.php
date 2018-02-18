<?php
$docroot = $_SERVER["DOCUMENT_ROOT"];
include("$docroot/autoloader.php");

if( $_SERVER["REQUEST_METHOD"] == "POST"){
  $response = array();
  $errors = array();
  
  $products_class = new products\Products();
  $products = $products_class -> getProducts();
  if( count($products) > 0){
    $response = $products;
    $response["success"] = true;
    // $response["data"] = $products;
  }
  else{
    $response["success"] = false;
  }
  echo json_encode($response);
}
?>
<?php
$docroot = $_SERVER["DOCUMENT_ROOT"];
include("$docroot/autoloader.php");

if( $_SERVER["REQUEST_METHOD"] == "POST" ){
  $response = array();
  $id = $_POST["id"];
  $products_class = new \products\Products();
  $product = $products_class -> getProductById( $id );
  if( count($product) > 0){
    $response["success"] = true;
    $response["data"] = $product;
  }
  else{
    $response["success"] = false;
  }
  echo json_encode($response);
}
?>
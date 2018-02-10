<?php
$docroot = $_SERVER["DOCUMENT_ROOT"];
include("$docroot/autoloader.php");

if( $_SERVER["REQUEST_METHOD"] == "POST"){
  $response = array();
  $categories = new categories\Categories();
  $response["data"] = $categories -> getCategories(false);
  $response["success"] = true;
  echo json_encode($response);
}

?>

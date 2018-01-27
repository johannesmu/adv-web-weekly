<?php
include('ajaxautoloader.php');

if( $_SERVER["REQUEST_METHOD"] == "GET" && count( $_GET ) > 0){
  $response = array();
  $categories = new Categories();
  $response["data"] = $categories -> getCategoriesArray();
  $response["success"] = true;
  echo json_encode($response);
}
?>

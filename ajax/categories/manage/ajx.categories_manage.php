<?php
$path = $_SERVER["DOCUMENT_ROOT"].'/ajax/ajaxautoloader.php';
include($path);
if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
  $response = array();
  
  $id = $_POST["id"];
  $name = $_POST["name"];
  $active = $_POST["active"];
  
  $categories = new Categories();
  $update = $categories -> updateCategory($id,$name,$active);
  if( $update == true ){
    $response["success"] = true;
  }
  else{
    $response["success"] = false;
  }
  echo json_encode($response);
}
?>
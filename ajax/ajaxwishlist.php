<?php
session_start();
include( "autoloader.php" );
if( $_SERVER["REQUEST_METHOD"] == "POST" ){
  //get the post variables from the request
  //check wishlist.js for the variables
  $account_id = $_POST["account_id"];
  $product_id = $_POST["product_id"];
  $cmd = $_POST["action"];
  
  //create an array for the response
  $response = array();
  
  //create an instance of the wishlist class
  $wishlist = new WishList( $account_id );
  
  //handle different actions
  //send response back
}
?>
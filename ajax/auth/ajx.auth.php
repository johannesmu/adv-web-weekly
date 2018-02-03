<?php
session_start();
$path = $_SERVER["DOCUMENT_ROOT"].'/ajax/ajaxautoloader.php';
include($path);
include("../includes/database.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $userid = $_POST["userid"];
  $password = $_POST["password"];
  //create an array to return as response
  $response = array();
  
  $query = "SELECT account_id, username, email, password FROM accounts WHERE username=? OR email=?";
  $statement = $connection -> prepare($query);
  $statement -> bind_param("ss",$userid,$userid);
  if( $statement -> execute() ){
    $result = $statement -> get_result();
    //check if a result is returned (number of rows)
    if( $result -> num_rows > 0 ){
      //the user exists
      //convert result to an associative array
      $user = $result -> fetch_assoc();
      $account_id = $user["account_id"];
      $username = $user["username"];
      $email = $user["email"];
      $hash = $user["password"];
      //check if password matches --> password_verify()
      if( password_verify($password,$hash) ){
        //password is correct
        //log user in
        //create user session variables
        $_SESSION["account_id"] = $account_id;
        $_SESSION["username"] = $username;
        //echo "password is correct";
        $response["success"] = true;
        $response["account_id"] = $account_id;
        $response["username"] = $username;
      }
      else{
        // password is incorrect
        //echo "password is incorrect";
        $response["success"] = false;
        $response["error"] = "incorrect credentials supplied";
      }
      
    }
    else{
      //account does not exist
      $response["success"] = false;
      $response["error"] = "account does not exist";
    }
  }
  echo json_encode($response);
}
?>
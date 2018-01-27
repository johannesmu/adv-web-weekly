<?php
class Account_Authenticate extends Database{
  private $connection;
  private $credential;
  private $password;
  private $account;
  private $errors;
  public function __construct( $credential, $password ){
    parent::__construct();
    $this -> credential = $credential;
    $this -> password = $password;
    $this -> authenticateUser();
  }
  private function authenticateUser(){
    $query = "SELECT id,username,email,password FROM accounts WHERE email=? OR username=?";
    $statement = $this -> connection -> prepare( $query );
    $statement -> bind_param("s", $this -> credential );
    if( $statement -> execute() == false ){
      //database error
      return false;
    }
    $result = $statement -> get_result();
    if( $result -> num_rows == 0 ){
      //no account found
      return false;
    }
    $this -> account = $result -> fetch_assoc();
    if( $this -> checkPassword() == false ){
      //password error
      return false;
    }
    else{
      return true;
    }
  }
  private function checkPassword(){
    $hash = $this -> account["password"];
    if( password_verify( $hash , $this->password) ){
      return true;
    }
    else{
      return false;
    }
  }
}
?>
<?php
class Account extends Database{
  public $account_id;
  private $errors;
  public function __construct( ){
    //credential can be in the form of email or username
    parent::__construct();
  }
  public function authenticate( $credential, $password ){
    $query = "SELECT id,username,email,password FROM accounts WHERE email=? OR username=?";
    $statement = $this -> connection -> prepare( $query );
    $statement -> bind_param("s", $this -> credential );
    if( $statement -> execute() == false ){
      //database error
      error_log(0,"database error");
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
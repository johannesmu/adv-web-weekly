<?php
class AuthToken extends Account{
  private $token;
  public function __construct(){
    $account = parent::__construct();
  }
  private function generateToken($user_id,$claim){
    //we generate an authentication token
    $payload_array = array();
    //id of the token
    $generator = new Token( 16 );
    $token_id = $generator -> getToken();
    $payload_array["id"] = $token_id;
    
    //created date
    $date = new DateTime();
    $timestamp = $date -> getTimestamp();
    $payload_array["created"] = $timestamp;
    
    //expiry date
    $expiry = $timestamp + $expires;
    $payload_array["expiry"] = $expiry;
    
    //set claim according to user's status
    //---if user is logged in and is admin
    if( $_SESSION["admin"] && $_SESSION["id"]){
      
    }
    $payload = base64_encode(json_encode($payload_array));
    $signature = md5($payload);
    $token = $payload . "." . $signature;
    return $token;
  }
}
?>
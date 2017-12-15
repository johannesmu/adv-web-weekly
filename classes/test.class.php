<?php
class Test{
  public $greeting;
  private $secret = "my secret";
  protected $shared = "let's share this";
  
  public function __construct(){
    $this -> greeting = "Hello World";
  }
  public function getGreeting(){
    return $this -> greeting;
  }
  public function setGreeting( $new_greeting ){
    $this -> greeting = $new_greeting;
    $this -> getGreeting();
  }
}
?>
<?php
class Database{
  protected $connection;
  protected function __construct(){
    //get environment variables
    $host = getenv("host");
    $user = getenv("username");
    $password = getenv("password");
    $database = getenv("database");
    //create a connection
    $this -> connection = mysqli_connect($host,$user,$password,$database);
  }
  protected function getConnection(){
    return $this -> connection;
  }
}
?>
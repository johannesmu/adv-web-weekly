<?php
class Navigation{
  private $logged_in;
  private $current_page;
  
  public function __construct(){
    //check session to see if user is logged in
    if( isset($_SESSION["account_id"]) ){
      $this -> logged_in = true;
    }
    else{
      $this -> logged_in = false;
    }
    //get the name of the current page
    $this -> current_page = basename( $_SERVER["PHP_SELF"] );
    echo $this -> current_page;
  }
  
  public function getNavigation(){
    $nav_array = array();
    if($this -> logged_in == false){
      $nav_items = array(
        "home" => "index.php", 
        "register" => "register.php",
        "login" => "login.php",
        "news" => "news.php"
      );
    }
    else{
      $nav_items = array(
        "home" => "index.php", 
        "logout" => "logout.php",
        "news" => "news.php"
      );
    }
    
    //add the ul element to nav_array
    array_push($nav_array, "<ul class=\"nav navbar-nav navbar-right\">");
    foreach($nav_items as $name => $link){
      if( $link == $this -> current_page ){
        $class = "class=\"active\"";
      }
      else{
        $class = "";
      }
      $link_name = ucfirst( $name );
      $element = "<li $class><a href=\"/$link\">$link_name</a></li>";
      array_push( $nav_array , $element );
    }
    //add </ul> at the end of array
    array_push( $nav_array , "</ul>");
    return implode( $nav_array, "");
  }
}
?>
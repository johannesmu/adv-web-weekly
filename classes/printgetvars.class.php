<?php
class PrintGetVars{
  private $vars = array();
  public function __construct(){
    $get_array = $_GET;
    if(count($get_array) > 0){
      foreach($get_array as $name => $value){
        //render each get variable as _get_varname
        $var = "var "."_get_". $name." = " . "\"$value\" ;";
        array_push( $this -> vars , $var );
      }
    }
  }
  
  public function __toString(){
    $str = implode( "\n" , $this -> vars );
    return trim($str);
  }
}
?>
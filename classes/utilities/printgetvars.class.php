<?php
namespace utilities;

class PrintGetVars{
  private $vars = array();
  public function __construct(){
    $get_array = $_GET;
    if(count($get_array) > 0){
      foreach($get_array as $name => $value){
        //render each get variable as _get_varname
        //if the variable has an array as a value
        if( gettype( $get_array[$name] ) == "array" ){
          $array_string = implode(",",$get_array[$name] );
          $var = "var_get_" . $name . " = " ."[ $array_string ]";
        }
        else{
          $var = "var "."_get_". $name." = " . "\"$value\" ;";
        }
        
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
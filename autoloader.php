<?php
function auto_load_class($classname){
  //----use the class name to find the class file
  //convert the classname to lowercase
  $filename = strtolower($classname);
  
  //define path to the classes directory
  $classes_dir = $_SERVER["DOCUMENT_ROOT"] . "/classes/";
  
  //create a path to the class
  $class_file = $classes_dir . str_replace( '\\', '/', $filename ) . ".class.php";
  if( is_readable($class_file) ){
    require_once($class_file);
    //echo "included $class_file<br> ";
  }
  else{
    error_log("class file for $classname does not exist or is unreadable", 0);
    //echo "not included $class_file<br>";
  }
}
spl_autoload_register("auto_load_class");
?>
<?php
function auto_load_class($classname){
  //----use the class name to find the class file
  //convert the classname to lowercase
  $filename = strtolower($classname).".class.php";
  
  $classes_dir = "classes";
  //for when the autoloader is used in a sub directory
  $alt_classes_dir = "../classes";
  
  $class_file = $classes_dir . "/" . $filename;
  $alt_class_file = $alt_classes_dir . "/" . $filename;
  
  if( is_readable($class_file) ){
    include_once($class_file);
  }
  elseif( is_readable($alt_class_file) ){
    include_once($alt_class_file);
  }
  else{
    error_log("class file for $classname does not exist or is unreadable", 0);
  }
}
spl_autoload_register("auto_load_class");
?>
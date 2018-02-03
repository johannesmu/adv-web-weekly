<?php
class Upload extends Database{
  private $inputname;
  public function __construct($inputname){
    parent::__construct();
    if( count($_FILES[$inputname]) > 0){
      $filecount = count( $_FILES[$inputname] );
      //handle the files here
    }
  }
  
}
?>
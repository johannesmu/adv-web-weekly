<?php
namespace utilities;

class TruncateWords{
  private $length;
  private $words_array;
  public $words;
  public function __construct($str,$limit = 10){
    $this -> words_array = explode(" ", $str);
    for($i=0; $i<$limit; $i++){
      if($this -> words_array[$i]!=="." && $words_array[$i]!==" " && $words_array[$i]!=="&nbsp;"){
        $this -> words = $this -> words . " " .trim($this -> words_array[$i]);
      }
    }
  }
  public function __toString(){
    return $this -> words;
  }
}
?>
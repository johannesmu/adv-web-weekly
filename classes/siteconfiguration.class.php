<?php
class SiteConfiguration{
  public $site_config;
  public function __construct(  ){
    $config_dir = "config";
    if( is_readable( $config_dir ) == false ){
      $config_dir = "../config";
    }
    $config_json = "$config_dir/siteconfig.json";
    
    if ( is_readable( $config_json ) ){
      //read the json file 
      $file_data = file_get_contents( $config_json );
      //and convert to array
      $this -> site_config = json_decode( $file_data, true);
      //return the array
      //return $this -> site_config;
      $this -> getConfig();
    }
    else{
      error_log("configuration file not found",0);
      return false;
    }
  }
  private function getConfig(){
    return $this -> site_config;
  }
}
?>
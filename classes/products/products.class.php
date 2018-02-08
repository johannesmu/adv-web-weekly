<?php
//namespace shop\products;
namespace products;

class Products extends \data\Database {
  //set category as an array
  private $categories = array();
  private $page = 1;
  private $perpage = 8;
  public $page_total;
  
  public function __construct(){
    //call the parent's construct method
    //the $connection of the Database class is now part of this class
    //can be called as $this -> connection
    parent::__construct();
    print_r($_GET["category"]);
    echo "<br>";
    echo count( $_GET["category"] );
    //check if there are $_GET variables 
    if( count($_GET) > 0 ){
      //check categories
      if( count($_GET["category"]) > 0){
        $this -> categories = array();
        foreach( $_GET["category"] as $cat ){
          array_push( $this -> categories, $cat );
        }
      }
      //check page variable
      if( isset($_GET["page"]) ){
        $this -> page = $_GET["page"];
      }
      //check perpage (results per page)
      if( isset($_GET["perpage"]) ){
        $this -> perpage = $_GET["perpage"];
      }
      
    }
  }
  public function getProducts(){
    //set the base query
    $query = "SELECT 
            products.id,
            products.name,
            products.description,
            products.price,
            images.image_file_name
            FROM products
            INNER JOIN products_images
            ON products.id = products_images.product_id
            INNER JOIN images
            ON products_images.image_id = images.image_id";
            //WHERE products.active = 1";
            // GROUP BY products.id 
            // LIMIT ? OFFSET ?";
    //-----construct query according to parameters supplied
    $query_param_string = array();
    $query_param_values = array();
    if( count( $this -> categories ) > 0 ){
      $tbl_products_categories = "products_categories";
      //add join with products_categories table
      $query = $query . " INNER JOIN $tbl_products_categories ON products.id = $tbl_products_categories.product_id ";
      $cat_query = array();
      foreach( $this -> categories as $cat ){
        //ignore if category = 0
        if( $cat !== 0 ){
          array_push( $cat_query, "$tbl_products_categories.category_id=?");
          array_push( $query_param_string, "i" );
          array_push( $query_param_values, $cat );
        }
      }
      //implode the categories into a string
      $cat_query_string = implode( " OR ", $cat_query );
      //add to the main query
      $query = $query . " WHERE products.active=1 AND " . $cat_query_string;
    }
    echo $query;
    //process page variables
    $statement = $this -> connection ->  prepare( $query );
    //get current page
    
    
    
    $statement -> bind_param( "ii" , $this -> perpage, $this -> page );
    if( $statement -> execute() ){
      $result = $statement -> get_result();
      //check number of rows in result
      if( $result -> num_rows > 0){
        //get total number of rows
        //SQL_CALC_FOUND_ROWS and FOUND_ROWS()
        $products = array();
        while( $row = $result -> fetch_assoc() ){
          array_push( $products, $row );
        }
        return $products;
      }
      else{
        return false;
      }
    }
    else {
      return false;
    }
    $statement -> close();
  }
  public function getProductsInCategory (){
    $category_id = $this -> category;
    $query = "SELECT 
              products.id,
              products.name,
              products.description,
              products.price,
              images.image_file_name
              FROM products
              INNER JOIN products_categories
              ON products.id = products_categories.product_id
              INNER JOIN products_images
              ON products.id = products_images.product_id
              INNER JOIN images
              ON products_images.image_id = images.image_id 
              WHERE products_categories.category_id = ?
              AND products.active = 1
              GROUP BY products.id
              OFFSET ? LIMIT ? ";
    $statement = $this -> connection -> prepare( $query );
    $statement -> bind_param( "i", $category_id );
    if( $statement -> execute() == false ){
      return false;
    }
    else{
      $result = $statement -> get_result();
      if( $result -> num_rows == 0){
        //product does not exist
        return false;
      }
      else{
        return $result -> fetch_assoc();
      }
    }
  }
  public function getProductById($product_id){
    $query = "SELECT 
              products.id AS id,
              products.name AS name,
              products.description AS description,
              products.price AS price,
              images.image_file_name AS image
              FROM products 
              INNER JOIN products_images
              ON products.id = products_images.product_id
              INNER JOIN images
              ON products_images.image_id = images.image_id
              WHERE products.id=? AND images.active = 1 
              AND products.active = 1";
    $statement = $this -> connection -> prepare( $query );
    $statement -> bind_param( "i", $product_id);
    if( $statement -> execute() == false ){
      return false;
    }
    else{
      $result = $statement -> get_result();
      if( $result -> num_rows == 0){
        //product does not exist
        return false;
      }
      else{
        return $result -> fetch_assoc();
      }
    }
    $statement -> close();
  }
  public function getAllProducts(){
    $query = "SELECT 
            products.id,
            products.name,
            products.description,
            products.price,
            products.active,
            images.image_file_name
            FROM products
            INNER JOIN products_images
            ON products.id = products_images.product_id
            INNER JOIN images
            ON products_images.image_id = images.image_id
            GROUP BY products.id";
    $statement = $this -> connection ->  prepare( $query );
    if( $statement -> execute() ){
      $result = $statement -> get_result();
      //check number of rows in result
      if( $result -> num_rows > 0){
        $products = array();
        while( $row = $result -> fetch_assoc() ){
          array_push( $products, $row );
        }
        return $products;
      }
      else{
        return false;
      }
    }
  }
}
?>
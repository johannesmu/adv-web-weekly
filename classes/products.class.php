<?php
//namespace shop\products;
class Products extends Database {
  private $category = 0;
  private $page = 1;
  private $perpage = 8;
  public function __construct(){
    //call the parent's construct method
    //the $connection of the Database class is now part of this class
    //can be called as $this -> connection
    parent::__construct();
    
    //check if there are $_GET variables 
    if( count($_GET) > 0 ){
      if( isset($_GET["category"]) ){
        $this -> category = $_GET["category"];
      }
      if( isset($_GET["page"]) ){
        $this -> page = $_GET["page"];
      }
      if( isset($_GET["perpage"]) ){
        $this -> perpage = $_GET["perpage"];
      }
    }
  }
  public function getProducts(){
    //get products from database that have images and are active
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
            ON products_images.image_id = images.image_id
            WHERE products.active = 1 
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
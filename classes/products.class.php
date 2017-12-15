<?php
class Products extends Database {
  public function __construct(){
    //call the parent's construct method
    parent::__construct();
  }
  public function getProducts(){
    //get all products from database
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
            ON products_images.image_id = images.image_id GROUP BY products.id";
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
    else{
      return false;
    }
    $statement -> close();
  }
}
?>
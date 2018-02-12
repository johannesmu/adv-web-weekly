<?php
namespace products;

class Products extends \data\Database {
  //set category as an array
  public $categories = array();
  private $page = 1;
  private $perpage = 8;
  public $page_total;
  
  public function __construct(){
    //call the parent's construct method
    //the $connection of the Database class is now part of this class
    //can be called as $this -> connection
    parent::__construct();
    //check if there are $_GET variables 
    if( count($_GET) > 0 ){
      //check categories
      if( count($_GET["categories"]) > 0){
        $this -> categories = array();
        foreach( $_GET["categories"] as $cat ){
          array_push( $this -> categories, $cat );
        }
        print_r( $this -> categories );
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
    
    //create an array to pass string eg "iii" to bind_param
    $query_param_string = array();
    //create an array to pass values to the bind_param
    $query_param_values = array();
    
    //--CATEGORIES
    //if there are categories selected, create a join with products_categories table
    if( count( $this -> categories ) > 0 ){
      //store the name of the table in variable
      $tbl_products_categories = "products_categories";
      //add join with products_categories table
      $category_join = " INNER JOIN $tbl_products_categories ON products.id =  $tbl_products_categories.product_id ";
      $category_query = array();
      foreach( $this -> categories as $cat ){
        //ignore if category = 0
        if( $cat !== 0 ){
          array_push( $category_query, "$tbl_products_categories.category_id=?");
          array_push( $query_param_string, "i" );
          //we need each query param value as a reference
          array_push( $query_param_values, $cat );
        }
      }
      //implode the categories into a string so we have
      //products_categories.category_id=? OR products_categories.category_id=?
      $cat_query_string = implode( " OR ", $category_query );
    }
    
    //--PAGE
    //process page variables
    //to use pagination, we need to calculate offset
    //if we have 8 results per page, then offset is calculated using pagenumber $page -1 * perpage
    $offset = ($this -> page-1) * $this -> perpage;
    //add to query_param_string and query_param_values
    array_push( $query_param_string , "i" );
    array_push( $query_param_values , $this -> perpage );
    array_push( $query_param_string , "i" );
    array_push( $query_param_values , $offset );
    
    //add the query_param_string to the beginning of query_param_values
    array_unshift( $query_param_values, implode( "", $query_param_string ));
    
    //build the query with category parameters
    $limit = " LIMIT ? OFFSET ?";
    //add category join
    if( count( $this -> categories) > 0){
      $query = $query . " " . $category_join;
      //add category query string
      $query = $query . " WHERE " . $cat_query_string . " AND products.active=1";
    }
    //add limit
    $query = $query . " " . $limit;
    
    $statement = $this -> connection ->  prepare( $query );
    
    //pass parameters to the statement
    $parameters_array = array();
    foreach( $query_param_values as $key => $value ){
      $parameters_array[$key] = &$query_param_values[$key];
    }
    echo $query;
    call_user_func_array( array($statement,'bind_param'), $parameters_array );
    if( $statement -> execute() ){
      $result = $statement -> get_result();
      //check number of rows in result
      if( $result -> num_rows > 0){
        //get total number of rows
        //SQL_CALC_FOUND_ROWS and FOUND_ROWS()
        $products = array();
        while( $row = $result -> fetch_assoc() ){
          $id = $row["id"];
          $name = $row["name"];
          $price = $row["price"];
          $image_file_name = $row["image_file_name"];
          $desc = new \utilities\TruncateWords( $row["description"],15 );
          $description = $desc -> words;
          //$description = $row["description"];
          array_push( $products, array( 
            "id" => $id, 
            "name" => $name, 
            "price" => $price,
            "description" => $description, 
            "image_file_name" => $image_file_name 
            ) );
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
  
  //get a single product by its id
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
        //loop through result
        $product_info = array();
        while( $row = $result -> fetch_assoc() ){
          array_push( $product_info, $row );
        }
        return $product_info;
      }
    }
    $statement -> close();
  }
}
?>
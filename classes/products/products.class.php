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

    //-----construct query according to parameters supplied
    
    //create an array to pass string eg "iii" to bind_param
    $query_param_string = array();
    
    //create an array to pass values to the bind_param
    $query_param_values = array();
    
    //--TOTAL COUNT OF PRODUCTS
    //create an array to pass string eg "iii" to count total result
    $query_param_string_count = array();
    //create an array to pass values to to count total result
    $query_param_values_count = array();
    
    //--CATEGORIES
    //if there are categories selected, create a join with products_categories table
    //so we can find products in category or categories
    if( count( $this -> categories ) > 0 ){
      //store the name of the table in variable
      $tbl_products_categories = "products_categories";
      
      //string to add to query to join with products_categories table
      $category_join = " INNER JOIN $tbl_products_categories ON products.id =  $tbl_products_categories.product_id ";
      
      $category_query = array();
      foreach( $this -> categories as $cat ){
        //ignore if category = 0
        if( $cat !== 0 ){
          array_push( $category_query, "$tbl_products_categories.category_id=?");
          array_push( $query_param_string, "i" );
          array_push( $query_param_string_count, "i" );
          
          //we need each query param value as a reference
          array_push( $query_param_values, $cat );
          array_push( $query_param_values_count, $cat );
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
    
    //add offset and limit to query_param_string array and query_param_values
    array_push( $query_param_string , "i" );
    array_push( $query_param_values , $this -> perpage );
    array_push( $query_param_string , "i" );
    array_push( $query_param_values , $offset );
    
    //add the query_param_string to the beginning of query_param_values
    //so we get the "iii" at the beginning of array
    array_unshift( $query_param_values, implode( "", $query_param_string ));
    //do the same for the count arrays
    array_unshift( $query_param_values_count, implode("",$query_param_string_count) );
    
    //build the query with category parameters
    $limit = " LIMIT ? OFFSET ?";
    
    //add category join
    if( count( $this -> categories) > 0){
      $query = $query . " " . $category_join;
      //add category query string
      $query = $query . " WHERE " . $cat_query_string . " AND products.active=1";
    }
    
    //add grouping and sorting
    $query = $query . " GROUP BY products.id";
    //add sorting
    $query = $query . " ORDER BY products.id ASC";
    
    //create second query without the limit so we can get total number of products
    //without the pagination and limit (offset creates pages of result, 
    //while limit limits the number of products per page)
    $count_query = $query;
    //add limit
    $query = $query . " " . $limit;
    
    //send the query to database using prepare
    $statement = $this -> connection ->  prepare( $query );
    
    //create references to the array values using &$query_param_values
    //while adding to parameters array
    $parameters_array = array();
    foreach( $query_param_values as $key => $value ){
      $parameters_array[$key] = &$query_param_values[$key];
    }
    //do the same for count 
    $parameters_array_count = array();
    foreach( $query_param_values_count as $key => $value ){
      $parameters_array_count[$key] = &$query_param_values_count[$key];
    }
    //use call_user_func_array to pass the array as a parameter to query
    //equivalent of calling bind_param("iii",$var1,$var2,$var3)
    call_user_func_array( array($statement,'bind_param'), $parameters_array );
    
    //execute the query with the parameters
    if( $statement -> execute() ){
      $result = $statement -> get_result();
      //check number of rows in result
      if( $result -> num_rows > 0){
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
        $statement -> close();
        //run the second query $count_query to get total number of products
        $statement = $this -> connection -> prepare($count_query);
        call_user_func_array( array($statement,'bind_param'), $parameters_array_count );
        $statement -> execute();
        $result = $statement -> get_result();
        $total = $result -> num_rows;
        
        $result_array = array();
        $result_array["total"] = $total;
        $result_array["categories"] = $this -> categories;
        $result_array["data"] = $products;
        
        return $result_array;
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
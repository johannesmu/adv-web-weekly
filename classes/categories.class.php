<?php
class Categories extends Database{
  private $categories;
  private $selected;
  private $query = "SELECT 
    categories.category_id AS id,
    categories.name AS name,
    COUNT(products_categories.category_id) AS cat_count
    FROM products_categories 
    INNER JOIN categories
    ON products_categories.category_id = categories.category_id
    WHERE categories.active=1 GROUP BY products_categories.category_id";
  public function __construct() {
    parent::__construct();
    
    if($_GET["category"]){
      $this -> selected = $_GET["category"];
    }
    else{
      $this -> selected = 0;
    }
    
    $this -> getCategories();
  }
  
  private function getCategories(){
    $statement = $this -> connection -> prepare( $this -> query );
    $statement -> execute();
    $result = $statement -> get_result();
    if( $result -> num_rows > 0){
      $this -> categories = array();
      while( $category = $result -> fetch_assoc() ){
        //inject class into the category object
        if( $category["id"] == $this -> selected ){
          $category["class"] = "active";
        }
        array_push( $this -> categories,$category );
      }
    }
    $statement -> close();
  }
  public function getCategoriesArray() {
    return $this -> categories;
  }
  public function getCategoriesHTML( array $classes ){
    $list_element = array();
    if( count( $this -> categories ) > 0 ){
      $class_names = implode(" ", $classes );
      $ul = "<ul class=\"\"></ul>";
    }
  }
  public function getCategoriesJSON(){
    
  }
  public function __toString(){
    
  }
  public function getAllCategories(){
    $query = "SELECT categories.category_id AS id, 
    categories.name AS name, 
    categories.active AS active, 
    COUNT( products_categories.category_id ) AS count
    FROM categories
    LEFT JOIN products_categories 
    ON categories.category_id = products_categories.category_id
    GROUP BY categories.category_id";
    $statement = $this -> connection -> prepare( $query );
    $statement -> execute();
    $result = $statement -> get_result();
    if( $result -> num_rows > 0){
      $this -> categories = array();
      while( $category = $result -> fetch_assoc() ){
        //inject class into the category object
        if( $category["id"] == $this -> selected ){
          $category["class"] = "active";
        }
        array_push( $this -> categories,$category );
      }
      return $this -> categories;
    }
    $statement -> close();
  }
  
  public function updateCategory( $category_id,$name,$active ){
    $query = "UPDATE categories SET name=?,active=? WHERE category_id=?";
    $statement = $this -> connection -> prepare( $query );
    $statement -> bind_param('sii', $name, $active, $category_id );
    if( $statement -> execute() ){
      return true;
    }
    else{
      return false;
    }
    $statement -> close();
  }
}
?>
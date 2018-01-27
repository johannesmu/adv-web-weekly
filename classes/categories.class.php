<?php
class Categories extends Database{
  private $categories;
  private $selected;
  public function __construct() {
    parent::__construct();
    $this -> query = "SELECT 
    categories.category_id AS id,
    categories.name AS name,
    COUNT(products_categories.category_id) AS cat_count
    FROM products_categories 
    INNER JOIN categories
    ON products_categories.category_id = categories.category_id
    WHERE categories.active=1 GROUP BY products_categories.category_id";
    
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
}
?>
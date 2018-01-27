<?php
class WishList extends Database{
  public $list = array();
  private $account_id;
  private $list_id;
  public $errors = array();
  public function __construct( $account_id = NULL ) {
    //instantiate the database class (the parent class)
    parent::__construct();
    //check if account id is supplied / not null
    if( empty( $account_id ) ){
      return false;
    }
    else{
      $this -> account_id = $account_id;
      $this -> createList();
    }
  }
  private function createList(){
    //create a new list
    $query_create = "INSERT INTO wishlist (account_id) VALUES (?)";
    $statement = $this -> connection -> prepare( $query_create );
    $statement -> bind_param( "i" , $this -> account_id );
    if( $statement -> execute() ){
      $this -> list_id = $this -> connection -> insert_id;
      return true;
    }
    else{
      //if create fails,
      //check error code
      $error_code = $this -> connection -> errno;
      //if code = 1062, list already exists
      if($error_code == "1062"){
        //get the list id
        $this -> getListId();
      }
    }
  }
  private function getListId(){
    $query_list = "SELECT wishlist_id FROM wishlist WHERE account_id=?";
    $statement = $this -> connection -> prepare( $query_list );
    $statement -> bind_param( "i" , $this -> account_id );
    if( $statement -> execute() == false ){
      return false;
    }
    else{
      $result = $statement -> get_result();
      $row = $result -> fetch_assoc();
      $this -> list_id = $row["wishlist_id"];
      return $row["wishlist_id"];
    }
  }
  public function addItem( $product_id ){
    $query_add = "INSERT INTO 
                  wishlist_items 
                  (wishlist_id, product_id) 
                  VALUES (?,?)";
    if($this -> list_id){
      //if the user has a list and is logged in
      //add item to the list_items table
      $statement = $this -> conn -> prepare($query);
      $statement -> bind_param("ii",$this->list_id,$product_id);
      if( $statement -> execute() ){
        return true;
      }
    }
    else{
      //there is no list
      return false;
    }
  }
  public function removeItem( $product_id ){
    $query_delete = "DELETE FROM 
                    wishlist_items 
                    WHERE product_id = ? 
                    AND wishlist_id= ?";
    //remove the product from the wishlist_items table
    $statement = $this -> conn -> prepare( $query_delete );
    $statement -> bind_param("ii", $product_id, $this -> list_id);
    if( $statement -> execute() ){
      return true;
    }
    else{
      return false;
    }
  }
  public function getItemsCount(){
    
  }
  public function getListItems(){
    
  }
  public function __toString(){
    
  }
}
?>
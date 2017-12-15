<?php
session_start();
include("includes/database.php");
//php receives GET parameters as an array $_GET
//check if id has been set via a get request
if( isset($_GET["id"]) ){
  // $query = "SELECT id,name,description,price FROM products WHERE id=" . $_GET["id"];
  $product_query = "SELECT id,name,description,price FROM products WHERE id=?";
  $statement = $connection -> prepare($product_query);
  //there are four types in bind_param
  //i = integer
  //s = string
  //d = double (or float)
  //b = blob (or binary)
  $statement -> bind_param( "i", $_GET["id"] );
  //execute statement
  $statement -> execute();
  //get result
  $result = $statement -> get_result();
  //convert result into an array
  $product = $result -> fetch_assoc();
}
?>
<!doctype html>
<html>
  <?php include("includes/head.php"); ?>
  <body>
    <?php include("includes/navigation.php"); ?>
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <h2><?php echo $product["name"]; ?></h2>
          <h3 class="price"><?php echo $product["price"]; ?></h3>
          <p><?php echo $product["description"]; ?></p>
        </div>
      </div>
    </div>
  </body>
</html>
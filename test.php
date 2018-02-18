<?php
$docroot = $_SERVER["DOCUMENT_ROOT"];
include("$docroot/autoloader.php");

$response = array();
$errors = array();

$products_class = new products\Products();
$products = $products_class -> getProducts();

echo json_encode($products);

$get = $_GET["categories"];
if( gettype( $get ) == "array" ){
  //echo "hello array";
}
?>
<!doctype html>
<html>
  <head></head>
  <body>
    <form method="get" action="test.php">
      <label>Category 9</label>
      <input type="checkbox" name="categories[]" value="9">
      <br>
      <label>Category 10</label>
      <input type="checkbox" name="categories[]" value="10">
      <button type="submit" name="submit"> Submit </button>
    </form>
  </body>
</html>

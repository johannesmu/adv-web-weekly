<?php
$docroot = $_SERVER["DOCUMENT_ROOT"];
include("$docroot/autoloader.php");

$response = array();
$errors = array();

$products_class = new products\Products();
$products = $products_class -> getProducts();

print_r( $products );

// // print_r( $products );
// $test = array("ii","oranges","apples");
// $params = array();
// foreach( $test as $key => $value){
//   $params[$key] = &$test[$key];
// }
// print_r($params);
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

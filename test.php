<?php
$docroot = $_SERVER["DOCUMENT_ROOT"];
include("$docroot/autoloader.php");

$response = array();
$errors = array();

$products_class = new products\Products();

print_r( $products_class -> categories);

?>
<form method="get" action="test.php">
  <label>Category 9</label>
  <input type="checkbox" name="category[]" value="9">
  <br>
  <label>Category 10</label>
  <input type="checkbox" name="category[]" value="10">
  <button type="submit" name="submit"> Submit </button>
</form>
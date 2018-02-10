<?php
include("autoloader.php");

$cat = new categories\Categories();
$cat_items = $cat -> getCategories();
print_r( $cat_items );


?>
<form method="get" action="test.php">
  <label>Category 9</label>
  <input type="checkbox" name="category[]" value="9">
  <br>
  <label>Category 10</label>
  <input type="checkbox" name="category[]" value="10">
  <button type="submit" name="submit"> Submit </button>
</form>
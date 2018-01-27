<?php
session_start();
//check if user is allowed here via session

include("../autoloader.php");

//create instance of products class
$products = new Products();
$product_items = $products -> getAllProducts();

include("../includes/config.php");
$page_title = "Current Products";
?>

<!doctype html>
<html>
  <?php include("../includes/head.php"); ?>
  <body>
    <?php include("../includes/navigation.php"); ?>
    <div class="container">
      <?php
        if( count($product_items) > 0 ){
          foreach($product_items as $product){
            $id = $product["id"];
            $name = $product["name"];
            $price = $product["price"];
            $image = $product["image_file_name"];
            $active = $product["active"];
            echo "<div class=\"row\">
              <div class=\"col-md-2\">
                <img class=\"img-responsive\" src=\"/images/products/$image\">
              </div>
              <div class=\"col-md-4\">
                <h4>$name</h4>
                <h5>product id $id</h5>
              </div>
              <div class=\"col-md-3\">
                <p class=\"price\">$price</p>
              </div>
            </div>
            <hr>";
          }
        }
      ?>
    </div>
  </body>
</html>
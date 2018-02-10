<?php
session_start();

include("autoloader.php");
//site configuration
include("includes/config.php");

//page name
$page_title = "Welcome to $site_name";

//create instance of products class
$products = new products\Products();
$product_items = $products -> getProducts();

//create instance of categories class
$categories = new categories\Categories();
$cat_array = $categories -> getCategoriesArray();
?>
<!doctype html>
<html>
  <?php include("includes/head.php"); ?>
  <body>
    <?php include("includes/navigation.php"); ?>
    <div class="container">
      <div class="row">
        <?php include("includes/shop_navigation.php"); ?>
      </div>
      <div class="row">
        <nav class="col-md-2">
          <!--categories-->
          <!--<h4>Categories</h4>-->
            <?php
              // if( count($cat_array) > 0 ){
              //   foreach( $cat_array as $cat_nav_item ){
              //     $id = $cat_nav_item["id"];
              //     $name = ucwords( $cat_nav_item["name"] );
              //     $count = $cat_nav_item["cat_count"];
              //     if( isset( $cat_nav_item["class"] ) ){
              //       $class_attribute = "class=\"active\"";
              //     }
              //     else{
              //       $class_attribute = "";
              //     }
              //     $url = "index.php?" . urlencode("category[]") . "=$id";
              //     echo "<li $class_attribute >
              //     <a href=\"$url\">$name";
              //     if( $count > 0 ){
              //       echo "<span class=\"badge\">$count</span>";
              //     }
              //     echo "</a></li>";
              //   }
                
              // }
            ?>
          <form method="post" id="category-filter-form">
            <div id="category-filter"></div>
            <button type="submit" class="btn btn-default">Filter</button>
          </form>
        </nav>
        <main class="col-md-10">
          <!--products-->
          <!--<h4>Products</h4>-->
          <?php
            if( count($product_items) > 0 ){
              $counter = 0;
              foreach( $product_items as $product ){
                $id = $product["id"];
                $name = $product["name"];
                $price = $product["price"];
                
                $description = new utilities\TruncateWords($product["description"],10);
                $image = $product["image_file_name"];
                
                $counter++;
                if($counter == 1){
                  //create boostrap row
                  echo "<div class=\"row\">";
                }
                echo "<div class=\"col-md-3 col-sm-6 product-column\">
                <h3 class=\"product-title\">$name</h3>
                <a href=\"detail.php?id=$id\">
                <img class=\"img-responsive product-image\" src=\"images/products/$image\">
                </a>
                <h4 class=\"price product-price\">$price</h4>
                <p class=\"product-description\">$description</p>
                <a href=\"detail.php?id=$id\">Product Detail</a>
                </div>";
                if($counter == 4){
                  echo "</div>";
                  $counter = 0;
                }
              }
            }
                
            //   }
            // }
            ?>
        </main>
      </div>
      
    </div>
    <script src="js/categories.js"></script>
    <template id="category-template">
      <div class="checkbox">
        <label>
          <input type="checkbox" name="categories[]" value="">
          <span class="checkbox-label"></span>
          <span class="badge"></span>
        </label>
      </div>
    </template>
    <template id="catnav-item">
      <li>
        <a href=""><span class="badge"></span></a>
      </li>
    </template>
  </body>
</html>
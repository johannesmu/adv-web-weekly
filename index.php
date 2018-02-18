<?php
session_start();

include("autoloader.php");
//site configuration
include("includes/config.php");

//page name
$page_title = "Welcome to $site_name";

//create instance of products class
//products now loaded via products.js
$products = new products\Products();
//$product_items = $products -> getProducts();

//create instance of categories class
//categories now loaded via categories.js
//$categories = new categories\Categories();
//$cat_array = $categories -> getCategoriesArray();

include("includes/tester.php");
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
          <form method="get" id="category-filter-form">
            <div id="category-filter"></div>
            <button type="submit" class="btn btn-default">Filter</button>
          </form>
        </nav>
        <main class="col-md-10">
          <!--products will be added here via products.js-->
          <div class="products-row"></div>
        </main>
      </div>
      
    </div>
    <script src="js/categories.js"></script>
    <script src="js/products.js"></script>
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
    <template id="product-template">
      <div class="col-md-3 col-sm-6 col-xs-12 product-thumbnail">
        <a href="#" class="product-detail-link">
          <h3 class="product-title"></h3>
          <div class="product-image-container">
            <img class="product-image">
          </div>
        </a>
        <h4 class="price product-price"></h4>
        <div class="product-description"></div>
        <a href="#" class="product-detail-link">More</a>
      </div>
    </template>
  </body>
</html>
<?php
session_start();

include("autoloader.php");

include("includes/config.php");
//php receives GET parameters as an array $_GET
//check if product id has been set via a get request
if( isset($_GET["id"]) ){
  $product_id = $_GET["id"];
  $products = new products\Products();
  $product = $products -> getProductById( $product_id );
  //we use ucwords() to capitalise the product name
  $page_title = ucwords( $product["name"] );
}
else{
  
}
?>
<!doctype html>
<html>
  <?php include("includes/head.php"); ?>
  <body>
    <?php include("includes/navigation.php"); ?>
    <div class="container">
      <div class="row product-detail-row">
        <div class="col-md-6">
          <img class="img-responsive" src="/images/products/<?php echo $product["image"];  ?>">
        </div>
        <div class="col-md-6">
          <h2 class="product-title-single">
            <?php echo $product["name"]; ?>
          </h2>
          <p><?php echo $product["description"]; ?></p>
          <form id="shop-form" method="get">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Quantity</label>
                  <div class="input-group product-qty-group">
                    <span class="input-group-btn">
                      <button id="minus" class="btn btn-default product-qty-button">&minus;</button>
                    </span>
                    <input name="quantity" class="form-control text-center" value="1" type="text">
                    <span class="input-group-btn">
                      <button id="plus" class="btn btn-default product-qty-button">&plus;</button>
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="form-group product-single-buttons">
                  <button class="btn btn-primary" data-function="cart">
                    <span class="glyphicon glyphicon-shopping-cart"></span>
                    Add to cart
                  </button>
                  <button class="btn btn-primary" data-function="wish">
                    <span class="glyphicon glyphicon-star"></span>
                    Add to list
                  </button>
                </div>
              </div>
            </div>
            <input type="hidden" id="product-id" value="<?php echo $product["id"]; ?>">
          </form>
          <h4 class="price"><?php echo $product["price"]; ?></h4>
         
        </div>
      </div>
    </div>
    <script src="js/product-detail.js"></script>
    <template id="template-spinner">
      <span class="glyphicon glyphicon-repeat spinner"></span>
    </template>
    <template id="template-tick">
      <span class="glyphicon glyphicon-check"></span>
    </template>
  </body>
</html>
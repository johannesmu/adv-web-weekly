<?php
session_start();
//check if user is allowed here via session

include("../autoloader.php");

include("../includes/config.php");
$page_title = "Add a new product";

$cat = new Categories();
$category_names = $cat -> getCategoriesArray();

?>

<!doctype html>
<html>
  <?php include("../includes/head.php"); ?>
  <body>
    <?php include("../includes/navigation.php"); ?>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2>Add a new product</h2>
        </div>
        <div class="col-md-12">
          <form id="product-add" enctype="multipart/form-data" method="post">
            <!--product name-->
            <div class="form-group">
              <label for="product-name">Product Name</label>
              <input type="text" name="product_name" id="product-name" class="form-control" placeholder="Name of product" >
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="product-price">Product Price</label>
                  
                  <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <input type="number" name="product_price" id="product-price" step="0.10" min="1.00" value="99.00" class="form-control"j required>
                  </div>

                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Set categorie(s) for this product</label>
                  <div class="input-group">
                    <input type="text" id="new-category" class="form-control" placeholder="add a new category">
                    <span class="input-group-btn">
                      <button id="new-category-btn" class="btn btn-default" type="button">
                        Add
                      </button>
                    </span>
                  </div>
                  <div id="product-categories" class="checkbox-group">
                  <?php
                    if( count($category_names) > 0 ){
                      foreach( $category_names as $category ){
                        $id = $category["category_id"];
                        $name = $category["name"];
                        echo "<div class=\"checkbox\">
                        <label>
                          <input type=\"checkbox\" name=\"categories[]\" value=\"$id\">
                          $name
                        </label>
                        </div>";
                      }
                    }
                  ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="description">Product description</label>
                  <textarea class="form-control" name="product-description" cols="20" rows="4" placeholder="description for the product" id="description"></textarea>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Product image</label>
                  <div>
                  <!--<a href="#" id="add-uploader" class="btn btn-default">&plus;</a>-->
                  <button href="#" id="add-uploader" class="btn btn-default">&plus; Add an image uploader</button>
                  </div>
                  <div class="image-upload-group">
                    <div class="uploader">
                      <label class="image-upload-label" for="product-image-1">
                        <span class="image-upload-info">Select an image</span>
                      </label>
                      <input type="file" id="product-image-1" name="productimages[]">
                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="active" value="active">
                    Publish this product
                  </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <button type="reset" name="reset" class="btn btn-warning">
                  Clear Form
                </button>
                <button type="submit" name="submit" class="btn btn-success">
                  Save Product
                </button>
              </div>
            </div>
            
          </form>
        </div>
      </div>
    </div>
    <script src="/components/trumbowyg/dist/trumbowyg.js"></script>
    <script src="/js/text-editor.js"></script>
    <script src="/js/product-add.js"></script>
    <template id="file-upload-template">
      <div class="uploader">
        <label class="image-upload-label" for="">
          <span class="image-upload-info">Select an image</span>
        </label>
        <input type="file" id="" name="productimages[]">
        
      </div>
    </template>
    <template id="category-template">
      <div class="checkbox">
        <label>
          <input type="checkbox" name="categories[]" value="" checked >
          <span class="checkbox-text"></span>
        </label>
      </div>
    </template>
  </body>
</html>
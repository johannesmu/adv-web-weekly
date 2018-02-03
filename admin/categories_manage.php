<?php
session_start();
//check if user is allowed here via session

include("../autoloader.php");

//create instance of products class
$categories = new Categories();
$categories_items = $categories -> getAllCategories();

include("../includes/config.php");
$page_title = "Categories";
?>

<!doctype html>
<html>
  <?php include("../includes/head.php"); ?>
  <body>
    <?php include("../includes/navigation.php"); ?>
    <div class="container">
      <h3>Manage Existing Categories</h3>
      <?php
        if( count($categories_items) > 0 ){
          foreach($categories_items as $category){
            $id = $category["id"];
            $name = ucfirst( $category["name"] );
            $active = $category["active"];
            $count = $category["count"];
            if( $active == true ){
              $checked = "checked"; 
            }
            else{
              unset( $checked );
            }
            $form_target = $_SERVER["PHP_SELF"];
            echo "
            <form id=\"$id\" action=\"$form_target\" class=\"category-manage\">
            <div class=\"row\">
              <div class=\"col-md-3\">
                <div class=\"form-group\">
                  <!--<label for=\"category-name-$id\" >Category Name</label>-->
                  <div class=\"input-group\">
                    <input name=\"category_name\" id=\"category-name-$id\" data-id=\"$id\" class=\"form-control\" type=\"text\" value=\"$name\" readonly>
                    <span class=\"input-group-btn\">
                      <button data-id=\"$id\" type=\"button\" class=\"btn btn-default category-edit\">
                        <span class=\"glyphicon glyphicon-pencil\"></span>
                      </button>
                    </span>
                  </div>
                  
                </div>
              </div>
              <div class=\"col-md-3\">
                <p class=\"custom-control\">
                category id $id, total products: <span class=\"badge\">$count</span>
                </p>
               
              </div>
              <div class=\"col-md-3\">
                <div class=\"checkbox\">
                  <label>
                    <input type=\"checkbox\" name=\"active\" data-id=\"$id\"  $checked >
                    active
                  </label>
                </div>
              </div>
              <div class=\"col-md-3\">
                <button type=\"submit\" class=\"btn btn-primary\">
                  Apply
                </button>
              </div>
            </div>
            </form>
            <hr>";
          }
        }
      ?>
      <div class="row">
        <div class="col-md-12">
          <h3>Add a new category</h3>
          <form class="jumbotron">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="new-name">Name</label>
                  <input type="text" name="new-name" id="new-name" class="form-control" placeholder="name">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Active</label>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" checked>
                     Active
                    </label>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Save</label>
                  <button type="submit" class="btn btn-success">Add</button>
                </div>
                
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <template id="template-spinner">
      <span class="glyphicon glyphicon-repeat spinner"></span>
    </template>
    <script src="/js/categories-manage.js"></script>
    
  </body>
</html>
<?php
include("includes/database.php");

if( isset($_GET["search"]) ){
  $search_words = "%" . $_GET["search"] . "%";
  //query
  $search_query = "SELECT id,name,price FROM products WHERE name LIKE ? OR description LIKE ?";
  $statement = $connection -> prepare($search_query);
  $statement -> bind_param("ss",$search_words, $search_words);
  $statement -> execute();
  $result = $statement -> get_result();
}
$page_title = "Search results for ".$_GET["search"];
?>
<!doctype html>
<html>
  <?php include("includes/head.php"); ?>
  <body>
    <?php include("includes/navigation.php"); ?>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <?php
          if( isset($searchvalue) ){
            echo "<h4>You searched for <strong>$searchvalue</strong></h4>";
          }
          ?>
        </div>
      </div>
      <?php
      if($result -> num_rows > 0){
        while( $row = $result -> fetch_assoc() ){
          $id = $row["id"];
          $name = $row["name"];
          echo "<div class=\"row\">
          <div class=\"col-md-12\">
            <h3>$name</h3>
            <a href=\"detail.php?id=$id\">Read More</a>
          </div>
          </div>";
        }
      }
      else{
        echo "sorry, no results";
      }
      ?>
    </div>
  </body>
</html>
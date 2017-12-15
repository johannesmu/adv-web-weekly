<?php
session_start();

include("autoloader.php");
// include("includes/database.php");
//create instance of products class
$products = new Products();
$product_items = $products -> getProducts();

//check if connection is successful
// if($connection){
//   //echo "success";
//   $query = "SELECT 
//             products.id,
//             products.name,
//             products.description,
//             products.price,
//             images.image_file_name
//             FROM products
//             INNER JOIN products_images
//             ON products.id = products_images.product_id
//             INNER JOIN images
//             ON products_images.image_id = images.image_id GROUP BY products.id";
//   //run the query
//   $statement = $connection -> prepare($query);
//   $statement -> execute();
//   //get the result
//   $result = $statement -> get_result();
// }
// else{
//   echo "connection failed";
// }
?>
<!doctype html>
<html>
    <?php include("includes/head.php"); ?>
    <body>
      <?php include("includes/navigation.php"); ?>
      <div class="container">
        <div class="row">
          <aside class="col-md-2">
            <!--categories-->
            <h4>Categories</h4>
          </aside>
          <main class="col-md-10">
            <!--products-->
            <h4>Products</h4>
            <?php
              // if($result -> num_rows > 0){
              //   $counter = 0;
              //   while( $row = $result -> fetch_assoc() ){
              //     $id = $row["id"];
              //     $name = $row["name"];
              //     $price = $row["price"];
              //     $description = $row["description"];
              //     $image = $row["image_file_name"];
              if( count($product_items) > 0 ){
                $counter = 0;
                foreach( $product_items as $product ){
                  $id = $product["id"];
                  $name = $product["name"];
                  $price = $product["price"];
                  $description = $product["description"];
                  $image = $product["image_file_name"];
                  
                  $counter++;
                  if($counter == 1){
                    //create boostrap row
                    echo "<div class=\"row\">";
                  }
                  echo "<div class=\"col-md-3 col-sm-6 \">
                  <h3>$name $counter</h3>
                  <img class=\"img-responsive\" src=\"images/products/$image\">
                  <h4 class=\"price\">$price</h4>
                  <p>$description</p>
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
    </body>
</html>
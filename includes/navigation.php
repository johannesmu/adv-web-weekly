<nav class="navbar navbar-inverse navbar-static-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand logo" href="/">
        <img src="/images/graphics/<?php if(isset($site_logo)){echo $site_logo; }?>">
      </a>
      <?php 
      // print username if logged in
      if( $_SESSION["username"] ){
        echo "<p class=\"navbar-text\"> Hello " . $_SESSION["username"] . "</p>";
      }
      ?>
      <button class="navbar-toggle" data-toggle="collapse" data-target="#main-nav">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div class="navbar-right">
      <a href="/phpmyadmin/" class="navbar-text " target="_blank">Database</a>
      <a href="wishlist.php" class="navbar-text list">
        <span class="glyphicon glyphicon-heart"></span>
        <span class="badge">1</span>
      </a>
      <a href="shopping-cart.php" class="navbar-text list">
        <span class="glyphicon glyphicon-shopping-cart"></span>
        <span class="badge">1</span>
      </a> 
    </div>
      
    
  </div>
  <div class="container-fluid">
    
    <form class="navbar-form navbar-left" role="search" method="get" action="search.php">
        <div class="form-group">
          <?php 
          if($_GET["search"]){ 
            $searchvalue = $_GET["search"]; 
          }
          ?>
          <input type="text" name="search" class="form-control" placeholder="Search" value="<?php echo $searchvalue;?>">
        </div>
        <button type="submit" class="btn btn-default">
          <span class="glyphicon glyphicon-search"></span>
        </button>
    </form>
    <div class="collapse navbar-collapse" id="main-nav">
      <?php
      $nav = new \navigation\Navigation();
      echo $nav -> getNavigation();
      ?>
    </div>
  </div>
</nav>

<nav class="navbar navbar-inverse navbar-static-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand logo" href="/">
        <img src="/images/graphics/<?php echo $site_logo; ?>">
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
      $nav = new Navigation();
      echo $nav -> getNavigation();
      ?>
      <p class="navbar-text navbar-right">
        <a href="/phpmyadmin/" class="navbar-link " target="_blank">Database</a>
      </p>
    </div>
  </div>
</nav>
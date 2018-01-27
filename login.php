<?php
session_start();

include("autoloader.php");

//site configuration
include("includes/config.php");

include("includes/database.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $userid = $_POST["userid"];
  $password = $_POST["password"];
  
  $query = "SELECT account_id, username, email, password FROM accounts WHERE username=? OR email=?";
  $statement = $connection -> prepare($query);
  $statement -> bind_param("ss",$userid,$userid);
  if( $statement -> execute() ){
    $result = $statement -> get_result();
    //check if a result is returned (number of rows)
    if( $result -> num_rows > 0 ){
      //the user exists
      //convert result to an associative array
      $user = $result -> fetch_assoc();
      $account_id = $user["account_id"];
      $username = $user["username"];
      $email = $user["email"];
      $hash = $user["password"];
      //check if password matches --> password_verify()
      if( password_verify($password,$hash) ){
        //password is correct
        //log user in
        //create user session variables
        $_SESSION["account_id"] = $account_id;
        $_SESSION["username"] = $username;
        echo "password is correct";
      }
      else{
        // password is incorrect
        echo "password is incorrect";
      }
      
    }
    else{
      //account does not exist
      echo "account does not exist";
    }
  }
}
?>
<!doctype html>
<html>
  <?php include("includes/head.php"); ?>
  <body>
    <?php include("includes/navigation.php"); ?>
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
          
          <form id="login-form" method="post" action="login.php">
            <h2>Login to your account</h2>
            <div class="form-group">
              <label for="userid">Username or Email</label>
              <input type="text" class="form-control" id="userid" name="userid" placeholder="user66 or user@domain.com">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="your password">
              <p class="text-center" style="margin-top:20px;">
                <button type="submit" name="login-button" class="btn btn-primary">Log in</button>
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
    <script src="js/login.js"></script>
  </body>
  <template id="alert-template">
    <div class="alert alert-dismissable" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
      </button>
      <p class="alert-message"></p>
    </div>
  </template>
</html>
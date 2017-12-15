<?php
session_start();

include("autoloader.php");
include("includes/database.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
  //array to store errors in registration
  $errors = array();
  
  $username = $_POST["username"];
  //check username length
  $username_errors = array();
  if( strlen($username) < 6 ){
    $username_errors["length"] = "minimum 6 characters";
  }
  if( ctype_alnum($username)==false ){
    $username_errors["alnum"] = "can only contain alphanumeric characters";
  }
  if( count($username_errors) > 0 ){
    $errors["username"] = implode(" ,", $username_errors);
  }
  
  
  //verify the email address is valid
  $email = $_POST["email"];
  if( filter_var($email,FILTER_VALIDATE_EMAIL) == false ){
    $errors["email"] = "invalid email address";
  }
  
  //check the passwords
  $password1 = $_POST["password1"];
  $password2 = $_POST["password2"];
  $password_errors = array();
  if($password1 !== $password2){
    $password_errors["equal"] = "passwords are not the same";
  }
  if( strlen($password1) < 8 || strlen($password2) < 8){
    $password_errors["length"] = "minimum 8 characters";
  }
   if( count($password_errors) > 0 ){
    $errors["password"] = implode(" ,", $password_errors);
   }
  //count the number of errors, if 0 then proceed
  if( count($errors) == 0){
    //hash the password
    $hashed = password_hash($password1,PASSWORD_DEFAULT);
    //create a query
    $query = "INSERT INTO accounts 
    (username,email,password,active)
    VALUES (?,?,?,1)";
    $statement = $connection -> prepare($query);
    $statement -> bind_param("sss",$username,$email,$hashed);
    $message = array();
    if( $statement -> execute() ) {
      //account has been created
      $message["type"] = "success";
      $message["text"] = "Your account has been created";
    }
    else{
      if($connection -> errno == "1062"){
        //either email or username exists in database
        $dberror = $connection -> error;
        if(strstr($dberror,"email")){
          //duplicate username
          $errors["email"] = "email already exists";
        }
        elseif(strstr($dberror,"username")){
          //duplicate email
          $errors["username"] = "username already exists";
        }
      }
      $message["type"] = "danger";
      $message["text"] = "There has been an error";
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
          <form id="register-form" method="post" action="register.php">
            <h2>Register for account</h2>
            <?php
            if( count($message) > 0 ){
              $class = "alert-" . $message["type"];
              $text = $message["text"];
              echo "<div class=\"alert $class\">$text</div>";
            }
            
            if($errors["username"]){
              $error_class = "has-error";
            }
            else{
              $error_class = "";
            }
            ?>
            <div class="form-group <?php echo $error_class; ?>">
              <label for="username">Username</label>
              <input class="form-control" type="text" name="username" id="username" placeholder="username88" value="<?php echo $username; ?>">
              <span class="help-block"><?php echo $errors["username"]; ?></span>
            </div>
            <!--email-->
            <?php
            if($errors["email"]){
              $error_class = "has-error";
            }
            else{
              $error_class = "";
            }
            ?>
            <div class="form-group <?php echo $error_class; ?>">
              <label for="email">Email Address</label>
              <input class="form-control" type="email" name="email" id="email" placeholder="username@domain.com" value="<?php echo $email; ?>">
              <span class="help-block"><?php echo $errors["email"]; ?></span>
            </div>
            <!--password-->
            <?php
            if($errors["password"]){
              $error_class = "has-error";
            }
            else{
              $error_class = "";
            }
            ?>
            <div class="form-group <?php echo $error_class; ?>">
              <label for="password">Password</label>
              <input class="form-control" type="password" name="password1" id="password1" placeholder="minimum 8 characters">
            </div>
            <div class="form-group <?php echo $error_class; ?>">
              <label for="password">Retype Password</label>
              <input class="form-control" type="password" name="password2" id="password2" placeholder="please retype your password">
              <span class="help-block"><?php echo $errors["password"]; ?></span>
            </div>
            <br>
            <button type="reset" class="btn btn-warning">Clear Form</button>
            <button type="submit" class="btn btn-success">Register</button>
          </form>
          
        </div>
      </div>
    </div>
  </body>
</html>
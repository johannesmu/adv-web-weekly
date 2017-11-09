<?php
$host = getenv("host");
$user = getenv("username");
$password = getenv("password");
$database = getenv("database");
$connection = mysqli_connect($host,$user,$password,$database);
?>
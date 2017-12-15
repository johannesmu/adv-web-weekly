<?php
include("autoloader.php");

$test = new Test();

$greeting = $test -> getGreeting();
echo "<h2>$greeting</h2>";

$newgreeting = $test -> setGreeting("Hello there, this is a new greeting!");
echo "<h2>". $test -> getGreeting() ."</h2>";
?>
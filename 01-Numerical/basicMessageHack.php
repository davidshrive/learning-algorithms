<?php

include 'functions.php';


echo 'Basic Message HACK!'.PHP_EOL;;

$stdin = fopen ("php://stdin","r");

echo 'Please enter your encrypted message: '.PHP_EOL;
$message = fgets($stdin);

$seed = hackMessage($message);

echo 'Your seed is: '.PHP_EOL;
var_dump($seed);

?>
<?php

include 'functions.php';

echo 'Basic Message Decrypt'.PHP_EOL;;

$stdin = fopen ("php://stdin","r");

echo 'Please enter an message: '.PHP_EOL;
$message = fgets($stdin);

echo 'Please enter an number seed: '.PHP_EOL;
$seed = intval(fgets($stdin));

$message = decryptMessage($message, $seed);

echo 'Your decrypted message: '.PHP_EOL;
echo $message.PHP_EOL;

?>
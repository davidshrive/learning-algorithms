<?php


define("A", 723);
define("B", 545);
define("M", 1145);

function returnNextRandomNumber ($seed)
{
	return (A * $seed + B) % M;
}

echo 'Random Number Generator'.PHP_EOL;;

$stdin = fopen ("php://stdin","r");

echo 'Please enter an integer seed: '.PHP_EOL;
$seed = intval(fgets($stdin));

echo 'Please enter how many numbers you want to generate: '.PHP_EOL;
$num = intval(fgets($stdin));

echo 'The first '.$num.' random numbers from the seed '.$seed.' are: '.PHP_EOL;

for ($i=0; $i < $num; $i++) { 
	echo $seed.' ';
	$seed = returnNextRandomNumber($seed);
}

echo PHP_EOL;

?>
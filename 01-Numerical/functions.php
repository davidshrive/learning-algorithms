<?php

// range of ascci supported
define("LOWER", 32);
define("UPPER", 126);

// http://www.math.cornell.edu/~mec/2003-2004/cryptography/subs/frequencies.html
$expectedFrequency = [
	'a' => 8.12,
	'b' => 1.49,
	'c' => 2.71,
	'd' => 4.32,
	'e' => 12.02,
	'f' => 2.30,
	'g' => 2.03,
	'h' => 5.92,
	'i' => 7.31,
	'l' => 3.98,
	'k' => 0.69,
	'l' => 3.98,
	'm' => 2.61,
	'n' => 6.95,
	'o' => 7.68,
	'p' => 1.82,
	'q' => 0.11,
	'r' => 6.02,
	's' => 6.28,
	't' => 9.10,
	'u' => 2.88,
	'v' => 1.11,
	'w' => 2.09,
	'x' => 0.17,
	'y' => 2.11,
	'z' => 0.07
];

function returnToAsciiRange($ascii, $lower, $upper)
{
	// if values falls within aschi range then simply return value 
	if (($ascii >= $lower) && ($ascii <= $upper)) {
		return $ascii;
	}

	// calculate range
	$range = ($upper - $lower) + 1;

	// if above range
	if ($ascii > $upper)
	{

		$diff = $ascii - $upper;
		$num = ceil($diff/$range);
		$ascii = $ascii - ($range*$num);
		return $ascii;
	}

	// if below range
	if ($ascii < $lower)
	{
		$diff = $lower - $ascii;
		$num = ceil($diff/$range);
		$ascii = $ascii + ($range*$num);
		return $ascii;
	}
}

function encodeMessage($message, $seed)
{	
	// remove end of line char
	$message = rtrim($message,"\n");
	
	// split into array
	$characters = str_split ($message);

	// create output string ready
	$output = '';

	// for each character convert to ascii and then add seed
	foreach ($characters as $inputchar) {
		// returns ascii
		$ascii = ord($inputchar);
		
		// add seed to ascii
		$ascii += $seed;

		// ensure ascii is within range
		$ascii = returnToAsciiRange($ascii, LOWER, UPPER);

		// convert back to a char
		$char = chr($ascii);

		// Add to output
		$output.=$char;
	}

	return $output;
}

function decryptMessage($message, $seed)
{	
	// remove end of line char
	$message = rtrim($message,"\n");
	
	// split into array
	$characters = str_split($message);

	// create output string ready
	$output = '';

	// for each character convert to ascii and then remove seed
	foreach ($characters as $inputchar) {
		// returns ascii
		$ascii = ord($inputchar);

		// take seed from ascii
		$ascii -= $seed;

		// ensure ascii is within range
		$ascii = returnToAsciiRange($ascii, LOWER, UPPER);

		// convert back to a char
		$char = chr($ascii);

		// Add to output
		$output.=$char;
	}

	return $output;
}

function calcFrequency($message)
{
	// save size
	$length = strlen($message);

	// convert to lower case
	$message = strtolower($message);

	// grab all letters only, ignore numbers/special/etc
	preg_match_all('/[a-z]/', $message, $matches);
	$letters = $matches[0];

	$freq =[];

	// count up occurrences of each letter
	foreach ($letters as $letter) {
		if (array_key_exists($letter, $freq)){
			$freq[$letter]++;
		} else {
			$freq[$letter] = 1;
		}		
	}

	// calculate frequency as percentage
	foreach ($freq as $letter => $value) {
		$freq[$letter] = ($value/$length)*100;
	}

	return $freq;
}

function hackMessage($message)
{	
	// remove end of line char
	$message = rtrim($message,"\n");

	$potential = [];

	for ($i =0; $i<5; $i++){
		$potential[$i]['Decoded'] = $t = decryptMessage($message, $i);
		$potential[$i]['Freq'] = calcFrequency($t);
	}

	return $potential;
}
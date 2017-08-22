<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');
	$options = array('fridge_id');
	$opt = getopt("", $options);
	$fridge_id = getOption($options[0], $opt, 0);
	// List of meals
	$mealcards = ls_mealcard($fridge_id);
	echo fb_mealcards($mealcards);

?>

<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');
	$opt = getopt("", array('fridge_id:'));
	$fridge_id = getOption('fridge_id', $opt, 0);
	// List of meals
	$mealcards = ls_mealcard($fridge_id);
	echo fb_mealcards($mealcards);

?>

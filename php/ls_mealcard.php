<?php
	require "buynshare.php";

	// List of meals
	$fridge_id = $_GET['fridge_id'];
	$mealcards = ls_mealcard($fridge_id);

	header('Content-Type: application/octet-stream');
	echo fb_mealcards($mealcards);

?>

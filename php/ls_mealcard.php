<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');
	// List of meals
	if (isset($_REQUEST['fridge_id']))
		$fridge_id = $_REQUEST ['fridge_id'];
	else
		$fridge_id = 0;
	$mealcards = ls_mealcard($fridge_id);
	echo fb_mealcards($mealcards);

?>

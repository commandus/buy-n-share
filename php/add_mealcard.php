<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');

	// Read meal
	$bb = Google\FlatBuffers\ByteBuffer::wrap(file_get_contents('php://input'));

	$options = array('qty', 'fridge_id', 'meal_id');
	$opt = getopt("", $options);
	$qty = getOption($options[0], $opt, 1);
	$fridge_id = getOption($options[1], $opt, 0);
	$meal_id = getOption($options[2], $opt, 0);
	// Create a new mealCard
	$id = add_mealcard(
		$fridge_id,
		$meal_id,
		$qty
	);

	if (!$id)
	{
		http_response_code(500);
		echo false;
		return;
	}

	// Return meal card
	echo fb_mealcard(
		$fridge_id,
		$meal_id,
		$qty
	);

?>

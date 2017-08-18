<?php
	require "buynshare.php";

	// Read meal
	$bb = Google\FlatBuffers\ByteBuffer::wrap(file_get_contents('php://input'));

	$qty = _GET['qty'];
	$fridge_id = _GET['fridge_id'];
	$meal_id = _GET['meal_id'];

	try
	{
		$m = bs\Meal::getRootAsMealCard($bb);
	}
		catch(Exception $e) 
	{
		http_response_code(500);
		header('Content-Type: text/plain');
		echo "Error: no input data\n";
		return;
	}

	// Create a new mealCard
	$id = add_mealcard(
		$fridge_id,
		$meal_id,
		$qty
	);

	if (!$id)
	{
		http_response_code(500);
		header('Content-Type: text/plain');
		echo 'Add error: ' . pg_last_error();
	}


	// Return meal card
	header('Content-Type: application/octet-stream');
	echo fb_mealcard(
		$fridge_id,
		$meal_id,
		$qty
	);

?>

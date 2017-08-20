<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');

	// Read meal
	$bb = Google\FlatBuffers\ByteBuffer::wrap(file_get_contents('php://input'));

	if (isset($_REQUEST['qty']))
		$qty = $_REQUEST ['qty'];
	else
		$qty = 0;
	if (isset($_REQUEST['fridge_id']))
		$fridge_id = $_REQUEST ['fridge_id'];
	else
		$fridge_id = 0;
	if (isset($_REQUEST['meal_id']))
		$meal_id = $_REQUEST ['meal_id'];
	else
		$meal_id = 0;

	try
	{
		$m = bs\Meal::getRootAsMealCard($bb);
	}
		catch(Exception $e) 
	{
		http_response_code(500);
		echo false;
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

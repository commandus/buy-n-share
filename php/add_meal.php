<?php
	require "buynshare.php";

	// Read meal
	$bb = Google\FlatBuffers\ByteBuffer::wrap(file_get_contents('php://input'));

	try
	{
		$m = bs\Meal::getRootAsMeal($bb);
	}
		catch(Exception $e) 
	{
		http_response_code(500);
		header('Content-Type: text/plain');
	echo "Error: no input data\n";
		return;
	}

	// Create a new meal
	$id = add_meal(
	$m->getCn(),
	$m->getLocale()
	);

	if (!$id)
	{
		http_response_code(500);
		header('Content-Type: text/plain');
		echo 'Add error: ' . pg_last_error();
	}

	// Return meal
	header('Content-Type: application/octet-stream');
	echo fb_meal(
	$id,
	$m->getCn(),
	$m->getLocale()
	);

?>

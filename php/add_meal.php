<?php
	require "buynshare.php";

	// Read meal
	$bb = Google\FlatBuffers\ByteBuffer::wrap(get_post_input());
	header('Content-Type: application/octet-stream');
	try
	{
		$m = bs\Meal::getRootAsMeal($bb);
	}
		catch(Exception $e) 
	{
		http_response_code(500);
		echo false;
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
		echo false;
		return;
	}

	// Return meal
	echo fb_meal(
		$id,
		$m->getCn(),
		$m->getLocale()
	);

?>

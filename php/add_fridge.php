<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');
	// Read fridge
	$bb = Google\FlatBuffers\ByteBuffer::wrap(file_get_contents('php://input'));

	try
	{
		$f = bs\Fridge::getRootAsUser($bb);
	}
		catch(Exception $e) 
	{
		http_response_code(500);
		echo false;
		return;
	}

	// Create  a new fridge
	$id = add_fridge(
		$f->getCn(),
		$f->getKey(),
		$f->getLocale(),
		$f->getGeo()->getLat(),
		$f->getGeo()->getLon(),
		$f->getGeo()->getAlt()
	);

	if (!$id)
	{
		http_response_code(500);
		echo false;
		return;
	}

	// Return id, key
	echo fb_fridge(
		$id,
		$f->getCn(),
		$f->getKey(),
		$f->getLocale(),
		$f->getGeo()->getLat(),
		$f->getGeo()->getLon(),
		$f->getGeo()->getAlt()
	);
?>

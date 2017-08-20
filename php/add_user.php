<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');
	// Read user
	$bb = Google\FlatBuffers\ByteBuffer::wrap(file_get_contents('php://input'));
	try
	{
		$u = bs\User::getRootAsUser($bb);
	}
		catch(Exception $e) 
	{
		http_response_code(500);
		echo false;
		return;
	}

	// Create  a new user
	$id = add_user(
		$u->getCn(),
		$u->getKey(),
		$u->getLocale(),
		$u->getGeo()->getLat(),
		$u->getGeo()->getLon(),
		$u->getGeo()->getAlt()
	);

	if (!$id)
	{
		http_response_code(500);
		echo false;
		return;
	}

	// Return id, key
	echo fb_user(
		$id,
		$u->getCn(),
		$u->getKey(),
		$u->getLocale(),
		$u->getGeo()->getLat(),
		$u->getGeo()->getLon(),
		$u->getGeo()->getAlt()
	);

?>

<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');
	// Read user
	$bb = Google\FlatBuffers\ByteBuffer::wrap(get_post_input());
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

	$key = $u->getKey();
	if (empty($key))
		$key = generateRandomString();

	// Create  a new user
	$id = add_user(
		$u->getCn(),
		$key,
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
		$key,
		$u->getLocale(),
		$u->getGeo()->getLat(),
		$u->getGeo()->getLon(),
		$u->getGeo()->getAlt()
	);

?>

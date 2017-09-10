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

	$lat = 0.0;	// $u->getGeo()->getLat();
	$lon = 0.0;	// $u->getGeo()->getLon();
	$alt = 0;	// $u->getGeo()->getAlt();

	// Create  a new user
	$id = add_user(
		$u->getCn(),
		$key,
		$u->getLocale(),
		$lat,
		$lon,
		$alt
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
		$lat,
		$lon,
		$alt
	);

?>

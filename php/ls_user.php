<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');
	// List of users
	/*
	$bb = Google\FlatBuffers\ByteBuffer::wrap(file_get_contents('php://input'));

	try
	{
		$u = bs\User::getRootAsUser($bb);
	}
		catch(Exception $e) 
	{
		http_response_code(500);
		header('Content-Type: text/plain');
		echo "Error: no user\n";
		return;
	}

	*/
	// print $u->getId() . " " . $u->getLocale() . " " . $u->getGeo()->getLat() . " " . $u->getGeo()->getLon() . " " . $u->getGeo()->getAlt();

	// User list
	$locale = "ru";
	$users = ls_user($locale);
	echo fb_users( $users);

?>

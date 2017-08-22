<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');
	$options = array('user_id', 'balance');
	$opt = getopt("", $options);
	$user_id = getOption($options[0], $opt, 0);  // mandatory
	$balance = getOption($options[1], $opt, 0);  // optional

	// Read fridge
	$bb = Google\FlatBuffers\ByteBuffer::wrap(file_get_contents('php://input'));

	try
	{
		$f = bs\Fridge::getRootAsFridge($bb);
	}
		catch(Exception $e) 
	{
		http_response_code(500);
		echo false;
		return;
	}

	$key = $f->getKey();
	if (empty($key))
		$key = generateRandomString();

	// Create  a new fridge

	$id = add_fridge(
		$user_id,
		$f->getCn(),
		$key,
		$f->getLocale(),
		$f->getGeo()->getLat(),
		$f->getGeo()->getLon(),
		$f->getGeo()->getAlt(),
		$balance
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
		$key,
		$f->getLocale(),
		$f->getGeo()->getLat(),
		$f->getGeo()->getLon(),
		$f->getGeo()->getAlt()
	);
?>

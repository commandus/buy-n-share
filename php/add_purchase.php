<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');
	// Read purchase
	$bb = Google\FlatBuffers\ByteBuffer::wrap(file_get_contents('php://input'));

	try
	{
		$f = bs\Purchase::getRootAsPurchase($bb);
	}
		catch(Exception $e) 
	{
		http_response_code(500);
		echo false;
		return;
	}

	$start = time(); // $f->getStart();
	$finish = $f->getFinish();

	$opt = getopt("", array('qty:', 'all:'));
	$qty = getOption('qty', $opt, 1);
	$all = getOption('all', $opt, false);

	if ($all)
	{
		// force all
		$vs = true;
	}
	else
	{
		// as specified
		$vs = array();
		for ($i = 0; $i < $f->getVotesLength(); $i++)
		{
			array_push($vs, $f->getVotes($i)->getId());
		}
	}

	// Create a new purchase
	$id = add_purchase(
		$f->getUserid(),
		$f->getFridgeid(),
		$f->getMeal()->getId(),
		$f->getCost(),
		$qty,
		$start,
		$finish,
		$vs
	);

	if (!$id)
	{
		http_response_code(500);
		echo false;
		return;
	}

	// Return purchase
	echo fb_purchase(
		$id,
		$f->getUserid(),
		$f->getFridgeid(),
		$f->getMeal()->getId(),
		$f->getCost(),
		$start,
		$finish,
		$vs
	);

?>

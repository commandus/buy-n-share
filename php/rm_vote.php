<?php
	require "buynshare.php";
	header('Content-Type: text/plain');
	
	// get user identifier
	$opt = getopt("", array('user_id:', 'purchase_id:'));
	$user_id = getOption('user_id', $opt, 0);
	$purchase_id = getOption('purchase_id', $opt, 0);
	// Remove vote
	$done = rm_vote(
		$user_id,
		$purchase_id
	);

	if (!$done)
	{
		http_response_code(500);
	}
	// Return purchase
	echo $done;
?>

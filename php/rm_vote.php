<?php
	require "buynshare.php";
	header('Content-Type: text/plain');
	
	// get user identifier
	$options = array('user_id', 'purchase_id');
	$opt = getopt("", $options);
	$user_id = getOption($options[0], $opt, 0);
	$purchase_id = getOption($options[1], $opt, 0);
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

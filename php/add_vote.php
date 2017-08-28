<?php
	require "buynshare.php";
	header('Content-Type: text/plain');
	$opt = getopt("", array('user_id:', 'purchase_id:'));
	$user_id = getOption('user_id', $opt, 0);
	$purchase_id = getOption('purchase_id', $opt, 0);
	// Add vote
	$id = add_vote(
		$user_id,
		$purchase_id
	);

	if (!$id)
		http_response_code(500);
	// Return vote id
	echo $id;

?>

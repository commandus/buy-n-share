<?php
	require "buynshare.php";
	header('Content-Type: text/plain');
	$options = array('user_id', 'purchase_id');
	$opt = getopt("", $options);
	$user_id = getOption($options[0], $opt, 0);
	$purchase_id = getOption($options[1], $opt, 0);

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

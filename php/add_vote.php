<?php
	require "buynshare.php";

	// get user identifier
	$user_id = $_GET['user_id'];
	$purchase_id = $_GET['purchase_id'];

	// Add vote
	$id = add_vote(
		$user_id,
		$purchase_id
	);

	if (!$id)
	{
		http_response_code(500);
		header('Content-Type: text/plain');
		echo 'Add error: ' . pg_last_error();
	}

	// Return purchase
	header('Content-Type: text/plain');
	echo $id;

?>

<?php
	require "buynshare.php";
	header('Content-Type: text/plain');
	
	// get user identifier
	if (isset($_REQUEST['user_id']))
		$user_id = $_REQUEST ['user_id'];
	else
		$user_id = 0;
	if (isset($_REQUEST ['purchase_id']))
		$purchase_id = $_REQUEST ['purchase_id'];
	else
		$purchase_id = 0;

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

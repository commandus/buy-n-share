<?php
	require "buynshare.php";
	header('Content-Type: text/plain');

	// get user identifier
	if (isset($_REQUEST['user_id']))
		$user_id = $_REQUEST ['user_id'];
	else
		$user_id = 0;
	if (isset($_REQUEST['purchase_id']))
		$purchase_id = $_REQUEST ['purchase_id'];
	else
		$purchase_id = 0;

	// Add vote
	$id = add_vote(
		$user_id,
		$purchase_id
	);

	if (!$id)
	{
		http_response_code(500);
		echo false;
		return;
	}
	// Return purchase
	echo $id;

?>

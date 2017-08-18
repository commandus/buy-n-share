<?php
	require "buynshare.php";

	// get user, fridge identifiers
	$user_id = $_GET['user_id'];
	$fridge_id = $_GET['fridge_id'];

	// Remove fridge user and get final balance
	$balance_array = rm_fridgeuser(
		$user_id,
		$fridge_id
	);

	if (!$balance_array)
	{
		http_response_code(500);
		header('Content-Type: text/plain');
		echo 'Remove error: ' . pg_last_error();
	}

	// Return true or false
	header('Content-Type: text/plain');
	echo fb_payments($balance_array);

?>

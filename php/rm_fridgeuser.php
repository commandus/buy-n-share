<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');
	// get user, fridge identifiers
	if (isset($_REQUEST['user_id']))
		$user_id = $_REQUEST['user_id'];
	else
		$user_id = 0;
	if (isset($_REQUEST['fridge_id']))
		$fridge_id = $_REQUEST['fridge_id'];
	else
		$fridge_id = 0;

	// Remove fridge user and get final balance
	$balance_array = rm_fridgeuser(
		$user_id,
		$fridge_id
	);

	if (!$balance_array)
	{
		http_response_code(500);
		return false;
	}

	// Return balance
	echo fb_payments($balance_array);

?>

<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');
	// get user, fridge identifiers
	$opt = getopt("", array('user_id:', 'fridge_id:'));
	$user_id = getOption('user_id', $opt, 0);
	$fridge_id = getOption('fridge_id', $opt, 0);

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

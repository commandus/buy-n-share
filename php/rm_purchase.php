<?php
	require "buynshare.php";

	// get purchase identifier
	$purchase_id = $_GET['purchase_id'];

	// Remove purchase by identifier
	$done = rm_purchase(
		$purchase_id
	);

	if (!$done)
	{
		http_response_code(500);
		header('Content-Type: text/plain');
		echo 'Remove error: ' . pg_last_error();
	}

	// Return true or false
	header('Content-Type: text/plain');
	echo $done;
?>

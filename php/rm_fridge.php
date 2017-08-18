<?php
	require "buynshare.php";

	// get fridge identifier
	$fridge_id = $_GET['fridge_id'];

	// Remove fridge
	$done = rm_fridge(
		$fridge_id
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

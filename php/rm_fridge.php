<?php
	require "buynshare.php";
	header('Content-Type: text/plain');
	// get fridge identifier
	$opt = getopt("", array('fridge_id:'));
	$fridge_id = getOption('fridge_id', $opt, 0);
	// Remove fridge
	$done = rm_fridge(
		$fridge_id
	);

	if (!$done)
		http_response_code(500);
	// Return true or false
	echo $done;

?>

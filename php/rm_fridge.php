<?php
	require "buynshare.php";
	header('Content-Type: text/plain');
	// get fridge identifier
	$options = array('fridge_id');
	$opt = getopt("", $options);
	$fridge_id = getOption($options[0], $opt, 0);
	$purchases  = ls_userfridge($user_id);
	// Remove fridge
	$done = rm_fridge(
		$fridge_id
	);

	if (!$done)
		http_response_code(500);
	// Return true or false
	echo $done;

?>

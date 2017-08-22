<?php
	require "buynshare.php";
	header('Content-Type: text/plain');
	// get purchase identifier
	$options = array('purchase_id');
	$opt = getopt("", $options);
	$purchase_id = getOption($options[0], $opt, 0);
	// Remove purchase by identifier
	$done = rm_purchase(
		$purchase_id
	);
	if (!$done)
		http_response_code(500);
	// Return true or false
	echo $done;
?>

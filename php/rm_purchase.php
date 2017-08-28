<?php
	require "buynshare.php";
	header('Content-Type: text/plain');
	// get purchase identifier
	$opt = getopt("", array('purchase_id:'));
	$purchase_id = getOption('purchase_id', $opt, 0);
	// Remove purchase by identifier
	$done = rm_purchase(
		$purchase_id
	);
	if (!$done)
		http_response_code(500);
	// Return true or false
	echo $done;
?>

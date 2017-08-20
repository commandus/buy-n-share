<?php
	require "buynshare.php";
	header('Content-Type: text/plain');
	// get purchase identifier
	if (isset($_REQUEST['purchase_id']))
		$purchase_id = $_REQUEST['purchase_id'];
	else
		$purchase_id = 0;

	// Remove purchase by identifier
	$done = rm_purchase(
		$purchase_id
	);

	if (!$done)
		http_response_code(500);
	// Return true or false
	echo $done;
?>

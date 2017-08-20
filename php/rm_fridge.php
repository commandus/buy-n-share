<?php
	require "buynshare.php";
	header('Content-Type: text/plain');
	// get fridge identifier
	if (isset($_REQUEST['fridge_id']))
		$fridge_id = $_REQUEST['fridge_id'];
	else
		$fridge_id = 0;
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

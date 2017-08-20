<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');
	// List of purchases
		if (isset($_REQUEST['user_id']))
			$user_id = $_REQUEST['user_id'];
		else
			$user_id = 0;	$purchases  = ls_userfridge($user_id);
	echo fb_userfridges($purchases);
?>

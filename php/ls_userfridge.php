<?php
	require "buynshare.php";

	// List of purchases
	$user_id = $_GET['user_id'];
	$purchases  = ls_userfridge($user_id);

	header('Content-Type: application/octet-stream');
	echo fb_userfridges($purchases);
?>

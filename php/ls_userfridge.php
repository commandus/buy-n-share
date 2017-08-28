<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');
	$opt = getopt("", array("user_id:"));
	$user_id = getOption("user_id", $opt, 0);
	// List of my fridges
	$r  = ls_userfridge($user_id);
	echo fb_userfridges($r);
?>

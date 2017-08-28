<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');
	$opt = getopt("", array("user_id:"));
	$user_id = getOption("user_id", $opt, 0);
	// List of my fridges
	$f = ls_userfridge($user_id);
	$r = fb_userfridges($f);
	if (!$r)
	{
		http_response_code(500);
		echo false;
		return;
	}
	else
		echo $r;
?>

<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');
	$options = array('user_id');
	$opt = getopt("", $options);
	$user_id = getOption($options[0], $opt, 0);
	// List of my fridges
	$r  = ls_userfridge($user_id);
	echo fb_userfridges($r);
?>

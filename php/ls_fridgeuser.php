<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');
	$opt = getopt("", array('fridge_id:'));
	$fridge_id = getOption('fridge_id', $opt, 0);
	// List of fridge users
	$fridgeusers = ls_fridgeuser($fridge_id);
	echo fb_fridgeusers($fridgeusers);
?>

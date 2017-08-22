<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');
	$options = array('fridge_id');
	$opt = getopt("", $options);
	$fridge_id = getOption($options[0], $opt, 0);
	// List of fridge users
	$fridgeusers = ls_fridgeuser($fridge_id);
	echo fb_fridgeusers($fridgeusers);
?>

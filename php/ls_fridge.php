<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');

	$opt = getopt("", array('locale:'));
	$locale = getOption('locale', $opt, 'ru');

	// List of fridges
	$fridges = ls_fridge($locale);
	echo fb_fridges( $fridges);

?>

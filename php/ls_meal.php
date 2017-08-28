<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');
	$opt = getopt("", array('locale:'));
	$locale = getOption('locale', $opt, 'ru');
	// List of meal
	$meals = ls_meal($locale);
	echo fb_meals($meals);
?>

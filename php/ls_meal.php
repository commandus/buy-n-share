<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');
	$options = array('locale');
	$opt = getopt("", $options);
	$locale = getOption($options[0], $opt, 'ru');
	// List of meal
	$meals = ls_meal($locale);
	echo fb_meals($meals);
?>

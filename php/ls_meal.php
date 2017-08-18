<?php
	require "buynshare.php";

	// List of meal
	$locale = $_GET['locale'];
	$meals = ls_meal($locale);

	header('Content-Type: application/octet-stream');
	echo fb_meals($meals);
?>

<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');
	// List of meal
	if (isset($_REQUEST['locale']))
		$locale = $_REQUEST ['locale'];
	else
		$locale = 'ru';
	$meals = ls_meal($locale);
	echo fb_meals($meals);
?>

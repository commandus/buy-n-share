<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');
	// List of fridges
	if (isset($_REQUEST['locale']))
		$locale = $_REQUEST ['locale'];
	else
		$locale = 'ru';
	$fridges = ls_fridge($locale);
	echo fb_fridges( $fridges);

?>

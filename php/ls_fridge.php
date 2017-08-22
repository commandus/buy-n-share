<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');

	$options = array('locale');
	$opt = getopt("", $options);
	$locale = getOption($options[0], $opt, 'ru');

	// List of fridges
	if (isset($_REQUEST['locale']))
		$locale = $_REQUEST ['locale'];
	else
		$locale = 'ru';
	$fridges = ls_fridge($locale);
	echo fb_fridges( $fridges);

?>

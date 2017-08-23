<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');
	$options = array('user_id', 'fridge_id');
	$opt = getopt("", $options);
	$user_id = getOption($options[0], $opt, 0);
	$fridge_id = getOption($options[1], $opt, false);
	if ($fridge_id <= 0)
		$fridge_id = false;
	// List of purchases
	$purchases  = ls_purchase($user_id, $fridge_id);
	echo fb_purchases($purchases);
?>

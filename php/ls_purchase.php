<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');
	$opt = getopt("", array('user_id:', 'fridge_id:'));
	$user_id = getOption('user_id', $opt, false);
	$fridge_id = getOption('fridge_id', $opt, false);
	if ($fridge_id <= 0)
		$fridge_id = false;
	// List of purchases
	$purchases  = ls_purchase($user_id, $fridge_id);
	echo fb_purchases($purchases);
?>

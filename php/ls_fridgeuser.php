<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');
	// List of fridge users
	if (isset($_REQUEST['fridge_id']))
		$fridge_id = $_REQUEST ['fridge_id'];
	else
		$fridge_id = 0;
	$fridgeusers = ls_fridgeuser($fridge_id);
	echo fb_fridgeusers($fridgeusers);
?>

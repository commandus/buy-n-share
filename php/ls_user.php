<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');
	$opt = getopt("", array('locale:'));
	$locale = getOption('locale', $opt, 'ru');
	// User list
	$users = ls_user($locale);
	echo fb_users( $users);

?>

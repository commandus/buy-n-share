<?php
	require "buynshare.php";
	header('Content-Type: application/octet-stream');
	$options = array('locale');
	$opt = getopt("", $options);
	$locale = getOption($options[0], $opt, 'ru');
	// User list
	$users = ls_user($locale);
	echo fb_users( $users);

?>

<?php
require "buynshare.php";

// get user identifier
$user_id = $_GET['user_id'];
$purchase_id = $_GET['purchase_id'];

// Remove vote
$done = rm_vote(
	$user_id,
	$purchase_id
);

if (!$done)
{
	http_response_code(500);
	header('Content-Type: text/plain');
	echo 'Remove error: ' . pg_last_error();
}

// Return purchase
header('Content-Type: text/plain');
echo $done;

?>

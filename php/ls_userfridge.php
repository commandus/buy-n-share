<?php
require "buynshare.php";

// List of purchases
$user_id = $_GET['user_id'];
$purchases  = ls_purchase($user_id);

header('Content-Type: application/octet-stream');
echo fb_purchases($purchases);

?>

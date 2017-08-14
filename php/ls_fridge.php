<?php
require "buynshare.php";

// List of fridges
$locale = "ru";
$fridges = ls_fridge($locale);

header('Content-Type: application/octet-stream');
echo fb_fridges( $fridges);

?>

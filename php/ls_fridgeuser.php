<?php
require "buynshare.php";

// List of fridge users
$fridge_id = $_GET['fridge'];
// $fridge_id = 1;
$fridgeusers = ls_fridgeuser($fridge_id);

header('Content-Type: application/octet-stream');
echo fb_fridgeusers($fridgeusers);

?>

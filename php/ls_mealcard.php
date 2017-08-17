<?php
require "buynshare.php";

// List of purchases
$fridge_id = $_GET['fridge_id'];
$purchases  = ls_mealcard($fridge_id);

header('Content-Type: application/octet-stream');
echo fb_mealcards($purchases);

?>

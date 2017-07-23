<?php
require "buynshare.php";

$cn = 'Аааа';
$key = generateRandomString();
$locale = 'ru';
$lat = 62.024785;
$lon = 129.7234323;
$alt = 509;


$id = add_user(
  $cn,
  $key,
  $locale,
  $lat,
  $lon,
  $alt
);

$r = fb_user(
  $id,
  $cn,
  $key,
  $locale,
  $lat,
  $lon,
  $alt
);

echo $r;

?>

<?php
require "buynshare.php";

// Read user
$bb = Google\FlatBuffers\ByteBuffer::wrap(file_get_contents('php://input'));
$u = bs\User::getRootAsUser($bb);

// print $u->getId() . " " . $u->getLocale() . " " . $u->getGeo()->getLat() . " " . $u->getGeo()->getLon() . " " . $u->getGeo()->getAlt();

// Create  a new user
$id = add_user(
  $u->getCn(),
  $u->getKey(),
  $u->getLocale(),
  $u->getGeo()->getLat(),
  $u->getGeo()->getLon(),
  $u->getGeo()->getAlt()
);


// Return id, key
header('Content-Type: application/octet-stream');
echo fb_user(
  $id,
  $u->getCn(),
  $u->getKey(),
  $u->getLocale(),
  $u->getGeo()->getLat(),
  $u->getGeo()->getLon(),
  $u->getGeo()->getAlt()
);

?>

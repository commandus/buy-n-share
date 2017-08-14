<?php
require "buynshare.php";

// Read user

$bb = Google\FlatBuffers\ByteBuffer::wrap(file_get_contents('php://input'));

try
{
	$u = bs\User::getRootAsUser($bb);
}
	catch(Exception $e) 
{
	http_response_code(500);
	header('Content-Type: text/plain');
	echo "Error: no input data\n";
	return;
}

// Create  a new user
$id = add_user(
  $u->getCn(),
  $u->getKey(),
  $u->getLocale(),
  $u->getGeo()->getLat(),
  $u->getGeo()->getLon(),
  $u->getGeo()->getAlt()
);

if (!$id)
{
	http_response_code(500);
	header('Content-Type: text/plain');
	echo 'Add error: ' . pg_last_error();
}

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

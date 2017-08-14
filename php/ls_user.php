<?php
require "buynshare.php";

// Read filters
/* $bb = Google\FlatBuffers\ByteBuffer::wrap(file_get_contents('php://input'));

try
{
	$u = bs\User::getRootAsUser($bb);
}
	catch(Exception $e) 
{
	header('Content-Type: text/plain');
	echo "Error: no user\n";
	return;
}
print $u->getId() . " " . $u->getLocale() . " " . $u->getGeo()->getLat() . " " . $u->getGeo()->getLon() . " " . $u->getGeo()->getAlt();
*/


// Return id, key
header('Content-Type: application/octet-stream');
echo ls_user
(
  "ru"
);

?>

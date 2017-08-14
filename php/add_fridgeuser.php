<?php
require "buynshare.php";

// Read fridge user

$bb = Google\FlatBuffers\ByteBuffer::wrap(file_get_contents('php://input'));

$fridge_id = 1;
$user_id = 66;

try
{
	$f = bs\FridgeUser::getRootAsFridgeUser($bb);
}
	catch(Exception $e) 
{
	http_response_code(500);
	header('Content-Type: text/plain');
	echo "Error: no input data\n";
	return;
}

// Create  a new fridge
$id = add_fridgeuser(
  $fridge_id,
  $user_id,
  $f->getStart(),
  $f->getFinish(),
  $f->getBalance()
);

if (!$id)
{
	http_response_code(500);
	header('Content-Type: text/plain');
	echo 'Add error: ' . pg_last_error();
}

// Return id, key
header('Content-Type: application/octet-stream');
echo fb_fridgeuser(
  $fridge_id,
  $user_id,
  $f->getStart(),
  $f->getFinish(),
  $f->getBalance()
);

?>

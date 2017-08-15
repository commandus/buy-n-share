<?php
require "buynshare.php";

// Read fridge user

$bb = Google\FlatBuffers\ByteBuffer::wrap(file_get_contents('php://input'));

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

$start = time(); // $f->getStart();
$finish = $f->getFinish();

// Create  a new fridge user
$id = add_fridgeuser(
  $f->getFridgeid(),
  $f->getUser()->getId(),
  $start,
  $finish,
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
  $f->getFridgeid(),
  $f->getUser()->getId(),
  $start,
  $finish,
  $f->getBalance()
);

?>

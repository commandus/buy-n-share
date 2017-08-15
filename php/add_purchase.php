<?php
require "buynshare.php";

// Read purchase
$bb = Google\FlatBuffers\ByteBuffer::wrap(file_get_contents('php://input'));

try
{
	$f = bs\Purchase::getRootAsPurchase($bb);
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

$vs = array();
for ($i = 0; $i < $f->getVotesLength(); $i++)
{
  array_push($vs, $f->getVotes($i));
}

// Create a new purchase
$id = add_purchase(
  $f->getUserid(),
  $f->getFridgeid(),
  $f->getMeal()->getId(),
  $f->getCost(),
  $start,
  $finish,
  $vs
);

if (!$id)
{
	http_response_code(500);
	header('Content-Type: text/plain');
	echo 'Add error: ' . pg_last_error();
}

// Return purchase
header('Content-Type: application/octet-stream');
echo fb_purchase(
  $id,
  $f->getUserid(),
  $f->getFridgeid(),
  $f->getMeal()->getId(),
  $f->getCost(),
  $start,
  $finish,
  $vs
);

?>

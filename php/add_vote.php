<?php
require "buynshare.php";

// get user identifier
$user_id = $_GET['user_id'];

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

// Add vote
$id = add_vote(
	$user_id,
	$purchase_id
);

if (!$id)
{
	http_response_code(500);
	header('Content-Type: text/plain');
	echo 'Add error: ' . pg_last_error();
}

// Return purchase
header('Content-Type: text/plain');
echo $id;

?>

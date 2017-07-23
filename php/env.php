<?php

function init()
{
	return pg_connect("host=127.0.0.1 dbname=commandus_buynshare user=commandus_buynshare1 password=gjregfirf2017");
}

function done($conn)
{
	pg_close($conn);
}

?>

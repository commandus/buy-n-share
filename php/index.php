<?php
	require "env.php";
	phpinfo();
/*
    $conn = init();
    $locale ="ru";
    $q = pg_query_params($conn, 
		"SELECT id, cn, '' as key, locale, lat, lon, alt FROM \"user\" WHERE (locale = $1) ORDER BY id", array($locale)
    );
	if (!$q)
	{
	    done($conn);
		return false;
	}
	$r = array();
	while($row = pg_fetch_row($q))
	{
		array_push($r, $row);
	}
    pg_free_result($q);
    done($conn);
    echo json_encode($r);
*/

?>

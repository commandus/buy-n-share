<?php
	/**
	* @brief Calc balance for user of the fridge: 
	* @return array of $fridgeid, $userid, $start, $total
	* @see calc_pg_fridge()
	* @see rm_fridgeuser()
	*/
	function calc_pg_user
	(
		$conn,
		$fridge_id,
		$user_id
	)
	{
		if (!$conn)
			return false;
		$q = pg_query_params($conn, 
			"SELECT fu.user_id FROM \"fridgeuser\" fu WHERE fu.fridge_id = $1 AND  fu.user_id = $2 ORDER BY id", array($fridge_id, $user_id)
		);
		if (!$q)
			return false;
		// check does user exists in the fridge
		$row = pg_fetch_row($q);
		if (!$row)
			return false;
		
		$r = array();
		$start = time();
		//-------------------------------- VVV INSERT BRAIN HERE VVV --------------------------------

		$total = 0;
		
		//-------------------------------- ^^^ INSERT BRAIN HERE ^^^ --------------------------------
		array_push($r, $fridge_id);
		array_push($r, $user_id);
		array_push($r, $start);
		array_push($r, $total);
		return $r;
	}

	/**
	* @brief Calc balance for each fridge user 
	* @return array of fridge users balance 
	* @see calc_pg_user()
	*/
	function calc_pg_fridge
	(
		$conn,
		$fridge_id
	)
	{
		if (!$conn)
			return false;
		$r = array();

		$q = pg_query_params($conn, 
			"SELECT fu.user_id FROM \"fridgeuser\" fu WHERE fu.fridge_id = $1 ORDER BY id", array($fridge_id)
		);
		if (!$q)
			return false;
		$r = array();
		while ($row = pg_fetch_row($q))
		{
			array_push($r, calc_pg_user($conn, $fridge_id, $row[0]));
		}
		pg_free_result($q);

		return $r;
	}

?>

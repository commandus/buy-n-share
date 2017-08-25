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
		
		$start = time();
		$r1 = array();
		//-------------------------------- VVV INSERT BRAIN HERE VVV --------------------------------

		// Remember, not user to user, but user to the fridge!!!
		// one user-fridge-total
		$total = 0;
		array_push($r1, $fridge_id);
		array_push($r1, $user_id);
		array_push($r1, $start);
		array_push($r1, $total);
		//-------------------------------- ^^^ INSERT BRAIN HERE ^^^ --------------------------------
		return $r1;
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
			$c = calc_pg_user($conn, $fridge_id, $row[0]);
			if ($c)
				array_push($r, $c);
		}
		pg_free_result($q);

		return $r;
	}

?>

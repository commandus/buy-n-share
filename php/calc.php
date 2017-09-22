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
		//-------------------------------- ^^^ INSERT BRAIN HERE ^^^ --------------------------------

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
		$total = 22;
		//-------------------------------- ^^^ INSERT BRAIN HERE ^^^ --------------------------------
		return $total;
	}


	/**
	* @brief Calc balance for user of the fridge: 
	* @return array of $fridgeid, $userid, $start, $total
	* @see calc_pg_fridge()
	* @see rm_fridgeuser()
	*/
	function calc_pg_user1
	(
		$conn,
		$fridge_id,
		$user_id
	)
	{
		$r = calc_pg_user(
			$conn,
			$fridge_id,
			$user_id);
		return $r;
	}
?>

<?php
	/**
	* @brief Calc user total amount spent on fridge
	* @return total sum double precision
	* @see calc_pg_user()
	*/
	function get_user_purchase_total($conn, $fridge_id, $user_id)
	{
		if (!$conn)
			return 0.0;
		$q = pg_query_params($conn, 
			"SELECT sum(p.cost) FROM \"purchase\" p WHERE p.fridge_id = $1 AND  p.user_id = $2", array($fridge_id, $user_id)
		);
		if (!$q)
			return 0.0;
		$row = pg_fetch_row($q);
		if (!$row)
			return 0.0;
		return $row[0];
	}


	/**
	* @brief Calc user total amount voted on fridge
	* @return total sum double precision
	* @see calc_pg_user()
	*/
	function get_user_voted_total($conn, $fridge_id, $user_id)
	{
		if (!$conn)
			return 0.0;
		$q = pg_query_params($conn, 
			"SELECT SUM(p.cost / purchase_votes(p.id))
			FROM \"purchase\" p
			WHERE p.id IN 
				(SELECT p.id FROM \"purchase\" p, \"vote\" v 
				WHERE p.fridge_id = $1 AND  p.user_id = $2
				AND v.purchase_id = p.id)", array($fridge_id, $user_id)
		);
		if (!$q)
			return 0.0;
		$row = pg_fetch_row($q);
		if (!$row)
			return 0.0;
		return $row[0];
	}

	/**
	* @brief Calc balance for user of the fridge: 
	* @return total sum or false if parameters are wrong
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
		// Remember, not user to user, but user to the fridge!!!
		// get my purchase total
		$user_purchase_total = get_user_purchase_total($conn, $fridge_id, $user_id);
		// get meal cost total
		$user_spent_total = get_user_voted_total($conn, $fridge_id, $user_id);
		// one user-fridge-total
		return $user_purchase_total - $user_spent_total;
	}

?>

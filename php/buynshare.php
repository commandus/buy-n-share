<?php
	require "Google/FlatBuffers/Constants.php";
	require "Google/FlatBuffers/ByteBuffer.php";
	require "Google/FlatBuffers/FlatbufferBuilder.php";
	require "Google/FlatBuffers/Table.php";
	require "Google/FlatBuffers/Struct.php";

	require "bs/FridgeMealCards.php";
	require "bs/FridgePurchases.php";
	require "bs/FridgeUsers.php";
	require "bs/MealCard.php";
	require "bs/MealCards.php";
	require "bs/Purchase.php";
	require "bs/Purchases.php";
	require "bs/Payment.php";
	require "bs/Payments.php";
	require "bs/User.php";
	require "bs/Users.php";
	require "bs/Fridge.php";
	require "bs/Fridges.php";
	require "bs/FridgeUser.php";
	require "bs/Geo.php";
	require "bs/Meal.php";
	require "bs/Meals.php";
	require "bs/UserFridges.php";
	require "bs/UserPurchases.php";

	require "env.php";
	require "calc.php";

	// ------------------------------------ Serialization routines ---------------------------------

	/**
	* @brief Serialize user
	*/
	function fb_user(
		$id,
		$cn,
		$key,
		$locale,
		$lat,
		$lon,
		$alt
	)
	{
		$builder = new Google\FlatBuffers\FlatbufferBuilder(0);
		$scn = $builder->createString($cn);
		$skey = $builder->createString($key);
		$slocale = $builder->createString($locale);
		bs\User::startUser($builder);
		bs\User::addId($builder, $id);
		bs\User::addCn($builder, $scn);
		bs\User::addKey($builder, $skey);
		bs\User::addLocale($builder, $slocale);
		bs\User::addGeo($builder, bs\Geo::createGeo($builder, $lat, $lon, $alt));
		$u = bs\User::EndUser($builder);
		$builder->Finish($u);
		return $builder->dataBuffer()->data();
	}

	/**
	* @brief Serialize fridge
	*/
	function fb_fridge(
		$id,
		$cn,
		$key,
		$locale,
		$lat,
		$lon,
		$alt
	)
	{
		$builder = new Google\FlatBuffers\FlatbufferBuilder(0);
		$scn = $builder->createString($cn);
		$skey = $builder->createString($key);
		$slocale = $builder->createString($locale);
		bs\Fridge::startFridge($builder);
		bs\Fridge::addId($builder, $id);
		bs\Fridge::addCn($builder, $scn);
		bs\Fridge::addKey($builder, $skey);
		bs\Fridge::addLocale($builder, $slocale);
		bs\Fridge::addGeo($builder, bs\Geo::createGeo($builder, $lat, $lon, $alt));
		$u = bs\Fridge::EndFridge($builder);
		$builder->Finish($u);
		return $builder->dataBuffer()->data();
	}

	/**
	* @brief Serialize fridge user
	*/
	function fb_fridgeuser(
		$fridge_id,
		$user_id,
		$start,
		$finish,
		$balance
	)
	{
		$builder = new Google\FlatBuffers\FlatbufferBuilder(0);

		$scn = $builder->createString("");
		$skey = $builder->createString("");
		$slocale = $builder->createString("");
		bs\User::startUser($builder);
		bs\User::addId($builder, $user_id);
		bs\User::addCn($builder, $scn);
		bs\User::addKey($builder, $skey);
		bs\User::addLocale($builder, $slocale);
		bs\User::addGeo($builder, bs\Geo::createGeo($builder, 0.0, 0.0, 0.0));
		$user = bs\User::EndUser($builder);

		bs\FridgeUser::startFridgeUser($builder);
		bs\FridgeUser::addFridgeid($builder, $fridge_id);
		bs\FridgeUser::addUser($builder, $user);
		bs\FridgeUser::addStart($builder, $start);
		bs\FridgeUser::addFinish($builder, $finish);
		bs\FridgeUser::addBalance($builder, $balance);
		$fu = bs\FridgeUser::EndFridgeUser($builder);
		$builder->Finish($fu);
		return $builder->dataBuffer()->data();
	}

	/**
	* @brief Serialize meal
	*/
	function fb_meal(
		$id,
		$cn,
		$locale
	)
	{
		$builder = new Google\FlatBuffers\FlatbufferBuilder(0);
		$scn = $builder->createString($cn);
		$slocale = $builder->createString($locale);
		bs\Meal::startMeal($builder);
		bs\Meal::addId($builder, $id);
		bs\Meal::addCn($builder, $scn);
		bs\Meal::addLocale($builder, $slocale);
		$u = bs\Meal::EndMeal($builder);
		$builder->Finish($u);
		return $builder->dataBuffer()->data();
	}

	/**
	* @brief Serialize meal
	*/
	function fb_purchase(
		$id,
		$user_id,
		$fridge_id,
		$meal_id,
		$cost,
		$start,
		$finish,
		&$votes
	)
	{
		$builder = new Google\FlatBuffers\FlatbufferBuilder(0);
		$meal = bs\Meal::createMeal($builder, $meal_id, 0, 0);
		$vvotes = bs\Votes::CreateVotesVector($builder, $votes);
		$p = bs\Purchase::createPurchase($id, $user_id, $fridge_id, $meal, $cost, $start, $finish, $vvotes);
		$builder->Finish($p);
		return $builder->dataBuffer()->data();
	}

	/**
	* @brief Serialize users array
	*/
	function fb_users
	(
		&$users
	)
	{
		$builder = new Google\FlatBuffers\FlatbufferBuilder(0);
		
		$ua = array();
		foreach ($users as $user)
		{
			$scn = $builder->createString($user[1]);
			$skey = $builder->createString($user[2]);
			$slocale = $builder->createString($user[3]);

			bs\User::startUser($builder);
			bs\User::addId($builder, $user[0]);
			bs\User::addCn($builder, $scn);

			bs\User::addKey($builder, $skey);
			bs\User::addLocale($builder, $slocale);
			bs\User::addGeo($builder, bs\Geo::createGeo($builder, $user[4], $user[5], $user[6]));

			$u = bs\User::EndUser($builder);
			array_push($ua, $u);
		}
		$uv = bs\Users::CreateUsersVector($builder, $ua);
		bs\Users::startUsers($builder);
		bs\Users::addUsers($builder, $uv);
		$uu = bs\Users::EndUsers($builder);
		$builder->Finish($uu);
		return $builder->dataBuffer()->data();
	}

	/**
	* @brief Serialize fridge array
	*/
	function fb_fridges
	(
		&$fridges
	)
	{
		$builder = new Google\FlatBuffers\FlatbufferBuilder(0);
		
		$fa = array();
		foreach ($fridges as $fridge)
		{
			$scn = $builder->createString($fridge[1]);
			$skey = $builder->createString($fridge[2]);
			$slocale = $builder->createString($fridge[3]);

			bs\Fridge::startFridge($builder);
			bs\Fridge::addId($builder, $fridge[0]);
			bs\Fridge::addCn($builder, $scn);

			bs\Fridge::addKey($builder, $skey);
			bs\Fridge::addLocale($builder, $slocale);
			bs\Fridge::addGeo($builder, bs\Geo::createGeo($builder, $fridge[4], $fridge[5], $fridge[6]));

			$f = bs\Fridge::EndFridge($builder);
			array_push($fa, $f);
		}
		$fv = bs\Fridges::CreateFridgesVector($builder, $fa);
		bs\Fridges::startFridges($builder);
		bs\Fridges::addFridges($builder, $fv);
		$ff = bs\Fridges::EndFridges($builder);
		$builder->Finish($ff);
		return $builder->dataBuffer()->data();
	}

	/**
	* @brief Serialize fridge users array
	*/
	function fb_fridgeusers
	(
		&$fridgeusers
	)
	{
		$builder = new Google\FlatBuffers\FlatbufferBuilder(0);
		
		$fa = array();
		foreach ($fridgeusers as $fridgeuser)
		{
			$scn = $builder->createString($fridgeuser[3]);
			$skey = $builder->createString($fridgeuser[4]);
			$slocale = $builder->createString($fridgeuser[5]);
			bs\User::startUser($builder);
			bs\User::addId($builder, $fridgeuser[2]);
			bs\User::addCn($builder, $scn);
			bs\User::addKey($builder, $skey);
			bs\User::addLocale($builder, $slocale);
			bs\User::addGeo($builder, bs\Geo::createGeo($builder, $fridgeuser[6], $fridgeuser[7], $fridgeuser[8]));
			$user = bs\User::EndUser($builder);
		
			bs\FridgeUser::startFridgeUser($builder);
			bs\FridgeUser::addFridgeid($builder, $fridgeuser[1]);
			bs\FridgeUser::addUser($builder, $user);
			bs\FridgeUser::addStart($builder, $fridgeuser[9]);
			bs\FridgeUser::addFinish($builder, $fridgeuser[10]);
			bs\FridgeUser::addBalance($builder, $fridgeuser[11]);
			$fu = bs\FridgeUser::EndFridgeUser($builder);
			$builder->Finish($fu);
		
			array_push($fa, $fu);
		}
		$fv = bs\FridgeUsers::CreateFridgeUsersVector($builder, $fa);
		bs\FridgeUsers::startFridgeUsers($builder);
		bs\FridgeUsers::addFridgeUsers($builder, $fv);
		$ff = bs\FridgeUsers::EndFridgeUsers($builder);
		$builder->Finish($ff);
		return $builder->dataBuffer()->data();
	}

	/**
	* @brief Serialize meal array
	*/
	function fb_meals
	(
		&$meals
	)
	{
		$builder = new Google\FlatBuffers\FlatbufferBuilder(0);
		
		$ma = array();
		foreach ($meals as $meal)
		{
			$scn = $builder->createString($meal[1]);
			$slocale = $builder->createString($meal[2]);

			bs\Meal::startFridge($builder);
			bs\Meal::addId($builder, $meal[0]);
			bs\Meal::addCn($builder, $scn);
			bs\Meal::addLocale($builder, $slocale);

			$f = bs\Fridge::EndFridge($builder);
			array_push($ma, $f);
		}
		$mv = bs\Meals::CreateMealsVector($builder, $ma);
		bs\Meals::startMeals($builder);
		bs\Meals::addMeals($builder, $mv);
		$ff = bs\Meals::EndMeals($builder);
		$builder->Finish($ff);
		return $builder->dataBuffer()->data();
	}


	/**
	* @brief Serialize payments array
	* @param $balance_array Each item is [$fridgeid, $userid, $start, $total]
	*/
	function fb_payments
	(
		&$user_payments
	)
	{
		$builder = new Google\FlatBuffers\FlatbufferBuilder(0);
		
		$pa = array();
		foreach ($user_payments as $user_payment)
		{
			$p = bs\Payment::createPayment($builder, $user_payment[0], $user_payment[1], $user_payment[2], $user_payment[3]);
			array_push($pa, $p);
		}
		$pv = bs\Meals::CreatePaymentsVector($builder, $pa);
		bs\Payments::startPayments($builder);
		bs\Payments::addPayments($builder, $pv);
		$ff = bs\Payments::EndPayments($builder);
		$builder->Finish($ff);
		return $builder->dataBuffer()->data();
	}

	// ------------------------------------ Helper routines ---------------------------------

	function getOption(
		$name,
		&$argv,
		$default
	) 
	{
		if (isset($_REQUEST[$name]))
			$r = $_REQUEST [$name];
		else
		{
			if (array_key_exists($name, $argv))
			{
				$r = $argv[$name];
			}
			else 
			{
				$r = $default;
			}
		}
		return $r;
	}

	/**
	* @brief Generate random "password" string
	* @link https://stackoverflow.com/questions/4356289/php-random-string-generator
	*/
	function generateRandomString(
		$length = 10
	) 
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) 
		{
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	/**
	* @brief Helper function prints user for debug
	*/
	function print_user
	(
		$b
	)
	{
		$buf = Google\FlatBuffers\ByteBuffer::wrap($b);
		$u = bs\User::getRootAsUser($buf);
		print $u->getId() . " " . $u->getCn() . " " . $u->getKey() . " " . $u->getLocale() . " " . $u->getGeo()->getLat() . " " . $u->getGeo()->getLon() . " " . $u->getGeo()->getAlt();
	}

	// ------------------------------------ Add ---------------------------------

	/**
	* @brief Add a new user
	*/
	function add_user
	(
		$cn,
		$key,
		$locale,
		$lat,
		$lon,
		$alt
	)
	{
		$conn = init();
		$q = pg_query_params($conn, 
			'INSERT INTO "user" (cn, key, locale, lat, lon, alt) VALUES ($1, $2, $3, $4, $5, $6) RETURNING id', 
			array($cn, $key, $locale, $lat, $lon, $alt)
		);
		$r = pg_fetch_row($q);
		if (!$q)
		{
			done($conn);
			return false;
		}
		pg_free_result($q);
		done($conn);
		return $r[0];
	}

	/**
	* @brief Add a new fridge
	*/
	function add_fridge
	(
		$cn,
		$key,
		$locale,
		$lat,
		$lon,
		$alt
	)
	{
		$conn = init();
		$q = pg_query_params($conn, 
			'INSERT INTO "fridge" (cn, key, locale, lat, lon, alt) VALUES ($1, $2, $3, $4, $5, $6) RETURNING id', 
			array($cn, $key, $locale, $lat, $lon, $alt)
		);
		$r = pg_fetch_row($q);
		if (!$q)
		{
			done($conn);
			return false;
		}
		pg_free_result($q);
		done($conn);
		return $r[0];
	}

	/**
	* @brief Add anew fridge user. Fridge and user must exists.
	*/
	function add_fridgeuser
	(
		$fridge_id,
		$user_id,
		$start,
		$finish,
		$balance
	)
	{
		$conn = init();
		$q = pg_query_params($conn, 
			'INSERT INTO "fridgeuser" (fridge_id, user_id, start, finish, balance) VALUES ($1, $2, $3, $4, $5) RETURNING id', 
			array($fridge_id, $user_id, $start, $finish, $balance)
		);
		$r = pg_fetch_row($q);
		if (!$q)
		{
			done($conn);
			return false;
		}
		pg_free_result($q);
		done($conn);
		return $r[0];
	}

	/**
	* @brief Add meal
	*/
	function add_meal
	(
		$cn,
		$locale
	)
	{
		$conn = init();
		$q = pg_query_params($conn, 
			'SELECT id FROM "meal" WHERE cn = $1 AND locale = $2', array($cn, $locale)
		);
		if ($q)
		{
			$r = pg_fetch_row($q);
			if ($r)
				return $r[0];
		}
		
		$q = pg_query_params($conn, 
			'INSERT INTO "meal" (cn, locale) VALUES ($1, $2) RETURNING id', 
			array($cn, $locale)
		);
		if (!$q)
		{
			done($conn);
			return false;
		}

		$r = pg_fetch_row($q);
		if (!$r)
		{
			done($conn);
			return false;
		}
		
		pg_free_result($q);
		done($conn);
		return $r[0];
	}

	/**
	* @brief Add meal card
	*/
	function add_mealcard
	(
		$fridge_id,
		$meal_id,
		$qty
	)
	{
		$conn = init();
		$q = pg_query_params($conn, 
			'SELECT id FROM "mealcard" WHERE fridge_id = $1 AND meal_id = $2', array($fridge_id, $meal_id)
		);
		if ($q)
		{
			$r = pg_fetch_row($q);
			if ($r)
			{
				$q = pg_query_params($conn, 
					'UPDATE  "meal" SET fridge_id = $1, meal_id = $2, qty = $3', array($fridge_id, $meal_id, $qty)
				);
				if (!$q)
				{
					done($conn);
					return false;
				}
				return $r[0];
			}
		}
		
		$q = pg_query_params($conn, 
			'INSERT INTO "meal" (fridge_id, meal_id, qty) VALUES ($1, $2, $3) RETURNING id', array($fridge_id, $meal_id, $qty)
		);
		if (!$q)
		{
			done($conn);
			return false;
		}

		$r = pg_fetch_row($q);
		if (!$r)
		{
			done($conn);
			return false;
		}
		
		pg_free_result($q);
		done($conn);
		return $r[0];
	}

	/**
	* @brief Add purchase and votes
	* @param votes array- user id list, true- all, false- none
	*/
	function add_purchase
	(
		$user_id,
		$fridge_id,
		$meal_id,
		$cost,
		$start,
		$finish,
		$votes
	)
	{
		$conn = init();
		$q = pg_query_params($conn, 
			'INSERT INTO "purchase" (user_id, fridge_id, meal_id, cost, start, finish) VALUES ($1, $2, $3, $4, $5, $6) RETURNING id', 
			array($user_id, $fridge_id, $meal_id, $cost, $start, $finish)
		);
		$r = pg_fetch_row($q);
		if (!$q)
		{
			done($conn);
			return false;
		}

		$purchase_id = $r[0];
		if (is_array($votes))
		{
			for ($i = 0; $i < count($votes); $i++)
			{
				$q = pg_query_params($conn, 
					'INSERT INTO "vote" (purchase_id, user_id, val) VALUES ($1, $2, $3)', array($purchase_id, $votes[$i], 1)
				);
				if (!$q)
				{
					done($conn);
					return false;
				}
				pg_free_result($q);
			}
		}
		else
		{
			if ($votes)
			{
				// add all
				$q = pg_query_params($conn, 
					'INSERT INTO "vote" (purchase_id, user_id, val) SELECT $2, user_id, $3 FROM "fridgeuser" WHERE fridge_id = $1', array($fridge_id, $purchase_id, 1)
				);
				if (!$q)
				{
					done($conn);
					return false;
				}
				pg_free_result($q);
			}
		}
		done($conn);
		return $purchase_id;
	}

	/**
	* @brief Add user vote for purchase
	*/
	function add_vote
	(
		$user_id,
		$purchase_id
	)
	{
		$conn = init();
		// Delete all prevoius votes is not necessary
		$q = pg_query_params($conn, 
			'DELETE FROM "vote" WHERE purchase_id = $1', array($purchase_id)
		);
		
		if (!$q)
		{
			done($conn);
			return false;
		}
		pg_free_result($q);
		
		$q = pg_query_params($conn, 
			'INSERT INTO "vote" (purchase_id, user_id, val) VALUES ($1, $2, $3)', array($purchase_id, $user_id, 1)
		);
		if (!$q)
		{
			done($conn);
			return false;
		}
		pg_free_result($q);

		done($conn);
		return $purchase_id;
	}

	// ------------------------------------ List ---------------------------------

	/**
	* @brief List users in specified locale
	* @param $locale 
	* @return users array
	*/
	function ls_user
	(
		$locale
	)
	{
		$conn = init();
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
		return $r;
	}

	/**
	* @brief List fridges in specified locale
	* @param $locale 
	* @return fridge array
	*/
	function ls_fridge
	(
		$locale
	)
	{
		$conn = init();
		$q = pg_query_params($conn, 
			"SELECT id, cn, '' as key, locale, lat, lon, alt FROM \"fridge\" WHERE (locale = $1) ORDER BY id", array($locale)
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
		return $r;
	}

	/**
	* @brief List fridge users
	* @param $fridge_id fridge identifier
	* @return users array
	*/
	function ls_fridgeuser
	(
		$fridge_id
	)
	{
		$conn = init();
		$q = pg_query_params($conn, 
			"SELECT fu.id, fu.fridge_id, fu.user_id, u.cn, '' as key, u.locale, u.lat,  u.lon, u.alt, fu.start, fu.finish, fu.balance
			FROM \"fridgeuser\" fu, \"user\" u WHERE fu.user_id = u.id AND fridge_id = $1 ORDER BY id", array($fridge_id)
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
		return $r;
	}

	/**
	* @brief List meals in locale available
	* @param $locale 
	* @return meals array
	*/
	function ls_meal
	(
		$locale
	)
	{
		$conn = init();
		$q = pg_query_params($conn, 
			"SELECT id, cn, locale
			FROM \"meal\" WHERE locale = $1 ORDER BY id", array($locale)
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
		return $r;
	}

	/**
	* @brief List user's purchases
	* @param $user_id
	* @return purchases
	*/
	function ls_purchase
	(
		$user_id
	)
	{
		$conn = init();
		$q = pg_query_params($conn, 
			"SELECT p.id, p.fridge_id, p.user_id, p.meal_id, p.cost, p.start, p.finish,
			f.cn, '' as fkey, f.locale, f.lat, f.lon, f.alt,
			u.cn, '' as ukey, u.locale, u.lat, u.lon, u.alt,
			m.cn, m.locale
			FROM \"purchase\" p, \"user\" u, \"fridge\" f, \"meal\" m WHERE p.fridge_id = f.id AND 
			p.user_id = u.id AND p.meal_id = m.id AND p.user_id = $1 
			ORDER BY p.id", array($user_id)
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
		return $r;
	}

	// ------------------------------------ Delete ---------------------------------

	/**
	* @brief Remove user vote for purchase
	*/
	function rm_vote
	(
		$user_id,
		$purchase_id
	)
	{
		if (!($purchase_id && $user_id))
			return false;
		$conn = init();
		$q = pg_query_params($conn, 
			'DELETE FROM "vote" WHERE purchase_id = $1 AND user_id = $2', array($purchase_id, $user_id)
		);
		if (!$q)
		{
			done($conn);
			return false;
		}
		pg_free_result($q);

		done($conn);
		return true;
	}

	/**
	* @brief Remove purchase by identifier
	*/
	function rm_purchase(
		$purchase_id
	)
	{
		$conn = init();
		$q = pg_query_params($conn, 
			'DELETE FROM "purchase" WHERE id = $1', array($purchase_id)
		);
		if (!$q)
		{
			done($conn);
			return false;
		}
		pg_free_result($q);

		done($conn);
		return true;
	}

	/**
	* @brief Remove fridge by identifier
	*/
	function rm_fridge(
		$fridge_id
	)
	{
		$conn = init();
		$q = pg_query_params($conn, 
			'DELETE FROM "fridge" WHERE id = $1', array($fridge_id)
		);
		if (!$q)
		{
			done($conn);
			return false;
		}
		pg_free_result($q);

		done($conn);
		return true;
	}

	/**
	* @brief Remove fridge user by user identifier not relation
	* @return payments array, each item is array of [$fridgeid, $userid, $start, $total]
	* @see fb_payments()
	*/
	function rm_fridgeuser(
		$user_id,
		$fridge_id
	)
	{
		$conn = init();
		
		$balance_array = calc_pg_user($conn, $fridge_id, $user_id);

		$q = pg_query_params($conn, 
			'DELETE FROM "fridgeuser" WHERE user_id = $1 AND fridge_id = $2', array($user_id, $fridge_id)
		);
		if (!$q)
		{
			done($conn);
			return false;
		}
		pg_free_result($q);

		done($conn);
		return $balance_array;
	}

	// ------------------------------------ Delete all ---------------------------------

	/**
	* @brief Clear all votes for purchase
	*/
	function clear_votes
	(
		$purchase_id
	)
	{
		$conn = init();
		// Delete all prevoius votes is not necessary
		$q = pg_query_params($conn, 
			'DELETE FROM "vote" WHERE purchase_id = $1', array($purchase_id)
		);

		if (!$q)
		{
			done($conn);
			return false;
		}
		pg_free_result($q);
		done($conn);
		return $purchase_id;
	}

?>

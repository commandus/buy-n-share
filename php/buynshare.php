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
	function fb_user1(
		$builder,
		$id,
		$cn,
		$key,
		$locale,
		$lat,
		$lon,
		$alt
	)
	{
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
		return $u;
	}

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
		$u = fb_user1(
			$builder,
			$id,
			$cn,
			$key,
			$locale,
			$lat,
			$lon,
			$alt
		);
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
		$f = fb_fridge1($builder, $id, $cn, $key, $locale, $lat, $lon, $alt);
		$builder->Finish($f);
		return $builder->dataBuffer()->data();
	}

	/**
	* @brief Serialize fridge
	*/
	function fb_fridge1(
		$builder,
		$id,
		$cn,
		$key,
		$locale,
		$lat,
		$lon,
		$alt
	)
	{
		$scn = $builder->createString($cn);
		$skey = $builder->createString($key);
		$slocale = $builder->createString($locale);
		bs\Fridge::startFridge($builder);
		bs\Fridge::addId($builder, $id);
		bs\Fridge::addCn($builder, $scn);
		bs\Fridge::addKey($builder, $skey);
		bs\Fridge::addLocale($builder, $slocale);
		bs\Fridge::addGeo($builder, bs\Geo::createGeo($builder, $lat, $lon, $alt));
		$f = bs\Fridge::EndFridge($builder);
		return $f;
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
	* @brief Serialize mealcard
	*/
	function fb_mealcard(
		$fridge_id,
		$meal_id,
		$qty
	)
	{
		$builder = new Google\FlatBuffers\FlatbufferBuilder(0);
		$meal = bs\Meal::createMeal($builder, $meal_id, 0, 0);
		$mealcard = bs\MealCard::createMealCard($builder, $meal, $qty);
		$builder->Finish($mealcard);
		return $builder->dataBuffer()->data();
	}


	/**
	* @brief Serialize fridge meal cards
	* $param $fridge [id, cn, key, locale, lat, lon, alt]
	* $param $mealcards [id, cn, locale, qty] 
	* @see fb_fridgemealcards1()
	*/
	function fb_fridgemealcards(
		&$fridge,
		&$mealcards
	)
	{
		$builder = new Google\FlatBuffers\FlatbufferBuilder(0);
		$fmc = fb_fridgemealcards1($builder, $fridge, $mealcards);
		$builder->Finish($fmc);
		return $builder->dataBuffer()->data();
	}

	/**
	* @brief Serialize fridge meal card
	* $param $fridge [id, cn, key, locale, lat, lon, alt]
	* $param $mealcards [id, cn, locale, qty] 
	* @see fb_fridgemealcards()
	*/
	function fb_fridgemealcards1(
		$builder,
		&$fridge,
		&$mealcards
	)
	{
		$f = fb_fridge1($builder, $fridge[0], $fridge[1], $fridge[2], $fridge[3], $fridge[4], $fridge[5], $fridge[6]);
		$mcs = fb_mealcards1($builder, $mealcards);
		$fmc = bs\FridgeMealCards::CreateFridgeMealCards($builder, $f, $mcs);
		return $fmc;
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

		$vvote_users = array();
		for ($i = 0; $i < count($votes); $i++)
		{
			$vote_user = bs\User::CreateUser($builder, $votes[$i], 0, 0, 0, 0);
			array_push($vvote_users, $vote_user);
		}
		$vvotes = bs\Purchase::CreateVotesVector($builder, $vvote_users);
		$p = bs\Purchase::createPurchase($builder, $id, $user_id, $fridge_id, $meal, $cost, $start, $finish, $vvotes);
		$builder->Finish($p);
		return $builder->dataBuffer()->data();
	}

	/**
	* @brief Serialize purchases
	*/
	function fb_purchases(
		&$purchases
	)
	{
		$builder = new Google\FlatBuffers\FlatbufferBuilder(0);
		$pa = array();
		foreach ($purchases as $purchase)
		{
			$scn = $builder->createString($purchase[4]);
			$slocale = $builder->createString($purchase[5]);
			$meal = bs\Meal::createMeal($builder, $purchase[3], $scn, $slocale);
			$vvotes = 0;
			// 21:		0          1     2       3    4    5
			//          v.user_id, u.cn, locale, lat, lon, alt
			$vvote_users = array();
			for ($i = 0; $i < count($purchase[21]); $i++)
			{
				$u = $purchase[21][$i];
				$scn = $builder->createString($u[1]);
				$slocale = $builder->createString($u[2]);
				// $geo = bs\Geo::createGeo($builder, $u[3], $u[4], $u[5]) // cause error: FlatBuffers: struct must be serialized inline
				$vote_user = bs\User::CreateUser($builder, $u[0], $scn, 0, $slocale, 0);
				array_push($vvote_users, $vote_user);
			}
			$vvotes = bs\Purchase::CreateVotesVector($builder, $vvote_users);
			// 0     1          2            3          4     5         6       7        8
			// p.id, p.user_id, p.fridge_id, p.meal_id, m.cn, m.locale, p.cost, p.start, p.finish,
			//                                                $id,          $userid,      $fridgeid,    $meal, $cost,        $start,       $finish,      $votes
			$purchase = bs\Purchase::createPurchase($builder, $purchase[0], $purchase[1], $purchase[2], $meal, $purchase[6], $purchase[7], $purchase[8], $vvotes);
			array_push($pa, $purchase);
		}
		$pv = bs\Purchases::CreatePurchasesVector($builder, $pa);
		bs\Purchases::startPurchases($builder);
		bs\Purchases::addPurchases($builder, $pv);
		$ff = bs\Purchases::EndPurchases($builder);
		$builder->Finish($ff);
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
	* @param $fridge array [id, fridge_id, user_id, cn, key, locale, lat, lon, alt, start, finish, balance]
	* @param $fridgeusers array [id, fridge_id, user_id, cn, key, locale, lat, lon, alt, start, finish, balance]
	* @see ls_fridgeuser()
	*/
	function fb_fridgeusers1
	(
		$builder,
		&$fridge,
		&$fridgeusers
	)
	{
		$f = fb_fridge1($builder, $fridge[0], $fridge[1], $fridge[2], $fridge[3], $fridge[4], $fridge[5], $fridge[6]);
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
		
			array_push($fa, $fu);
		}
		$fv = bs\FridgeUsers::CreateFridgeUsersVector($builder, $fa);
		$fu = bs\FridgeUsers::CreateFridgeUsers($builder, $f, $fv);
		return $fu;
	}

	/**
	* @brief Serialize fridge users array
	*/
	function fb_fridgeusers
	(
		&$fridge,
		&$fridgeusers
	)
	{
		$builder = new Google\FlatBuffers\FlatbufferBuilder(0);
		$ff = fb_fridgeusers1
		(
			$builder,
			$fridge,
			$fridgeusers
		);
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

			$m = bs\Meal::createMeal($builder, $meal[0], $scn, $slocale);
			array_push($ma, $m);
		}
		$mv = bs\Meals::CreateMealsVector($builder, $ma);
		bs\Meals::startMeals($builder);
		bs\Meals::addMeals($builder, $mv);
		$ff = bs\Meals::EndMeals($builder);
		$builder->Finish($ff);
		return $builder->dataBuffer()->data();
	}

	/**
	* @brief Serialize meal card array
	* @param $mealcards [id, cn, locale, qty]
	* @see fb_mealcards()
	*/
	function fb_mealcards1
	(
		$builder,
		&$mealcards
	)
	{
		$ma = array();
		foreach ($mealcards as $mealcard)
		{
			$scn = $builder->createString($mealcard[1]);
			$slocale = $builder->createString($mealcard[2]);
			$meal = bs\Meal::createMeal($builder, $mealcard[0], $scn, $slocale);
			$mealcard = bs\MealCard::createMealCard($builder, $meal, $mealcard[3]);
			array_push($ma, $mealcard);
		}
		$mv = bs\MealCards::CreateMealCardsVector($builder, $ma);
		return $mv;
	}

	/**
	* @brief Serialize meal card array
	* @param $mealcards [id, cn, locale, qty]
	* @see fb_mealcards1()
	*/
	function fb_mealcards
	(
		&$mealcards
	)
	{
		$builder = new Google\FlatBuffers\FlatbufferBuilder(0);
		$ff = fb_mealcards1($builder, $mealcards);
		$builder->Finish($ff);
		return $builder->dataBuffer()->data();
	}

	/**
	* @brief Serialize payments array
	* @param $user_payments Each item is [$fridgeid, $fridgecn, $userid, $usercn, $start, $total]
	* @see rm_fridgeuser()
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
			if (count($user_payment) >= 6)
			{
				$sfridgecn = $builder->createString($user_payment[1]);
				$f = bs\Fridge::CreateFridge($builder, $user_payment[0], $sfridgecn, 0, 0, 0);
				$susercn = $builder->createString($user_payment[3]);
				$u = bs\User::CreateUser($builder, $user_payment[2], $susercn, 0, 0, 0);
				$p = bs\Payment::createPayment($builder, $f, $u, $user_payment[4], $user_payment[5]);
				array_push($pa, $p);
			}
		}
		$pv = bs\Payments::CreatePaymentsVector($builder, $pa);
		bs\Payments::startPayments($builder);
		bs\Payments::addPayments($builder, $pv);
		$ff = bs\Payments::EndPayments($builder);
		$builder->Finish($ff);
		return $builder->dataBuffer()->data();
	}

	/**
	* $brief Serialize user's fridges
	* @param $data array u=>[id, cn, key, locale, lat, lon, alt] f=>[id, cn, key, locale, 4-lat, lon, alt, 7- [FridgeMealCards], 8- [FridgeUsers];]
	* user: User; FridgeMealCards: [id, cn, locale, qty]; FridgeUsers: [id, fridge_id, user_id, cn, key, locale, lat, lon, alt, start, finish, balance];
	* @see ls_userfridge
	*/
	function fb_userfridges(
		&$data
	)
	{
		if (!$data)
			return false;
		$builder = new Google\FlatBuffers\FlatbufferBuilder(0);
		$user = fb_user1($builder,
			$data['u'][0],
			$data['u'][1],
			$data['u'][2],
			$data['u'][3],
			$data['u'][4],
			$data['u'][5],
			$data['u'][6]
		);

		$mealcards = array();
		$users = array();
		for ($f = 0; $f < count($data['f']); $f++)
		{
			$fridgemealcards = fb_fridgemealcards1($builder, $data['f'][$f], $data['f'][$f][7]);
			array_push($mealcards, $fridgemealcards);

			$fridgeusers = fb_fridgeusers1($builder, $data['f'][$f], $data['f'][$f][8]);
			array_push($users, $fridgeusers);
		}

		$mcv = bs\UserFridges::createMealcardsVector($builder, $mealcards);
		$uv = bs\UserFridges::createUsersVector($builder, $users);
		$uf = bs\UserFridges::createUserFridges($builder, $user, $mcv, $uv);
		$builder->Finish($uf);
		return $builder->dataBuffer()->data();
}
	
	// ------------------------------------ Helper routines ---------------------------------

	function get_post_input()
	{
		$raw = file_get_contents('php://input');
		$v = gzdecode($raw);
		if (!$v)
			return $raw;
		else
			return $v;
	}

	function getOption(
		$name,
		&$options,
		$default
	) 
	{
		if (isset($_REQUEST[$name]))
			$r = $_REQUEST[$name];
		else
		{
			if (array_key_exists($name, $options))
			{
				$r = $options[$name];
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
		$user_id,
		$cn,
		$key,
		$locale,
		$lat,
		$lon,
		$alt,
		$balance
	)
	{
		if (!$user_id)
			return false;
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
		$fridge_id = $r[0];
		pg_free_result($q);

		$q = pg_query_params($conn, 
			'INSERT INTO "fridgeuser" (fridge_id, user_id, start, balance) VALUES ($1, $2, $3, $4) RETURNING id', 
			array($fridge_id, $user_id, time(), $balance)
		);
		$r = pg_fetch_row($q);
		if (!$q)
		{
			done($conn);
			return false;
		}
		pg_free_result($q);

		done($conn);
		return $fridge_id;
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
		// check
		$q = pg_query_params($conn, 
			'SELECT id FROM "fridgeuser" WHERE fridge_id = $1 AND user_id = $2', 
				array($fridge_id, $user_id)
		);
		if (!$q)
		{
			done($conn);
			return false;
		}
		$r = pg_fetch_row($q);
		pg_free_result($q);
		if ($r)
		{
			done($conn);
			return $r[0];
		}

		// add
		$q = pg_query_params($conn, 
			'INSERT INTO "fridgeuser" (fridge_id, user_id, start, finish, balance) VALUES ($1, $2, $3, $4, $5) RETURNING id', 
			array($fridge_id, $user_id, $start, $finish, $balance)
		);
		if (!$q)
		{
			done($conn);
			return false;
		}
		$r = pg_fetch_row($q);
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
	function pg_add_mealcard
	(
		$conn,
		$fridge_id,
		$meal_id,
		$qty,
		$increment_qty
	)
	{
		$q = pg_query_params($conn, 
			'SELECT id, qty FROM "mealcard" WHERE fridge_id = $1 AND meal_id = $2', array($fridge_id, $meal_id)
		);
		if ($q)
		{
			$r = pg_fetch_row($q);
			if ($r)
			{
				if ($increment_qty)
					$qty += $r[1];
				$q = pg_query_params($conn, 
					'UPDATE  "mealcard" SET fridge_id = $1, meal_id = $2, qty = $3', array($fridge_id, $meal_id, $qty)
				);
				if (!$q)
				{
					return false;
				}
				return $r[0];
			}
		}
		$q = pg_query_params($conn, 
			'INSERT INTO "mealcard" (fridge_id, meal_id, qty) VALUES ($1, $2, $3) RETURNING id', array($fridge_id, $meal_id, $qty)
		);
		if (!$q)
			return false;

		$r = pg_fetch_row($q);
		if (!$r)
		{
			pg_free_result($q);
			return false;
		}
		
		pg_free_result($q);
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
		$id = pg_add_mealcard($conn, $fridge_id, $meal_id, $qty, false);
		done($conn);
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
		$qty,
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
		// add meal card
		$mealcard_id = pg_add_mealcard($conn, $fridge_id, $meal_id, $qty, true);
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
			'DELETE FROM "vote" WHERE purchase_id = $1 AND user_id = $2', array($purchase_id, $user_id)
		);
		
		if ($q)
			pg_free_result($q);
		$q = pg_query_params($conn, 
			'INSERT INTO "vote" (purchase_id, user_id, val) VALUES ($1, $2, $3)', array($purchase_id, $user_id, 1)
		);
		if (!$q)
			$purchase_id = false;
		else
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
	* @brief Get user
	* @param $conn Database
	* @param $user_id User identifier
	* @return users array [id, cn, key, locale, lat, lon, alt]
	*/
	function pg_get_user
	(
		$conn,
		$user_id
	)
	{
		$q = pg_query_params($conn, 
			"SELECT id, cn, '' as key, locale, lat, lon, alt FROM \"user\" WHERE (id = $1)", array($user_id)
		);
		if (!$q)
			return false;
		$r = pg_fetch_row($q);
		pg_free_result($q);
		return $r;
	}

	/**
	* @brief List fridges in specified locale
	* @param $locale 
	* @return fridge array [id, cn, key, locale, lat, lon, alt]
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
	* @return users array [id, fridge_id, user_id, cn, key, locale, lat, lon, alt, start, finish, balance]
	*/
	function ls_fridgeuser
	(
		$fridge_id
	)
	{
		$conn = init();
		$r = pg_ls_fridgeuser($conn, $fridge_id);
		done($conn);
		return $r;
	}

	/**
	* @brief List fridge users
	* @param $conn Database
	* @param $fridge_id fridge identifier
	* @return users array [id, fridge_id, user_id, cn, key, locale, lat, lon, alt, start, finish, balance]
	*/
	function pg_ls_fridgeuser
	(
		$conn,
		$fridge_id
	)
	{
		$q = pg_query_params($conn, 
			"SELECT fu.id, fu.fridge_id, fu.user_id, u.cn, '' as key, u.locale, u.lat, u.lon, u.alt, fu.start, fu.finish, fu.balance
			FROM \"fridgeuser\" fu, \"user\" u WHERE fu.user_id = u.id AND fridge_id = $1 ORDER BY id", array($fridge_id)
		);
		if (!$q)
		{
			return false;
		}
		$r = array();
		while($row = pg_fetch_row($q))
		{
			array_push($r, $row);
		}
		pg_free_result($q);
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
	* @brief List meal cards in the fridge
	* @param $fridge_id 
	* @return meal cards array [id, cn, locale, qty] 
	* @see pg_ls_mealcard()
	*/
	function ls_mealcard
	(
		$fridge_id
	)
	{
		$conn = init();
		$r = pg_ls_mealcard($conn, $fridge_id);
		return $r;
	}

	/**
	* @brief List meal cards in the fridge
	* @param $conn Postgresql connection
	* @param $fridge_id 
	* @return meal cards array [id, cn, locale, qty]
	* @see ls_mealcard()
	*/
	function pg_ls_mealcard
	(
		$conn,
		$fridge_id
	)
	{
		$q = pg_query_params($conn, 
			"SELECT m.id, m.cn, m.locale, mc.qty
			FROM \"meal\" m, \"mealcard\" mc WHERE mc.fridge_id = $1 AND mc.meal_id = m.id ORDER BY m.cn", array($fridge_id)
		);
		if (!$q)
		{
			return false;
		}
		$r = array();
		while($row = pg_fetch_row($q))
		{
			array_push($r, $row);
		}
		pg_free_result($q);
		return $r;
	}

	/**
	* @brief List user's purchases
	* @param $user_id
	* @return purchases
	    0     1          2            3          4     5         6       7        8
		p.id, p.user_id, p.fridge_id, p.meal_id, m.cn, m.locale, p.cost, p.start, p.finish,
		9      10         11        12     13     14
		f.cn, '' as fkey, f.locale, f.lat, f.lon, f.alt,
		15    16          17        18     19     20
		u.cn, '' as ukey, u.locale, u.lat, u.lon, u.alt
		21
		user: 
		0          1     2       3    4    5
		v.user_id, u.cn, locale, lat, lon, alt
	*/
	function ls_purchase
	(
		$user_id = false,
		$fridge_id = false
	)
	{
		$conn = init();
		if ($user_id)
		{
			if ($fridge_id)
				$q = pg_query_params($conn, 
					"SELECT p.id, p.user_id, p.fridge_id, 
					p.meal_id, m.cn, m.locale,
					p.cost, p.start, p.finish,
					f.cn, '' as fkey, f.locale, f.lat, f.lon, f.alt,
					u.cn, '' as ukey, u.locale, u.lat, u.lon, u.alt
					FROM \"purchase\" p, \"user\" u, \"fridge\" f, \"meal\" m WHERE f.id = $2 AND p.fridge_id = f.id AND 
					p.user_id = u.id AND p.meal_id = m.id AND p.user_id = $1 
					ORDER BY p.id DESC", array($user_id, $fridge_id));
			else
				$q = pg_query_params($conn, 
					"SELECT p.id, p.user_id, p.fridge_id,
					p.meal_id, m.cn, m.locale,
					p.cost, p.start, p.finish,
					f.cn, '' as fkey, f.locale, f.lat, f.lon, f.alt,
					u.cn, '' as ukey, u.locale, u.lat, u.lon, u.alt
					FROM \"purchase\" p, \"user\" u, \"fridge\" f, \"meal\" m WHERE p.fridge_id = f.id AND 
					p.user_id = u.id AND p.meal_id = m.id AND p.user_id = $1 
					ORDER BY p.id DESC", array($user_id));
		}
		else
		{
			if ($fridge_id)
				$q = pg_query_params($conn, 
					"SELECT p.id, p.user_id, p.fridge_id, 
					p.meal_id, m.cn, m.locale,
					p.cost, p.start, p.finish,
					f.cn, '' as fkey, f.locale, f.lat, f.lon, f.alt,
					u.cn, '' as ukey, u.locale, u.lat, u.lon, u.alt
					FROM \"purchase\" p, \"user\" u, \"fridge\" f, \"meal\" m WHERE f.id = $1 AND p.fridge_id = f.id AND 
					p.user_id = u.id AND p.meal_id = m.id 
					ORDER BY p.id DESC", array($fridge_id));
			else
				$q = pg_query_params($conn, 
					"SELECT p.id, p.user_id, p.fridge_id,
					p.meal_id, m.cn, m.locale,
					p.cost, p.start, p.finish,
					f.cn, '' as fkey, f.locale, f.lat, f.lon, f.alt,
					u.cn, '' as ukey, u.locale, u.lat, u.lon, u.alt
					FROM \"purchase\" p, \"user\" u, \"fridge\" f, \"meal\" m WHERE p.fridge_id = f.id AND 
					p.user_id = u.id AND p.meal_id = m.id 
					ORDER BY p.id DESC", array());
		}
		if (!$q)
		{
			done($conn);
			return false;
		}
		$r = array();
		while ($row = pg_fetch_row($q))
		{
			$qvote = pg_query_params($conn, 
				"SELECT 
				v.user_id, u.cn, locale, lat, lon, alt
				FROM \"vote\" v, \"user\" u WHERE v.purchase_id = $1 AND  u.id = v.user_id
				ORDER BY v.id DESC", array($row[0]));
			$vote_users = array();
			while ($vote_row = pg_fetch_row($qvote))
			{
				array_push($vote_users, $vote_row);
			}
			array_push($row, $vote_users);	// 19
			array_push($r, $row);
		}
		pg_free_result($q);
		done($conn);
		return $r;
	}

	/**
	* @brief List of user fridges
	* @return array u=>[id, cn, key, locale, lat, lon, alt] f=>[id, cn, key, locale, lat, lon, alt, [FridgeMealCards], [FridgeUsers];]
	* user: User; FridgeMealCards: [id, cn, locale, qty]; FridgeUsers: [id, fridge_id, user_id, cn, key, locale, lat, lon, alt, start, finish, balance];
	* @see pg_ls_userfridge
	* @see fb_userfridges()
	*/
	function ls_userfridge
	(
		$user_id
	)
	{
		$conn = init();
		// [id, cn, key, locale, lat, lon, alt]
		$u = pg_get_user($conn, $user_id);
		if(!$u)
			return false;
		// [id, cn, key, locale, lat, lon, alt] Add 7- mealcards, 8- users
		$fridges = pg_ls_userfridge($conn, $user_id);
		foreach ($fridges as &$fridge)
		{
			// [id, cn, locale, qty]
			$mealcards = pg_ls_mealcard($conn, $fridge[0]);
			array_push($fridge, $mealcards);
			// [id, fridge_id, user_id, cn, key, locale, lat, lon, alt, start, finish, balance]
			$fridgeusers = pg_ls_fridgeuser($conn, $fridge[0]);
			array_push($fridge, $fridgeusers);
		}
		done($conn);
		$r = array('u'=>$u, 'f'=>$fridges);
		return $r;
	}
	
	/**
	* @brief List of user fridges
	* @return array [id, cn, key, locale, lat, lon, alt]
	*/
	function pg_ls_userfridge
	(
		$conn,
		$user_id
	)
	{
		// FridgeMealCards.fridge
		$q = pg_query_params($conn, 
			"SELECT f.id, cn, '' as key, f.locale, f.lat, f.lon, f.alt FROM \"fridge\" f WHERE f.id IN 
			(SELECT fridge_id FROM fridgeuser WHERE user_id = $1)
			ORDER BY f.cn", array($user_id)
		);
		if (!$q)
			return false;
		$r = array();
		while ($row = pg_fetch_row($q))
		{
			array_push($r, $row);
		}
		pg_free_result($q);
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

		// remove foreign
		$q = pg_query_params($conn, 
			'DELETE FROM "vote" WHERE purchase_id = $1', array($purchase_id)
		);
		if (!$q)
		{
			done($conn);
			return false;
		}

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
		// check
		$q = pg_query_params($conn, 
			'SELECT id FROM "fridge" WHERE id = $1', array($fridge_id)
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

		// remove foreign
		$q = pg_query_params($conn, 
			'DELETE FROM "fridgeuser" WHERE fridge_id = $1', array($fridge_id)
		);
		if (!$q)
		{
			done($conn);
			return false;
		}

		// remove fridge
		$q = pg_query_params($conn, 
			'DELETE FROM "fridge" WHERE id = $1', array($fridge_id)
		);
		if (!$q)
		{
			done($conn);
			return false;
		}
		done($conn);
		return true;
	}

	/**
	* @brief Remove fridge user by user identifier not relation
	* @return payments array, each item is array of [$fridgeid, $fridgecn, $userid, $usercn, $start, $total]
	* @see fb_payments()
	*/
	function rm_fridgeuser(
		$user_id,
		$fridge_id
	)
	{
		$conn = init();
		$balance_array = array();
		$c = calc_pg_user($conn, $fridge_id, $user_id);
		if ($c)
		{
			$r2 = array();	
			array_push($r2, $c[0]);
			// get fridge cn
			$q = pg_query_params($conn, 
				'SELECT cn FROM "fridge" WHERE id = $1', array($fridge_id)
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
			array_push($r2, $r[0]);

			array_push($r2, $c[1]);

			// get user cn
			$q = pg_query_params($conn, 
				'SELECT cn FROM "user" WHERE id = $1', array($user_id)
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
			array_push($r2, $r[0]);
			
			array_push($r2, $c[2]);
			array_push($r2, $c[3]);
			
			array_push($balance_array, $r2);
		}

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

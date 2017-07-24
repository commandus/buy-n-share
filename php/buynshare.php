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
require "bs/Purchase.php";
require "bs/User.php";
require "bs/Fridge.php";
require "bs/FridgeUser.php";
require "bs/Geo.php";
require "bs/Meal.php";
require "bs/UserFridges.php";
require "bs/UserPurchases.php";

require "env.php";

// https://stackoverflow.com/questions/4356289/php-random-string-generator
function generateRandomString($length = 10) 
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
    $geo =  bs\Geo::createGeo($builder, $lat, $lon, $alt);
/*
	$u = bs\User::CreateUser($builder, 0, $scn, $skey, $slocale, $geo);
	$r = $builder->Finish($u);
	*/
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

function print_user
(
    $b
)
{
	$buf = Google\FlatBuffers\ByteBuffer::wrap($b);
	$u = bs\User::getRootAsUser($buf);
	print $u->getId() . " " . $u->getCn() . " " . $u->getKey() . " " . $u->getLocale() . " " . $u->getGeo()->getLat() . " " . $u->getGeo()->getLon() . " " . $u->getGeo()->getAlt();
}


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
    // Выполнение SQL запроса
    $q = pg_query_params($conn, 
	'INSERT INTO "user" (cn, key, locale, lat, lon, alt) VALUES ($1, $2, $3, $4, $5, $6) RETURNING id', 
	array($cn, $key, $locale, $lat, $lon, $alt)
    )
	or die('Query error: ' . pg_last_error());
    $r = pg_fetch_row($q);
    pg_free_result($q);
    done($conn);
    return $r[0];
}
?>

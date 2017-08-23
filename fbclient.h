#ifndef FBCLIENT_H
#define FBCLIENT_H

#ifdef _WIN32
// @see https://stackoverflow.com/questions/2789481/problem-calling-stdmax
#define NOMINMAX
#endif

#include <string> 
#include <curl/curl.h>

#include "user_generated.h"
#include "users_generated.h"
#include "fridge_generated.h"
#include "fridges_generated.h"
#include "fridgeuser_generated.h"
#include "fridgeusers_generated.h"
#include "meal_generated.h"
#include "meals_generated.h"
#include "mealcard_generated.h"
#include "purchase_generated.h"
#include "purchases_generated.h"

using namespace bs;

class FBClient
{
public:
	std::string url;
	CURLcode code;
	long http_code;
	std::string retval;
protected:
	CURL *getCurlUrl(
		const std::string &url
	);
	CURL *postCurlUrl(
		const std::string &url, 
		void *data,
		size_t size
	);
	long perform
	(
		CURL *curl
	);
public:
	FBClient();
	FBClient(const std::string &base_url);
	~FBClient();
	const User *add_user
	(
		const std::string &cn,
		const std::string &key,
		const std::string &locale,
		const float lat,
		const float lon,
		const int alt
	);

	const Fridge *add_fridge
	(
		const uint64_t &user_id,
		const std::string &cn,
		const std::string &key,
		const std::string &locale,
		const float lat,
		const float lon,
		const int alt,
		int64_t balance
	);

	const FridgeUser *add_fridge_user
	(
		const uint64_t &user_id,
		const uint64_t &fridge_id,
		const int64_t &cost
	);

	const Meal *add_meal
	(
		const std::string &cn,
		const std::string &locale
	);

	const MealCard *add_mealcard
	(
		const uint64_t &fridge_id,
		const uint64_t &meal_id,
		const int64_t &qty
	);

	const Purchase *add_purchase
	(
		const uint64_t &user_id,
		const uint64_t &fridge_id,
		const uint64_t &meal_id,
		const uint32_t &cost,
		const int64_t &qty
	);
	
	uint64_t add_vote
	(
		const uint64_t &user_id,
		const uint64_t &purchase_id
	);

	bool rm_vote
	(
		const uint64_t &user_id,
		const uint64_t &purchase_id
	);
	
	const Users *ls_user
	(
		const std::string &locale
	);


	const Fridges *ls_fridge
	(
		const std::string &locale
	);
	
	const FridgeUsers *ls_fridge_users
	(
		const uint64_t &fridge_id
	);

	const FridgeUsers *ls_fridgeuser
	(
		const uint64_t &fridge_id
	);

	const Meals *ls_meal
	(
		const std::string &locale
	);

	const Purchases *ls_purchase
	(
		const uint64_t &user_id
	);
	
};

#endif // FBCLIENT_H

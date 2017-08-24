#include "fbclient.h"
#include <iostream>
#include <sstream>
#include <cstring>
#include <curl/curl.h>
#include "flatbuffers/flatbuffers.h"

using namespace flatbuffers;

#define DEF_URL "https://f.commandus.com/a/"

FBClient::FBClient()
	: url(DEF_URL), code(CURLE_OK)
{
	curl_global_init(CURL_GLOBAL_DEFAULT);
}

FBClient::FBClient
(
	const std::string &base_url
)
	: url(base_url), code(CURLE_OK)
{

}

FBClient::~FBClient()
{
	curl_global_cleanup();
}

CURL *FBClient::getCurlUrl
(
	const std::string &url
)
{
	CURL *curl = curl_easy_init();
	if (!curl)
	{
		code = CURLE_FAILED_INIT;
		return NULL;
	}
	curl_easy_setopt(curl, CURLOPT_URL, url.c_str());
	curl_easy_setopt(curl, CURLOPT_SSL_VERIFYPEER, 0L);
	curl_easy_setopt(curl, CURLOPT_SSL_VERIFYHOST, 0L);
	return curl;
}

/**
  * @brief CURL write callback
  */
static size_t write_string(void *contents, size_t size, size_t nmemb, void *userp)
{
	((std::string*)userp)->append((char*)contents, size * nmemb);
    return size * nmemb;
}


static size_t write_string_stream
(
	void *contents, 
	size_t size,
	size_t nmemb,
	void *userp
)
{
	size_t realsize = size * nmemb;
	std::stringstream *ss = (std::stringstream *) userp;
	std::string s((char *) contents, realsize);
	*ss << s;
	return realsize;
}

CURL *FBClient::postCurlUrl
(
	const std::string &url,
	void *data,
	size_t size
)
{
	retval = "";
	CURL *curl = curl_easy_init();
	if (!curl)
	{
		code = CURLE_FAILED_INIT;
		return NULL;
	}
	curl_easy_setopt(curl, CURLOPT_URL, url.c_str());
	curl_easy_setopt(curl, CURLOPT_SSL_VERIFYPEER, 0L);
	curl_easy_setopt(curl, CURLOPT_SSL_VERIFYHOST, 0L);
	
	curl_easy_setopt(curl, CURLOPT_WRITEFUNCTION, write_string);
	curl_easy_setopt(curl, CURLOPT_WRITEDATA, &retval);
  
	if ((data != NULL) && (size > 0))
	{
		curl_easy_setopt(curl, CURLOPT_POSTFIELDS, data);
		curl_easy_setopt(curl, CURLOPT_POSTFIELDSIZE, size);
	}
	return curl;
}

long FBClient::perform
(
	CURL *curl
)
{
	if (!curl)
		return 0;
	code = curl_easy_perform(curl);
	if (code != CURLE_OK)
		return 500 + code;
	http_code = 0;
	curl_easy_getinfo(curl, CURLINFO_RESPONSE_CODE, &http_code);
	curl_easy_cleanup(curl);
	return http_code;
}

const User *FBClient::add_user
(
	const std::string &cn,
	const std::string &key,
	const std::string &locale,
	const float lat,
	const float lon,
	const int alt
)
{
	const User *ret_user;
	
	FlatBufferBuilder fbb;
	Offset<String> scn = fbb.CreateString(cn);
	Offset<String> skey = fbb.CreateString(key);
	Offset<String> slocale = fbb.CreateString(locale);
	Geo geo(lat, lon, alt);
	flatbuffers::Offset<User> u = CreateUser(fbb, 0, scn, skey, slocale, &geo);
	fbb.Finish(u);
	
	CURL *curl = postCurlUrl(url + "add_user.php", fbb.GetBufferPointer(), fbb.GetSize());
	if (perform(curl) == 200)
		ret_user = GetUser(retval.c_str());
	else
		ret_user = NULL;
	return ret_user;
}

const Users *FBClient::ls_user
(
	const std::string &locale
)
{
	const Users *ret_users;
	
	CURL *curl = postCurlUrl(url + "ls_user.php", NULL, 0);
	if (!curl)
		return 0;

	if (perform(curl) == 200)
		ret_users = GetUsers(retval.c_str());
	else
		ret_users = NULL;
	return ret_users;
}

const Fridge *FBClient::add_fridge
(
	const uint64_t &user_id,
	const std::string &cn,
	const std::string &key,
	const std::string &locale,
	const float lat,
	const float lon,
	const int alt,
	int64_t balance
)
{
	const Fridge *ret_fridge;
	
	FlatBufferBuilder fbb;
	Offset<String> scn = fbb.CreateString(cn);
	Offset<String> skey = fbb.CreateString(key);
	Offset<String> slocale = fbb.CreateString(locale);
	Geo geo(lat, lon, alt);
	flatbuffers::Offset<Fridge> u = CreateFridge(fbb, 0, scn, skey, slocale, &geo);
	fbb.Finish(u);
	
	std::stringstream ss;
	ss << url << "add_fridge.php?user_id=" << user_id << "&balance=" << balance;
	CURL *curl = postCurlUrl(ss.str(), fbb.GetBufferPointer(), fbb.GetSize());
	if (perform(curl) == 200)
		ret_fridge = GetFridge(retval.c_str());
	else
		ret_fridge = NULL;
	return ret_fridge;
}

const FridgeUser *FBClient::add_fridge_user
(
	const uint64_t &user_id,
	const uint64_t &fridge_id,
	const int64_t &balance
)
{
	const FridgeUser *ret_fridge;
	
	FlatBufferBuilder fbb;
	
	flatbuffers::Offset<User> u = CreateUser(fbb, user_id, 0, 0, 0, 0);
	flatbuffers::Offset<FridgeUser> fu = CreateFridgeUser(fbb, fridge_id, u, 0, 0, balance);
	fbb.Finish(fu);
	
	CURL *curl = postCurlUrl(url + "add_fridgeuser.php", fbb.GetBufferPointer(), fbb.GetSize());
	if (perform(curl) == 200)
		ret_fridge = GetFridgeUser(retval.c_str());
	else
		ret_fridge = NULL;
	return ret_fridge;
}

const Meal *FBClient::add_meal
(
	const std::string &cn,
	const std::string &locale
)
{
	const Meal *ret_meal;
	
	FlatBufferBuilder fbb;
	Offset<String> scn = fbb.CreateString(cn);
	Offset<String> slocale = fbb.CreateString(locale);
	flatbuffers::Offset<Meal> m = CreateMeal(fbb, 0, scn, slocale);
	fbb.Finish(m);
	
	CURL *curl = postCurlUrl(url + "add_meal.php", fbb.GetBufferPointer(), fbb.GetSize());
	if (perform(curl) == 200)
		ret_meal = GetMeal(retval.c_str());
	else
		ret_meal = NULL;
	return ret_meal;
}

const MealCard *FBClient::add_mealcard
(
	const uint64_t &fridge_id,
	const uint64_t &meal_id,
	const int64_t &qty
)
{
	const MealCard *ret_mealcard;

	std::stringstream ss;
	ss << url << "add_mealcard.php?fridge_id=" << fridge_id << "&meal_id=" << meal_id << "&qty=" << qty;
	CURL *curl = postCurlUrl(ss.str(), NULL, 0);
	if (perform(curl) == 200)
		ret_mealcard = GetMealCard(retval.c_str());
	else
		ret_mealcard = NULL;
	return ret_mealcard;
}

const Purchase *FBClient::add_purchase
(
	const uint64_t &user_id,
	const uint64_t &fridge_id,
	const uint64_t &meal_id,
	const uint32_t &cost,
	const int64_t &qty
)
{
	const Purchase *ret_purchase;
	
	FlatBufferBuilder fbb;
	flatbuffers::Offset<Meal> meal = CreateMeal(fbb, meal_id, 0, 0);

	std::vector<flatbuffers::Offset<User>> users;
	flatbuffers::Offset<User> u = CreateUser(fbb, user_id);
	users.push_back(u);
	flatbuffers::Offset<flatbuffers::Vector<flatbuffers::Offset<User>>> votes = fbb.CreateVector(users);

	flatbuffers::Offset<Purchase> m = CreatePurchase(fbb, 0, user_id, fridge_id, meal, cost, 0, 0, votes);
	fbb.Finish(m);

	std::stringstream ss;
	ss << url << "add_purchase.php?qty=" << qty;
	CURL *curl = postCurlUrl(ss.str(), fbb.GetBufferPointer(), fbb.GetSize());
	if (perform(curl) == 200)
		ret_purchase = GetPurchase(retval.c_str());
	else
		ret_purchase = NULL;
	return ret_purchase;
}

uint64_t FBClient::add_vote
(
	const uint64_t &user_id,
	const uint64_t &purchase_id
)
{
	uint64_t ret_purchase;
	std::stringstream ss;
	ss << url << "add_vote.php?purchase_id=" << purchase_id << "&user_id=" << user_id;
	CURL *curl = postCurlUrl(ss.str(), NULL, 0);
	if (perform(curl) == 200)
		ret_purchase = strtol(retval.c_str(), NULL, 10);
	else
		ret_purchase = 0;
	return ret_purchase;
}

const Fridges *FBClient::ls_fridge
(
	const std::string &locale
)
{
	const Fridges *ret_fridges;
	
	CURL *curl = postCurlUrl(url + "ls_fridge.php", NULL, 0);
	if (!curl)
		return 0;

	if (perform(curl) == 200)
		ret_fridges = GetFridges(retval.c_str());
	else
		ret_fridges = NULL;
	return ret_fridges;
}

const FridgeUsers *FBClient::ls_fridgeuser
(
	const uint64_t &fridge_id
)
{
	const FridgeUsers *ret_fridge_users;
	
	std::stringstream sfridge_id;
	sfridge_id << fridge_id;
	CURL *curl = postCurlUrl(url + "ls_fridgeuser.php?fridge_id=" + sfridge_id.str(), NULL, 0);
	if (!curl)
		return 0;

	if (perform(curl) == 200)
		ret_fridge_users = GetFridgeUsers(retval.c_str());
	else
		ret_fridge_users = NULL;
	return ret_fridge_users;
}

const Meals  *FBClient::ls_meal
(
	const std::string &locale
)
{
	const Meals *ret_meals;
	
	CURL *curl = postCurlUrl(url + "ls_meal.php?locale=" + locale, NULL, 0);
	if (!curl)
		return 0;

	if (perform(curl) == 200)
		ret_meals = GetMeals(retval.c_str());
	else
		ret_meals = NULL;
	return ret_meals;
}

const MealCards *FBClient::ls_mealcard
(
	const uint64_t fridge_id
)
{
	const MealCards *ret_mealcards;
	std::stringstream ss;
	ss << url << "ls_mealcard.php?fridge_id=" << fridge_id;
	CURL *curl = postCurlUrl(ss.str(), NULL, 0);
	if (!curl)
		return 0;

	if (perform(curl) == 200)
		ret_mealcards = GetMealCards(retval.c_str());
	else
		ret_mealcards = NULL;
	return ret_mealcards;
}

const Purchases *FBClient::ls_purchase
(
	const uint64_t &user_id,
	const uint64_t &fridge_id
)
{
	const Purchases *ret_purchases;
	std::stringstream ss;
	ss << url << "ls_purchase.php?user_id=" << user_id << "&fridge_id=" << fridge_id;
	CURL *curl = postCurlUrl(ss.str(), NULL, 0);
	if (!curl)
		return 0;

	if (perform(curl) == 200)
		ret_purchases = GetPurchases(retval.c_str());
	else
		ret_purchases = NULL;
	return ret_purchases;
}

bool FBClient::rm_vote
(
	const uint64_t &user_id,
	const uint64_t &purchase_id
)
{
	bool ret_vote;
	std::stringstream ss;
	ss << url << "rm_vote.php?purchase_id=" << purchase_id + "&user_id=" << user_id;
	CURL *curl = postCurlUrl(ss.str(), NULL, 0);
	if (perform(curl) == 200)
		ret_vote = (retval == "1");
	else
		ret_vote = 0;
	return ret_vote;
}


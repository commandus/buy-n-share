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
		const double lat,
		const double lon,
		const int alt
	);

	const Users *ls_user
	(
		const std::string &locale
	);

	const Fridge *add_fridge
	(
		const std::string &cn,
		const std::string &key,
		const std::string &locale,
		const double lat,
		const double lon,
		const int alt
	);

	const Fridges *ls_fridge
	(
		const std::string &locale
	);
	
	const FridgeUser *add_fridge_user
	(
		const uint64_t &user_id,
		const uint64_t &fridge_id,
		const uint64_t &cost
	);

	const FridgeUsers *ls_fridge_users
	(
		const uint64_t &fridge_id
	);

	const FridgeUsers *ls_fridgeuser
	(
		const uint64_t &fridge_id
	);
	
};

#endif // FBCLIENT_H

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
		std::string &cn,
		std::string &key,
		std::string &locale,
		double lat,
		double lon,
		int alt
	);

	const Users *ls_user
	(
		const std::string &locale
	);

	const Fridge *add_fridge
	(
		std::string &cn,
		std::string &key,
		std::string &locale,
		double lat,
		double lon,
		int alt
	);

	const Fridges *ls_fridge
	(
		const std::string &locale
	);
	
	const FridgeUser *add_fridge_user
	(
		uint64_t &user_id,
		uint64_t &fridge_id,
		uint64_t &cost
	);

	const FridgeUsers *ls_fridge_users
	(
		uint64_t &fridge_id
	);
	
};

#endif // FBCLIENT_H

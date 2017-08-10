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

using namespace bs;

class FBClient
{
public:
	std::string url;
	CURLcode code;
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
	
};

#endif // FBCLIENT_H

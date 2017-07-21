#ifndef FBCLIENT_H
#define FBCLIENT_H

#include <string> 
#include <curl/curl.h>

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
	~FBClient();
	int add_user(
		std::string &cn,
		std::string &key,
		std::string &locale,
		double lat,
		double lon,
		int alt
	);
};

#endif // FBCLIENT_H

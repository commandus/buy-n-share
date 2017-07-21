/**
 * @file buy-n-share.cpp
 */

#include <argtable2.h>
#include <string>
#include <cstring>
#include <iostream>
#include "buy-n-share.h"

#include "fbclient.h"

int main(int argc, char** argv)
{

	BuyNShareConfig config(argc, argv);
	if (config.error())
		exit(config.error());

	FBClient cli;

	switch (config.cmd) 
	{
		case CMD_BALANCE:
			break;
		case CMD_ADD_USER:
			config.id = cli.add_user(config.cn, config.key, config.locale, config.lat, config.lon, config.alt);
			break;
		default:
		// case CMD_MEAL
			break;
	}

	return 0;
}

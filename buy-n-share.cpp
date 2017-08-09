/**
 * @file buy-n-share.cpp
 */

#include <argtable2.h>
#include <string>
#include <cstring>
#include <iostream>
#include "buy-n-share.h"
#include "buy-n-share-config.h"

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
		case CMD_LS_USER:
			{
				const Users *u = cli.ls_user(config.locale);
				for (auto it(u->users()->begin()); it != u->users()->end(); ++it)
				{
					std::cout << it->id() << "\t" 
						<< it->key()->str() << std::endl;
				}
			}
			break;
		case CMD_ADD_USER:
			{
				const User *u = cli.add_user(config.cn, config.key, config.locale, config.lat, config.lon, config.alt);
				config.id = u->id();
				config.key = u->key()->str();
				std::cout << u->id() << "\t" << u->key()->str() << std::endl;
			}
			break;
		default:
		// case CMD_MEAL
			break;
	}

	return 0;
}

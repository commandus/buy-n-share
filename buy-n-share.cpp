/**
 * @file buy-n-share.cpp
 */

#include <argtable2.h>
#include <string>
#include <cstring>
#include <iostream>
#include "buy-n-share.h"

int main(int argc, char** argv)
{

	BuyNShareConfig config(argc, argv);
	if (config.error())
		exit(config.error());

	switch (config.cmd) 
	{
		case CMD_BALANCE:
			break;
		default:
		// case CMD_MEAL
			break;
	}

	return 0;
}

#include "buy-n-share-config.h"
#include <iostream>
#include <argtable2.h>

static const char* progname = "buy-n-share";

BuyNShareConfig::BuyNShareConfig()
	: cmd(CMD_MEAL), user_id(0), user_key(""), cn(""), locale(""),
	cost(0.0), lat(0.0), lon(0.0), alt(0)
{
}

BuyNShareConfig::BuyNShareConfig
(
	int argc,
	char* argv[]
)
{
	errorcode = parseCmd(argc, argv);
}

/**
 * Parse command line into BuyNShareConfig class
 * Return 0- success
 *        1- show help and exit, or command syntax error
 *        2- output file does not exists or can not open to write
 **/
int BuyNShareConfig::parseCmd
(
	int argc,
	char* argv[]
)
{
	// commands
	struct arg_lit *a_meal = arg_lit0(NULL, "meal", "print fridge meals");
	struct arg_lit *a_balance = arg_lit0(NULL, "balance", "print fridge purchase balance by user");
	struct arg_str *a_add = arg_str0(NULL, "add", "<user|fridge|purchase>", "Add a new object");
	struct arg_str *a_rm = arg_str0(NULL, "rm", "<user|fridge|purchase>", "Remove an object");

	struct arg_int *a_user_id = arg_int0("i", "id", "<number>", "User identifier");
	struct arg_str *a_user_key = arg_str1("k", "key", "<secret>", "Password");
	
	struct arg_str *a_cn = arg_str0("n", "cn", "<string>", "common name");
	struct arg_str *a_locale = arg_str0("e", "locale", "<ru|en>", "Locale name");
	struct arg_dbl *a_cost = arg_dbl0("c", "cost", "<number>", "Cost");
	struct arg_dbl *a_lat = arg_dbl0("l", "lat", "<number>", "Latitude");
	struct arg_dbl *a_lon = arg_dbl0("o", "lon", "<number>", "Longitude");
	struct arg_int *a_alt = arg_int0("a", "alt", "<number>", "Altitude");
	struct arg_lit *a_help = arg_lit0("h", "help", "Show this help");
	struct arg_end *a_end = arg_end(20);

	void* argtable[] = { 
		// commands
		a_meal, a_balance, a_add, a_rm,
		// identification
		a_user_id, a_user_key,
		// options
		a_cn, a_locale, a_cost, a_lat, a_lon, a_alt,
		// others
		a_help, a_end 
	};

	int nerrors;

	// verify the argtable[] entries were allocated successfully
	if (arg_nullcheck(argtable) != 0)
	{
		arg_freetable(argtable, sizeof(argtable) / sizeof(argtable[0]));
		return 1;
	}
	// Parse the command line as defined by argtable[]
	nerrors = arg_parse(argc, argv, argtable);

	cmd = CMD_MEAL;
	if (a_balance->count)
		cmd = CMD_BALANCE;
	if (a_add->count)
	{
		if (*a_add->sval == "user")
			cmd = CMD_ADD_USER;
		if (*a_add->sval == "fridge")
			cmd = CMD_ADD_FRIDGE;
		if (*a_add->sval == "purchase")
			cmd = CMD_ADD_PURCHASE;
	}

	if (a_rm->count)
	{
		if (*a_rm->sval == "user")
			cmd = CMD_RM_USER;
		if (*a_rm->sval == "fridge")
			cmd = CMD_RM_FRIDGE;
		if (*a_rm->sval == "purchase")
			cmd = CMD_RM_PURCHASE;
	}

	if (a_user_id->count)
		user_id = *a_user_id->ival;
	if (a_user_key->count)
		user_key = *a_user_key->sval;
	if (a_cn->count)
		cn = *a_cn->sval;
	if (a_locale->count)
		locale = *a_locale->sval;
	if (a_lat->count)
		lat = *a_lat->dval;
	if (a_lon->count)
		lon = *a_lon->dval;
	if (a_alt->count)
		alt = *a_alt->ival;

	// special case: '--help' takes precedence over error reporting
	if ((a_help->count) || nerrors)
	{
		if (nerrors)
			arg_print_errors(stderr, a_end, progname);
		std::cerr << "Usage: " << progname << std::endl;
		arg_print_syntax(stderr, argtable, "\n");
		std::cerr << "Simplest Tox CLI client" << std::endl;
		arg_print_glossary(stderr, argtable, "  %-25s %s\n");
		arg_freetable(argtable, sizeof(argtable) / sizeof(argtable[0]));
		return 1;
	}

	arg_freetable(argtable, sizeof(argtable) / sizeof(argtable[0]));
	return 0;
}


int BuyNShareConfig::error()
{
	return errorcode;
}

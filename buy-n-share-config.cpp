#include "buy-n-share-config.h"
#include "fbclient.h"
#include <iostream>
#include <cstring>
#include <argtable2.h>

#define DEF_LOCALE		"ru"
static const char* progname = "buy-n-share";

static const char* OBJECT_LIST = "<user|fridge|fridgeuser|meal|mealcard|purchase|vote>";

BuyNShareConfig::BuyNShareConfig()
	: base_url(DEF_URL), cmd(CMD_NONE), user_id(0), key(""), cn(""), locale(""),
	cost(0), qty(0), lat(0.0), lon(0.0), alt(0), fridge_id(0), meal_id(0)
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
	struct arg_str *a_base_url = arg_str0("u", "url", "<URL>", "Default " DEF_URL);
	// commands
	struct arg_int *a_ls_userfridge = arg_int0("d", "dashboard", "<user id>", "List of all user's fridges");
	struct arg_str *a_add = arg_str0(NULL, "add", OBJECT_LIST, "Add a new object");
	struct arg_str *a_rm = arg_str0(NULL, "rm", OBJECT_LIST, "Remove an object");
	struct arg_str *a_ls = arg_str0(NULL, "ls", OBJECT_LIST, "List");

	struct arg_int *a_user_id = arg_int0("i", "id", "<number>", "User identifier");
	struct arg_str *a_user_key = arg_str0("k", "key", "<secret>", "Password");
	
	struct arg_str *a_cn = arg_str0("n", "cn", "<string>", "common name");
	struct arg_str *a_locale = arg_str0("e", "locale", "<ru|en>", "Locale name");
	struct arg_int *a_cost = arg_int0("c", "cost", "<number>", "Cost");
	struct arg_int *a_qty = arg_int0("q", "qty", "<number>", "Quantity");
	struct arg_dbl *a_lat = arg_dbl0("l", "lat", "<number>", "Latitude");
	struct arg_dbl *a_lon = arg_dbl0("o", "lon", "<number>", "Longitude");
	struct arg_int *a_alt = arg_int0("a", "alt", "<number>", "Altitude");
	
	struct arg_int *a_fridge_id = arg_int0("f", "fid", "<number>", "Fridge identifier");
	struct arg_int *a_meal_id = arg_int0("m", "mid", "<number>", "Meal identifier");
	struct arg_int *a_vote_purchase_id = arg_int0("p", "purchase_id", "<number>", "Purchase identifier");
		
	struct arg_lit *a_help = arg_lit0("h", "help", "Show this help");
	struct arg_end *a_end = arg_end(20);

	void* argtable[] = { 
		a_base_url,
		// commands
		a_ls_userfridge, a_add, a_rm, a_ls,
		// identifiers
		a_user_id, a_fridge_id, a_meal_id, a_vote_purchase_id, a_user_key,
		// options
		a_cn, a_locale, a_cost, a_qty, a_lat, a_lon, a_alt,
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

	if (a_base_url->count)
		base_url = *a_base_url->sval;
	else
		base_url = DEF_URL;

	cmd = CMD_NONE;

	if (a_user_id->count)
		user_id = *a_user_id->ival;
	else
		user_id = 0;

	if (a_ls_userfridge->count)
	{
		cmd = CMD_LS_USERFRIDGE;
		user_id = *a_ls_userfridge->ival;
	}
	if (a_add->count)
	{
		if (strcmp(*a_add->sval, "user") == 0)
			cmd = CMD_ADD_USER;
		if (strcmp(*a_add->sval, "fridge") == 0)
			cmd = CMD_ADD_FRIDGE;
		if (strcmp(*a_add->sval, "fridgeuser") == 0)
			cmd = CMD_ADD_FRIDGEUSER;
		if (strcmp(*a_add->sval, "meal") == 0)
			cmd = CMD_ADD_MEAL;
		if (strcmp(*a_add->sval, "mealcard") == 0)
			cmd = CMD_ADD_MEALCARD;
		if (strcmp(*a_add->sval, "purchase") == 0)
			cmd = CMD_ADD_PURCHASE;
		if (strcmp(*a_add->sval, "vote") == 0)
			cmd = CMD_ADD_VOTE;
	}

	if (a_rm->count)
	{
		if (strcmp(*a_rm->sval, "user") == 0)
			cmd = CMD_RM_USER;
		if (strcmp(*a_rm->sval, "fridge") == 0)
			cmd = CMD_RM_FRIDGE;
		if (strcmp(*a_rm->sval, "fridgeuser") == 0)
			cmd = CMD_RM_FRIDGEUSER;
		if (strcmp(*a_rm->sval, "meal") == 0)
			cmd = CMD_RM_MEAL;
		if (strcmp(*a_rm->sval, "mealcard") == 0)
			cmd = CMD_RM_MEALCARD;
		if (strcmp(*a_rm->sval, "purchase") == 0)
			cmd = CMD_RM_PURCHASE;
		if (strcmp(*a_rm->sval, "vote") == 0)
			cmd = CMD_RM_VOTE;
	}

	if (a_ls->count)
	{
		if (strcmp(*a_ls->sval, "user") == 0)
			cmd = CMD_LS_USER;
		if (strcmp(*a_ls->sval, "fridge") == 0)
			cmd = CMD_LS_FRIDGE;
		if (strcmp(*a_ls->sval, "fridgeuser") == 0)
			cmd = CMD_LS_FRIDGEUSER;
		if (strcmp(*a_ls->sval, "meal") == 0)
			cmd = CMD_LS_MEAL;
		if (strcmp(*a_ls->sval, "mealcard") == 0)
			cmd = CMD_LS_MEALCARD;
		if (strcmp(*a_ls->sval, "purchase") == 0)
			cmd = CMD_LS_PURCHASE;
		if (strcmp(*a_ls->sval, "vote") == 0)
			cmd = CMD_LS_VOTE;
	}

	if (a_fridge_id->count)
		fridge_id = *a_fridge_id->ival;
	else
		fridge_id = 0;
	if (a_meal_id->count)
		meal_id = *a_meal_id->ival;
	else
		meal_id = 0;
	
	if (a_vote_purchase_id->count)
		purchase_id = *a_vote_purchase_id->ival;
	else
		purchase_id = 0;
	if (a_user_key->count)
		key = *a_user_key->sval;
	else
		key = "";
	if (a_cn->count)
		cn = *a_cn->sval;
	else
		cn = "";
	if (a_locale->count)
		locale = *a_locale->sval;
	else
		locale = DEF_LOCALE;
	if (a_cost->count)
		cost = *a_cost->ival;
	else
		cost = 0;
	if (a_qty->count)
		qty = *a_qty->ival;
	else
		qty = 0;
	if (a_lat->count)
		lat = *a_lat->dval;
	else
		lat = 0.0;
	if (a_lon->count)
		lon = *a_lon->dval;
	else
		lon = 0.0;
	if (a_alt->count)
		alt = *a_alt->ival;
	else
		alt = 0;

	if (cmd == CMD_NONE)
	{
		std::cerr << "Error: no command"<< std::endl;
		nerrors++;
	}

	// special case: '--help' takes precedence over error reporting
	if ((a_help->count) || nerrors)
	{
		if (nerrors)
			arg_print_errors(stderr, a_end, progname);
		std::cerr << "Usage: " << progname << std::endl;
		arg_print_syntax(stderr, argtable, "\n");
		std::cerr << "buy-n-share CLI client" << std::endl;
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

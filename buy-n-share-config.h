/**
  * buy-n-share options
  * @file buy-n-share-config.h
  **/

#ifndef BUY_N_SHARE_CONFIG_H
#define BUY_N_SHARE_CONFIG_H

#include <string>
#include <vector>

#define CMD_NONE			0
#define CMD_MEAL			1
#define CMD_BALANCE			2

#define CMD_ADD_USER		10
#define CMD_ADD_FRIDGE		11
#define CMD_ADD_FRIDGE_USER	12
#define CMD_ADD_PURCHASE	13

#define CMD_RM_USER			20
#define CMD_RM_FRIDGE		21
#define CMD_RM_FRIDGE_USER	22
#define CMD_RM_PURCHASE		23

#define CMD_LS_USER			30
#define CMD_LS_FRIDGE		31
#define CMD_LS_FRIDGE_USER	32
#define CMD_LS_PURCHASE		33

/**
 * Command line interface (CLI) tool configuration structure
 */
class BuyNShareConfig
{
private:
	/**
	* Parse command line into ClitoxConfig class
	* Return 0- success
	*        1- show help and exit, or command syntax error
	*        2- output file does not exists or can not open to write
	**/
	int parseCmd
	(
		int argc,
		char* argv[]
	);
	int errorcode;
public:
	std::string base_url;								///< URL
	int cmd;
	uint64_t id;
	std::string key;								///< password
	std::string cn;									///< common name
	std::string locale;								///< Locale name
	double cost;									///< Cost
	double lat;										///< Latitude
	double lon;										///< Longitude
	int alt;										///< Altitoide
	
	BuyNShareConfig();
	BuyNShareConfig
	(
		int argc,
		char* argv[]
	);
	int error();
};



#endif

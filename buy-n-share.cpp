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

	FBClient cli(config.base_url);

	switch (config.cmd) 
	{
		case CMD_LS_USERFRIDGE:
		{
			// dashboard
			const UserFridges *u = cli.ls_userfridge(config.user_id);
			if (u)
			{
				std::cout
					<< "User: "
					<< u->user()->id() << "\t"
					<< u->user()->cn()->str() << "\t"
					<< u->user()->locale()->str() << "\t"
					<< std::endl;
				std::cout << "Meal cards: " << std::endl;
				for (auto it(u->mealcards()->begin()); it != u->mealcards()->end(); ++it)
				{
					if (!it->fridge())
						continue;
					std::cout
						<< "Fridge: "
						<< it->fridge()->id() << "\t"
						<< it->fridge()->cn()->str() << "\t"
						<< it->fridge()->locale()->str() << "\t"
						<< std::endl;
					for (auto itc(it->mealcards()->begin()); itc != it->mealcards()->end(); ++itc)
					{
						if (!itc->meal())
						{
							std::cerr << "Meal?" << std::endl;
							continue;
						}
						std::cout
							<< "Meal card: "
							<< itc->meal()->id() << "\t"
							<< itc->meal()->cn()->str() << "\t"
							<< itc->meal()->locale()->str() << "\t"
							<< (int)itc->qty() << "\t"
							<< std::endl;
					}

				}
				
				std::cout << "Users: " << std::endl;
				for (auto itu(u->users()->begin()); itu != u->users()->end(); ++itu)
				{
					if (itu->fridge())
					{
						std::cout
							<< "Fridge: "
							<< itu->fridge()->id() << "\t"
							<< itu->fridge()->cn()->str() << "\t"
							<< itu->fridge()->locale()->str() << "\t"
							<< std::endl;
					}
					
					for (auto itfu(itu->fridgeusers()->begin()); itfu != itu->fridgeusers()->end(); ++itfu)
					{
						std::cout
							<< "User: "
							<< itfu->user()->id() << "\t"
							<< itfu->user()->cn()->str() << "\t"
							<< itfu->balance() << "\t"
							<< std::endl;
					}
					
				}
			}
			else
			{
				std::cerr << cli.url << " HTTP code " << cli.code << ": " << cli.retval << std::endl;
			}
		}
			break;
		case CMD_LS_USER:
			{
				const Users *u = cli.ls_user(config.locale);
				if (u)
				{
					for (auto it(u->users()->begin()); it != u->users()->end(); ++it)
					{
						std::cout << it->id() << "\t"
							<< it->cn()->str() << "\t"
							<< it->locale()->str() << "\t"
							<< it->key()->str() << "\t"
							<< it->geo()->lat() << "\t"
							<< it->geo()->lon() << "\t"
							<< it->geo()->alt() << "\t"
							<< std::endl;
					}
				}
				else
				{
					std::cerr << cli.url << " HTTP code " << cli.code << ": " << cli.retval << std::endl;
				}
			}
			break;
		case CMD_LS_FRIDGE:
			{
				const Fridges *f = cli.ls_fridge(config.locale);
				if (f)
				{
					for (auto it(f->fridges()->begin()); it != f->fridges()->end(); ++it)
					{
						std::cout << it->id() << "\t"
							<< it->cn()->str() << "\t"
							<< it->locale()->str() << "\t"
							<< it->key()->str() << "\t";
						if (it->geo())
						{
							std::cout 
								<< it->geo()->lat() << "\t"
								<< it->geo()->lon() << "\t"
								<< it->geo()->alt() << "\t";
						}
						std::cout << std::endl;
					}
				}
				else
				{
					std::cerr << cli.url << " HTTP code " << cli.code << ": " << cli.retval << std::endl;
				}
			}
			break;
		case CMD_LS_FRIDGEUSER:
			{
				const FridgeUsers *f = cli.ls_fridgeuser(config.fridge_id);
				if (f)
				{
					for (auto it(f->fridgeusers()->begin()); it != f->fridgeusers()->end(); ++it)
					{
						std::cout 
							<< it->fridgeid() << "\t"
							<< it->user()->id() << "\t"
							<< it->user()->cn()->str() << "\t"
							<< it->user()->locale()->str() << "\t"
							<< it->user()->key()->str() << "\t"
							<< it->user()->geo()->lat() << "\t"
							<< it->user()->geo()->lon() << "\t"
							<< it->user()->geo()->alt() << "\t"
							<< it->start() << "\t"
							<< it->finish() << "\t"
							<< it->balance() << "\t"
							<< std::endl;
					}
				}
				else
				{
					std::cerr << cli.url << " HTTP code " << cli.code << ": " << cli.retval << std::endl;
				}
			}
			break;
		case CMD_LS_MEAL:
			{
				const Meals *m = cli.ls_meal(config.locale);
				if (m)
				{
					for (auto it(m->meals()->begin()); it != m->meals()->end(); ++it)
					{
						std::cout << it->id() << "\t"
							<< it->cn()->str() << "\t"
							<< it->locale()->str() << "\t"
							<< std::endl;
					}
				}
				else
				{
					std::cerr << cli.url << " HTTP code " << cli.code << ": " << cli.retval << std::endl;
				}
			}
			break;
		case CMD_LS_MEALCARD:
		{
			const MealCards *m = cli.ls_mealcard(config.fridge_id);
			if (m)
			{
				for (auto it(m->mealcards()->begin()); it != m->mealcards()->end(); ++it)
				{
					std::cout 
						<< it->meal()->id() << "\t"
						<< it->meal()->cn()->str() << "\t"
						<< (int) it->qty() << "\t"
						<< std::endl;
				}
			}
			else
			{
				std::cerr << cli.url << " HTTP code " << cli.code << ": " << cli.retval << std::endl;
			}
		}
		break;
		case CMD_LS_PURCHASE:
			{
				const Purchases *p = cli.ls_purchase(config.user_id, config.fridge_id);
				if (p)
				{
					for (auto it(p->purchases()->begin()); it != p->purchases()->end(); ++it)
					{
						std::cout
							<< it->id() << "\t"
							<< it->meal()->cn()->str() << "\t"
							<< it->fridgeid() << "\t"
							<< it->start() << "\t"
							<< it->finish() << "\t";
						for (auto vit(it->votes()->begin()); vit != it->votes()->end(); ++vit)
						{
							std::cout << vit->cn()->str() << "\t";
						}
						std::cout
							<< std::endl;
					}
				}
				else
				{
					std::cerr << cli.url << " HTTP code " << cli.code << ": " << cli.retval << std::endl;
				}
			}
			break;
		case CMD_ADD_USER:
			{
				const User *u = cli.add_user(config.cn, config.key, config.locale, config.lat, config.lon, config.alt);
				if (u)
				{
					config.user_id = u->id();
					config.key = u->key()->str();
					std::cout 
						<< u->id() 
						<< "\t" << u->key()->str() 
						<< std::endl;
				}
				else
				{
					std::cerr << cli.url << " HTTP code " << cli.code << ": " << cli.retval << std::endl;
				}
			}
			break;
		case CMD_ADD_FRIDGE:
			{
				const Fridge *f = cli.add_fridge(config.user_id, config.cn, config.key, config.locale,
					config.lat, config.lon, config.alt, config.cost);
				if (f)
				{
					config.user_id = f->id();
					config.key = f->key()->str();
					std::cout << f->id() 
						<< "\t" << f->key()->str() 
						<< std::endl;
				}
				else
				{
					std::cerr << cli.url << " HTTP code " << cli.code << ": " << cli.retval << std::endl;
				}
			}
			break;
		case CMD_ADD_FRIDGEUSER:
			{
				const FridgeUser *f = cli.add_fridge_user(config.user_id, config.fridge_id, config.cost);
				if (f)
				{
					std::cout 
						<< f->fridgeid() << "\t"
						<< f->user()->id() << "\t"
						<< f->start() << "\t" 
						<< f->finish() << std::endl;
				}
				else
				{
					std::cerr << cli.url << " HTTP code " << cli.code << ": " << cli.retval << std::endl;
				}
			}
			break;
		case CMD_ADD_MEAL:
			{
				const Meal *m = cli.add_meal(config.cn, config.locale);
				if (m)
				{
					std::cout << m->id() << "\t" << m->cn()->str() << "\t" << m->locale()->str() << std::endl;
				}
				else
				{
					std::cerr << cli.url << " HTTP code " << cli.code << ": " << cli.retval << std::endl;
				}
			}
			break;
		case CMD_ADD_MEALCARD:
		{
			const MealCard *mc = cli.add_mealcard(config.fridge_id, config.meal_id, config.qty);
			if (mc)
			{
				std::cout << mc->meal()->id() << "\t" 
					<< (int) mc->qty() << std::endl;
			}
			else
			{
				std::cerr << cli.url << " HTTP code " << cli.code << ": " << cli.retval << std::endl;
			}
		}
		break;
		case CMD_ADD_PURCHASE:
			{
				const Purchase *p = cli.add_purchase(config.user_id, config.fridge_id, config.meal_id, config.cost, config.qty);
				if (p)
				{
					std::cout << p->id() << "\t" << p->start() << "\t" << p->finish() << std::endl;
				}
				else
				{
					std::cerr << cli.url << " HTTP code " << cli.code << ": " << cli.retval << std::endl;
				}
			}
			break;
		case CMD_ADD_VOTE:
			{
				uint64_t vote_id = cli.add_vote(config.user_id, config.purchase_id);
				if (vote_id)
				{
					std::cout << vote_id << std::endl;
				}
				else
				{
					std::cerr << cli.url << " HTTP code " << cli.code << ": " << cli.retval << std::endl;
				}
			}
			break;
		case CMD_RM_FRIDGE:
			{
				bool v = cli.rm_fridge(config.fridge_id);
				if (v)
				{
					std::cout << "Fridge deleted" << std::endl;
				}
				else
				{
					std::cerr << cli.url << " HTTP code " << cli.code << ": " << cli.retval << std::endl;
				}
			}
			break;
		case CMD_RM_FRIDGEUSER:
			{
				const Payments *p = cli.rm_fridgeuser(config.fridge_id, config.user_id);
				if (p)
				{
					std::cout << "Fridge user deleted" << std::endl;
					
					for (auto it(p->payments()->begin()); it != p->payments()->end(); ++it)
					{
						std::cout 
							<< it->total() << "\t"
							<< it->fridge()->id() << "\t"
							<< it->fridge()->cn()->str() << "\t"
							<< it->user()->id() << "\t"
							<< it->user()->cn()->str() << "\t"
							<< std::endl;
					}
				}
				else
				{
					std::cerr << cli.url << " HTTP code " << cli.code << ": " << cli.retval << std::endl;
				}
			}
			break;
		case CMD_RM_PURCHASE:
			{
				bool v = cli.rm_purchase(config.purchase_id);
				if (v)
				{
					std::cout << "Purchase deleted" << std::endl;
				}
				else
				{
					std::cerr << cli.url << " HTTP code " << cli.code << ": " << cli.retval << std::endl;
				}
			}
			break;
		case CMD_RM_VOTE:
			{
				bool v = cli.rm_vote(config.user_id, config.purchase_id);
				if (v)
				{
					std::cout << "Vote deleted" << std::endl;
				}
				else
				{
					std::cerr << cli.url << " HTTP code " << cli.code << ": " << cli.retval << std::endl;
				}
			}
			break;
		default:
		// case CMD_MEAL
			break;
	}

	return 0;
}

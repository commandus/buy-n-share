SUBDIRS = .
ACLOCAL_AMFLAGS = -I m4

if DEBUG
commoncppflags = -std=c++11 -g3 -O0 -I gen
else
commoncppflags = -std=c++11 -O2 -I gen
endif

#
#	Generate flatc
#
fbs = \
	fbs/buynshare.fbs fbs/user.fbs fbs/users.fbs fbs/fridge.fbs fbs/fridges.fbs fbs/meal.fbs fbs/purchase.fbs \
	fbs/mealcard.fbs fbs/fridgemealcards.fbs fbs/fridgeuser.fbs fbs/fridgeusers.fbs fbs/userfridges.fbs \
	fbs/purchases.fbs fbs/fridgepurchases.fbs fbs/userpurchases.fbs fbs/meals.fbs
gen = gen/buynshare_generated.h
$(gen): Makefile
	mkdir -p gen
	flatc --cpp -o gen $(fbs)

gen_php = php/bs/Fridge.php php/bs/FridgeMealCards.php  php/bs/FridgePurchases.php  php/bs/FridgeUser.php \
	php/bs/Geo.php php/bs/Meal.php php/bs/Purchases.php php/bs/User.php php/bs/Users.php \
	php/bs/Fridges.php php/bs/FridgeUsers.php php/bs/MealCard.php \
	php/bs/Purchase.php php/bs/UserFridges.php php/bs/UserPurchases.php php/bs/Meals.php
	
$(gen_php): Makefile
	mkdir -p php
	flatc --php -o php $(fbs)

#
#	Exclude generated sources from distribution
#
nodist_buy_n_share_SOURCES = $(gen) $(gen_php)
BUILT_SOURCES = $(gen) $(gen_php)
CLEANFILES =

#
#	Binaries
#
bin_PROGRAMS = buy-n-share
nobase_dist_include_HEADERS = \
	buy-n-share.h buy-n-share-config.h fbclient.h

common_src = 

commonlibs = -L/usr/local/lib/ -largtable2 -lcurl

#
#	buy_n_share
#
buy_n_share_SOURCES = \
	buy-n-share-config.cpp buy-n-share.cpp fbclient.cpp \
	$(common_src)

buy_n_share_LDADD = $(commonlibs)
buy_n_share_CPPFLAGS = $(commoncppflags)

#
#	Configs, readme, CMake etc.
#
configdir = $(datadir)
dist_config_DATA = \
	README.md HISTORY \
	$(fbs) \
	.kdev_include_paths \
	docs/README.md docs/_layouts/default.html \
	php/add_fridge.php  php/add_fridgeuser.php  php/add_user.php  php/buynshare.php  php/env.php  php/index.php  php/ls_fridge.php  php/ls_fridgeuser.php  php/ls_user.php

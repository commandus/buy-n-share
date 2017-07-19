SUBDIRS = .
ACLOCAL_AMFLAGS = -I m4

if DEBUG
commoncppflags = -std=c++11 -g3 -O0
else
commoncppflags = -std=c++11 -O2
endif

#
#	Generate flatc
#
fbs = buynsharefbs
gen = buynshare_generated.h
$(gen): Makefile
	flatc --cpp $(fbs)

#
#	Exclude generated sources from distribution
#
nodist_buy_n_share_SOURCES = buynshare_generated.h
BUILT_SOURCES =
CLEANFILES =

#
#	Binaries
#
bin_PROGRAMS=buy-n-share
nobase_dist_include_HEADERS = \
	buy-n-share.h buy-n-share-config.h 

common_src = 

commonlibs = -L/usr/local/lib/ -largtable2 -lcurl

#
#	buy_n_share
#
buy_n_share_SOURCES= \
	buy-n-share-config.cpp  buy-n-share.cpp \
	$(common_src)

buy_n_share_LDADD = $(commonlibs)
buy_n_share_CPPFLAGS = $(commoncppflags)

#
#	Configs, readme, CMake etc.
#
configdir = $(datadir)
dist_config_DATA = \
	README.md HISTORY buynshare.fbs \
	.kdev_include_paths

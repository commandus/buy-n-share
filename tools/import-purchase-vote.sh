#!/bin/bash
#	Import meal
#	./import-meal <locale> <CSV file>
LOCALE=$1
INPUT=$2
CLI=../buy-n-share
OLDIFS=$IFS
IFS=,
[ ! -f $INPUT ] && { echo "$INPUT file not found"; exit 1; }

TMP_MEAL=$INPUT.tmp
if [ -f $TMP_MEAL ]; then
	rm $TMP_MEAL
fi

while read dt meal share1 share2 share3 share4 share5
do
	echo $meal >> $TMP_MEAL
done < $INPUT

sort -u $TMP_MEAL > $TMP_MEAL.s
rm $TMP_MEAL

INPUT=$TMP_MEAL.s
while read meal
do
	$CLI --add meal -e $LOCALE -n "$meal"
	echo $meal
done < $INPUT

rm $TMP_MEAL.s

IFS=$OLDIFS
exit 0
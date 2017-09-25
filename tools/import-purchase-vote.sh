#!/bin/bash
#	Import purchases and votes
#	./import-purchase-vote.sh <locale> <fridge_id> <CSV file> <uid1> <uid2> <uid3> <uid4> <uid5>
#
CLI=../buy-n-share
LOCALE=$1
FRIDGE_ID=$2
INPUT=$3
UID1=$4
UID2=$5
UID3=$6
UID4=$7
UID5=$8
OLDIFS=$IFS

[ ! -f $INPUT ] && { echo "$INPUT file not found"; exit 1; }

# get meal identifiers
$CLI --ls meal -e $LOCALE > $INPUT.tmp

declare -A MEALS
while read id cn locale
do
	MEALS[ "${cn}" ]=$id
done < $INPUT.tmp

uids=([0]=$UID1 [1]=$UID2 [2]=$UID3 [3]=$UID4 [4]=$UID5)
IFS=,
while read dt meal share1 share2 share3 share4 share5 vote1 vote2 vote3 vote4 vote5 etc
do
	shares=([0]=$share1 [1]=$share2 [2]=$share3 [3]=$share4 [4]=$share5)
	votes=([0]=$vote1 [1]=$vote2 [2]=$vote3 [3]=$vote4 [4]=$vote5)
	mealid=${MEALS[ "$meal" ]}
	for (( i = 0; i < 5; i++ )) ; do
		if [ ${shares[$i]} > 0 ]; then
			echo purchase $mealid ${uids[$i]} ${shares[$i]}
			r=`$CLI --add purchase -m $mealid -i ${uids[$i]} -f $FRIDGE_ID -q 1 -c ${shares[$i]}`
			purchase_id=`echo $r | cut -f1 -d$'\t'`
			echo $purchase_id
			for (( i = 0; i < 5; i++ )) ; do
				if [ ${votes[$i]} -gt 0 ]; then
					for (( v = 0; v < ${votes[$i]}; v++ )) ; do
						echo vote $purchase_id $mealid ${uids[$i]}
						r=`$CLI --add vote -i ${uids[$i]} -p $purchase_id`
						echo $r
					done
				fi
			done
		fi
	done
done < $INPUT
IFS=$OLDIFS

exit 0

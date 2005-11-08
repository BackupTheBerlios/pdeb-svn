#!/bin/sh

u1="pdeb"
p1="x"

cd /home/users/mferra/pdeb

curl -s -o unstable.gz http://merkel.debian.org/~barbier/l10n/material/data/unstable.gz
gunzip -f unstable.gz

# updates

python debconf.py > x.sql
mysql --database=pdeb -h db.berlios.de --user=$u1 --password=$p1 < x.sql

rm -rf x.sql

# delete oldies

mysql --database=pdeb -h db.berlios.de --user=$u1 --password=$p1 -e "select * from pacote" -s > x.txt
python debconf_oldies.py < x.txt > xx.txt

mysql --database=pdeb -h db.berlios.de --user=$u1 --password=$p1 < xx.txt

rm -rf x.txt xx.txt


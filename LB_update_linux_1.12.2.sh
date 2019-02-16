curl http://henrydatei.bplaced.net/alts/vollerzugriff.php >> /dev/null

cd ~/.minecraft/instances/liquidbounce1.12/LiquidBounce-1.12.2
rm accounts.json
rm friends.json
cd ..
rm servers.dat
wget http://henrydatei.bplaced.net/alts/data/accounts.json -P ~/.minecraft/instances/liquidbounce1.12/LiquidBounce-1.12.2
wget http://henrydatei.bplaced.net/alts/data/friends.json -P ~/.minecraft/instances/liquidbounce1.12/LiquidBounce-1.12.2
wget http://henrydatei.bplaced.net/alts/data/servers.dat -P ~/.minecraft/instances/liquidbounce1.12

wget http://henrydatei.bplaced.net/alts/data/LiquidBounce1.12.2.jar -P ~/.minecraft/instances/liquidbounce1.12.2/mods

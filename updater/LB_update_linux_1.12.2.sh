curl http://deine-domain.de/alts/ >> /dev/null

cd ~/.minecraft/instances/liquidbounce1.12/LiquidBounce-1.12.2
rm accounts.json
rm friends.json
cd ..
rm servers.dat
wget http://deine-domain.de/alts/data/accounts.json -P ~/.minecraft/instances/liquidbounce1.12/LiquidBounce-1.12.2
wget http://deine-domain.de/alts/data/friends.json -P ~/.minecraft/instances/liquidbounce1.12/LiquidBounce-1.12.2
wget http://deine-domain.de/alts/data/servers.dat -P ~/.minecraft/instances/liquidbounce1.12

wget http://deine-domain.de/alts/data/LiquidBounce1.12.2.jar -P ~/.minecraft/instances/liquidbounce1.12.2/mods

curl http://deine-domain.de/alts/ >> /dev/null

cd ~/.minecraft/instances/liquidbounce1.8.8/mods
rm LiquidBounce1.8.9.jar
cd ..

cd LiquidBounce-1.8
rm accounts.json
rm friends.json
rm values.json
rm clickgui.json
rm modules.json
rm hud.json
rm xray.json
rm proxies.json
rm -r settings

cd ..
rm servers.dat
rm options.txt
rm optionsof.txt
wget http://deine-domain.de/alts/data/accounts.json -P ~/.minecraft/instances/liquidbounce1.8.8/LiquidBounce-1.8
wget http://deine-domain.de/alts/data/friends.json -P ~/.minecraft/instances/liquidbounce1.8.8/LiquidBounce-1.8
wget http://deine-domain.de/alts/data/values.json -P ~/.minecraft/instances/liquidbounce1.8.8/LiquidBounce-1.8
wget http://deine-domain.de/alts/data/clickgui.json -P ~/.minecraft/instances/liquidbounce1.8.8/LiquidBounce-1.8
wget http://deine-domain.de/alts/data/modules.json -P ~/.minecraft/instances/liquidbounce1.8.8/LiquidBounce-1.8
wget http://deine-domain.de/alts/data/hud.json -P ~/.minecraft/instances/liquidbounce1.8.8/LiquidBounce-1.8
wget http://deine-domain.de/alts/data/xray.json -P ~/.minecraft/instances/liquidbounce1.8.8/LiquidBounce-1.8
wget http://deine-domain.de/alts/data/proxies.json -P ~/.minecraft/instances/liquidbounce1.8.8/LiquidBounce-1.8

wget http://deine-domain.de/alts/data/servers.dat -P ~/.minecraft/instances/liquidbounce1.8.8
wget http://deine-domain.de/alts/data/options.txt -P ~/.minecraft/instances/liquidbounce1.8.8
wget http://deine-domain.de/alts/data/optionsof.txt -P ~/.minecraft/instances/liquidbounce1.8.8

wget http://deine-domain.de/alts/data/LiquidBounce1.8.9.jar -P ~/.minecraft/instances/liquidbounce1.8.8/mods
wget http://deine-domain.de/alts/data/settings/mineplex.txt -P ~/.minecraft/instances/liquidbounce1.8.8/LiquidBounce-1.8/settings
wget http://deine-domain.de/alts/data/settings/minesucht.txt -P ~/.minecraft/instances/liquidbounce1.8.8/LiquidBounce-1.8/settings
wget http://deine-domain.de/alts/data/settings/rewinside.txt -P ~/.minecraft/instances/liquidbounce1.8.8/LiquidBounce-1.8/settings
wget http://deine-domain.de/alts/data/settings/teamkyudo.txt -P ~/.minecraft/instances/liquidbounce1.8.8/LiquidBounce-1.8/settings
wget http://deine-domain.de/alts/data/settings/gc.txt -P ~/.minecraft/instances/liquidbounce1.8.8/LiquidBounce-1.8/settings
cd ~/.minecraft/instances/liquidbounce1.8.8/LiquidBounce-1.8/settings
mv mineplex.txt mineplex
mv minesucht.txt minesucht
mv rewinside.txt rewinside
mv teamkyudo.txt teamkyudo
mv gc.txt gc

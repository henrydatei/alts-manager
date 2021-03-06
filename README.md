# alts-manager

Diese Webseite verwaltet die Banns von verschiedenen Minecraft-Servern für verschiedene Accounts.

### Features
Die folgende Liste an Features ist unvollständig, wir haben hier die wichtigsten aufgelistet
- Anzeige aller Banns aller Accounts auf einen Blick
- Hinzufügen/Löschen von [Banns](https://github.com/henrydatei/alts-manager/wiki/API:-eintragen_get) per Hand oder per API
- Hinzufügen/Löschen von [Accounts](https://github.com/henrydatei/alts-manager/wiki/API:-Accounts-hinzufügen-und-entfernen) und [Servern](https://github.com/henrydatei/alts-manager/wiki/API:-Server-hinzufügen-und-entfernen) per Hand oder per API
- automatische Synchronisation der Webseite, falls diese von mehreren Benutzern gleichzeitig geöffnet ist
- automatisches Löschen der temporären Banns, wenn diese abgelaufen sind
- Anzeige der Accounts, die als nächstes frei werden
- Statistiken
- Updater/Installer des Minecraft Hack-Clients [LiquidBounce](https://liquidbounce.net) mit Config-Dateien
- automatische Erstellung von Account-Listen und Friend-Listen
- [Partymode](https://github.com/henrydatei/alts-manager/wiki/Partymode)
- Anzeige der Skins auf Knopfdruck
- Anzeige der Login-Daten auf Knopfdruck
- Link zu einer Einführung in LiquidBounce (das Repo dazu findet sich [hier](https://github.com/henrydatei/Erste-Schritte-in-Liquidbounce))

### Installation
Wir setzen voraus, dass du einen Webserver mit PHP und MySQL hast. Viele Webseite-Hoster haben so etwas kostenlos, wir sind sehr zufrieden mit [bplaced](https://www.bplaced.net).

1. Klone dieses Repository und erstelle darin eine Datei mit dem Namen `dbconnect.php`. Diese enthält die Zugangsdaten für den MySQL-Server. Der Inhalt dieser Datei ist
```php
<?php
$db = mysqli_connect("localhost", "USERNAME", "PASSWORT", "DATENBANKNAME");
if(!$db)
{
  exit("Verbindungsfehler: ".mysqli_connect_error());
}
?>
```
2. Erstelle auf dem Webserver ein Verzeichnis mit dem Namen `alts`.
3. Kopiere alle Daten in dieses Verzeichnis.
4. Im [Wiki](https://github.com/henrydatei/alts-manager/wiki/Datenbank-Einrichtung) haben wir ein Skript für die Einrichtung der Datenbanken veröffentlicht. Lade es dir herunter, modifiziere es entsprechend der Anleitung im Wiki und führe es in der Weboberfläche deines MySQL-Servers aus.
5. Du kannst nun unter `http://deine-domain.endung/alts` die Verwaltung aufrufen und alles nach deinen Wünschen einrichten. Wenn du deine Accounts hinzufügen willst, füge diese zuerst hinzu und lösche dann die Test-Accounts. Wir wissen nämlich nicht was passiert, wenn die Datenbanken leer sind.

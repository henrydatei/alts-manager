<?php
include("dbconnect.php");

$alts=array();
$namen=mysqli_query($db, "DESCRIBE `alts` ");
while($infos=mysqli_fetch_array($namen)) {
	array_push($alts,$infos[Field]);
}
$anzahl=count($alts);

$handle=fopen("data/friends.json", w);
for ($a=0; $a<($anzahl-2) ; $a++) {
	$inhalt=$alts[$a].":".$alts[$a];
	fwrite($handle, $inhalt);
	fwrite($handle, "\n");
}

fwrite($handle, "Tarummel:Tarummel");
fwrite($handle, "\n");
fwrite($handle, "The_MaximusVA:The_MaximusVA");
fwrite($handle, "\n");

fclose($handle);
?>


<!-- Altlist-Generator -->
<?php
//Arrays generieren
$accName=array();
$accLogin=array();
$accPwd=array();
//Angezeigten Namen in Array auslesen
$query = mysqli_query($db, "SELECT displayed_name FROM accounts");
while($row = mysqli_fetch_array($query))
{
   $accName[] = $row['displayed_name'];
}
//Login (E-mail) in Array auslesen
$query2 = mysqli_query($db, "SELECT username FROM accounts");
while($row = mysqli_fetch_array($query2))
{
   $accLogin[] = $row['username'];
}
//Passwort in Array auslesen
$query3 = mysqli_query($db, "SELECT password FROM accounts");
while($row = mysqli_fetch_array($query3))
{
   $accPwd[] = $row['password'];
}
//Anzahl-Variable
$accCount=count($accLogin);

$handle2=fopen("data/accounts.json", w);
fwrite($handle2, "[");
fwrite($handle2, "\n");

fwrite($handle2, "\"MsBrony::\",");
fwrite($handle2,"\n");

for ($a=0; $a<=($accCount-1) ; $a++) {
	//$inhalt2="  ".$accLogin[$a].":".$accPwd[$a].":".$accName[$a].",";
	$inhalt2 = "  \"$accLogin[$a]:$accPwd[$a]:$accName[$a]\",";

	if ($a==($accCount-1)) {
		$inhalt2 = substr($inhalt2,0,-1);
	}

	fwrite($handle2, $inhalt2);
	fwrite($handle2, "\n");
}

fwrite($handle2, "]");
fclose($handle2);

//altliste zum regelmaessigen Probieren erstellen
$handle3=fopen("altliste.txt", w);
for ($b=0; $b<=($accCount-1) ; $b++) {
	//$inhalt3= accLogin:accPwd
	$inhalt3 = "$accLogin[$b]:$accPwd[$b] \n";
	fwrite($handle3, $inhalt3);
}
fclose($handle3);

?>

<!-- Username und Passwort in Array schreiben für TH-Zellen -->
<?php
$benutzer = array();
$passwoerter = array();
$zugangsdaten = mysqli_query($db, "SELECT username, password FROM accounts");
$benutzer[] = 'ParaCookie';
$passwoerter[] = '***';
$benutzer[] = 'cl0rm';
$passwoerter[] = '***';
while ($zeilen = mysqli_fetch_object($zugangsdaten)) {
		$benutzer[] = $zeilen->username;
		$passwoerter[] = $zeilen->password;
}
 ?>

<!-- Funktion für eine schoene Ausgabe der gesamten Banzeit-->
<?php
function sekundentoalles($zeitInSekunden) {
	if($zeitInSekunden >= 86400) {
		$anzahlTage = ($zeitInSekunden - $zeitInSekunden%86400)/86400;
		$zeitInSekunden = $zeitInSekunden - $anzahlTage * 86400;
	}
	if($zeitInSekunden >= 3600) {
		$anzahlStunden = ($zeitInSekunden - $zeitInSekunden%3600)/3600;
		$zeitInSekunden = $zeitInSekunden - $anzahlStunden * 3600;
	}
	if($zeitInSekunden >= 60) {
		$anzahlMinuten = ($zeitInSekunden - $zeitInSekunden%60)/60;
		$zeitInSekunden = $zeitInSekunden - $anzahlMinuten * 60;
	}
	return "$anzahlTage Tage, $anzahlStunden Stunden, $anzahlMinuten Minuten und $zeitInSekunden Sekunden";
}
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">

<head>
    <title>Der organisierte Hacker</title>

    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="keywords" content="" />
    <meta name="generator" content="Webocton - Scriptly (www.scriptly.de)" />

    <link href="style.css" type="text/css" rel="stylesheet" />
</head>

<body>
	<div id="header">
		<div align="center" id="header-schrift">Der organisierte Hacker</div>
	</div>

	<div id="main">
		<div id="anleitung">
			<table align="center" style="width: 80%">
				<tr>
					<td>
						<ul>
							<li><a href="neuerAlt.php">Neuer Alt</a></li>
							<li><a href="neuerServer.php">Neuer Server</a></li>
							<li><a href="Altweg.php">Alt l&ouml;schen</a></li>
						</ul>
					</td>
					<form action="eintragen.php" method="post">
						<td>
							<h3>neuer Bann:</h3>
							<table>
								<tr>
									<td>Alt:</td>
									<td>
										<select name="alt">
											<<?php
												for ($l=0; $l<($anzahl-2) ; $l++) {
													if ($alts[$l] == $_GET['alt']) {
														print "<option selected>$alts[$l]</option>";
													} else {
														print "<option>$alts[$l]</option>";
													}

												}
											 ?>
										</select>
									</td>
								</tr>
								<tr>
									<td>Server:</td>
									<td>
										<select name="server">
											<?php
												$anfrage=mysqli_query($db, "SELECT `server` FROM `alts`");
												while ($zeile=mysqli_fetch_object($anfrage)) {
													$aktuellerServer = $zeile->server;
													if ($aktuellerServer == $_GET['server']) {
														print "<option selected>$aktuellerServer</option>";
													} else {
														print "<option>$aktuellerServer</option>";
													}
												}
											 ?>
										</select>
									</td>
								</tr>
							</table>
						</td>
						<td>
							<table>
								<tr>
									<td>Datum:</td>
									<td><input type="text" name="dauer" placeholder="JJJJ-MM-DD HH:MM:SS" /></td>
								</tr>
								<tr>
									<td>Permanent:</td>

									<?php
									if ($_GET['perma'] == 1) {
										print "<td><input type=\"checkbox\" name=\"perma\" value=\"perma\" checked /></td>";
									} else {
										print "<td><input type=\"checkbox\" name=\"perma\" value=\"perma\" /></td>";
									}

									?>
								</tr>
								<tr>
									<td>Anzahl Tage:</td>
									<td><input type="text" name="anzahl" placeholder="auch gebr. Zahlen mit Komma möglich" /></td>
								</tr>
								<tr>
									<td></td>
									<td><input type="submit" name="s" value="absenden" /></td>
								</tr>
							</table>
						</td>
					</form>
				</tr>
			</table>
<p></p>
<p></p>
<p></p>



		</div>

		<div id="text" align="center">
			<table border="1px" id="bantabelle">
				<tr>
					<?php
					for($j=0;$j<=($anzahl-3);$j++) {
						print "<th title=\"$benutzer[$j]:$passwoerter[$j]\">$alts[$j]</th>";
					}
					print "<th>Server</th>";
					?>
					</tr>
					<?php
					$zeiten=array();
					$zeitenserver=array();
					$zeitenalts=array();
					$time=time();
					for($j=0;$j<=($anzahl-3);$j++) {
						$aktuell=$alts[$j];
						$updatesql="SELECT `$aktuell`,`server` FROM alts";
						$update=mysqli_query($db, $updatesql);
						while($ueberpruefen=mysqli_fetch_array($update)) {
							$serverban=$ueberpruefen['server'];
							$temp=$ueberpruefen[$aktuell];
							if($temp!="" && $temp!="9999-12-31 23:59:59") {
								$ban=strtotime($temp);
								if($time>$ban) {
									print "$aktuell wurde auf Server $serverban geupdatet";
									print "<br />";

									$updateidsql="SELECT `id` FROM `alts` WHERE `server` = '$serverban'";
									$updateidres=mysqli_query($db, $updateidsql);
									$updateidobj=mysqli_fetch_object($updateidres);
									$updateid=$updateidobj->id;
									$weg="UPDATE `henrydatei`.`alts` SET `$aktuell` = NULL WHERE `alts`.`id` =$updateid";
									$wegres=mysqli_query($db, $weg);
								}

							}
						}
					}

					$anzahlTempBans = 0;
					$anzahlPermaBans = 0;
					$gesamteTempBanZeit = 0;
					$anzahlFrei = 0;
					$abfrage="SELECT * FROM alts";
					$ergebnis=mysqli_query($db, $abfrage);
					while($row=mysqli_fetch_array($ergebnis)) {
						print "<tr>";
						for($j=0;$j<=($anzahl-3);$j++) {
							$jetzt=$alts[$j];
							$werta=$row[$jetzt];
								if($werta=="") {
									$ausgabea="frei";
									$bgcolora="#00FF00";
									$anzahlFrei = $anzahlFrei +1;
								}
								if($werta=="9999-12-31 23:59:59") {
									$ausgabea="Permanent gebannt";
									$bgcolora="#FF0000";
									$anzahlPermaBans = $anzahlPermaBans +1;
								}
								if($werta!='' && $werta!="9999-12-31 23:59:59") {
									$getrennta=explode(' ', $werta);
									$datuma=explode('-', $getrennta[0]);
									$uhrzeita=explode(':', $getrennta[1]);
									$ausgabea=$datuma[2].'.'.$datuma[1].'.'.$datuma[0].' '.$uhrzeita[0].':'.$uhrzeita[1].':'.$uhrzeita[2];
									$bgcolora="#FFFF00";
									$anzahlTempBans = $anzahlTempBans +1;
									$gesamteTempBanZeit = $gesamteTempBanZeit + abs(strtotime($werta) - time());

									$zeiten[]=strtotime($werta);
									$zeitenalts[]=$jetzt;
									$zeitenserver[]=$row['server'];
								}
								print "<td style=\"background-color: $bgcolora;\" id=\"zelle\">$ausgabea</td>";
						}
						$srvr=$row['server'];
						print "<td><b>$srvr</b></td>";
						print "</tr>";
					}

					print "<tr>";
					for ($k=0; $k < $anzahl-2; $k++) {
						print "<td>";
						print "<iframe src=\"https://mineskin.de/armor/body/$alts[$k]/50.png\" style=\"width: 70px; height: 120px; border: 0px solid white\"></iframe>";
						print "</td>";
					}
					print "</tr>";
					?>
			</table>

			<p></p>
			<p></p>
			<p></p>


			<span style="text-align: center"><h3>n&auml;chste Entbannungen:</h3></span>
				<?php
				asort($zeiten);
				for ($k=0; $k < 5; $k++) {
						$bannummer=key($zeiten);
						$endpunktunix=$zeiten[$bannummer];
						$endpunktreal=date("d.m.Y H:i:s", $endpunktunix);
						$banserver=$zeitenserver[$bannummer];
						$banalt=$zeitenalts[$bannummer];
						print "$banalt ist noch bis zum $endpunktreal vom Server $banserver gebannt.";
						print "<br />";
						next($zeiten);
				}

				?>

				<p></p>
				<p></p>
				<p></p>
				<span style="text-align: center"><h3>Stats &uuml;ber unsere Alts:</h3></span>
				<p>
					<table>
						<tr>
							<td>Anzahl freie Pl&auml;tze:</td>
							<td><?php print $anzahlFrei; ?></td>
						</tr>
						<tr>
							<td>Anzahl Temp-Bans:</td>
							<td><?php print $anzahlTempBans; ?></td>
						</tr>
						<tr>
							<td>restliche Banzeit:</td>
							<td><?php print sekundentoalles($gesamteTempBanZeit); ?></td>
						</tr>
						<tr>
							<td>Anzahl Perma-Bans:</td>
							<td><?php print $anzahlPermaBans; ?></td>
						</tr>
					</table>
				</p>
				<span style="text-align: center"><h3>Updater-Skripts:</h3></span>
				<p><a href="http://henrydatei.bplaced.net/alts/lb.exe" style="text-align: center">vollständiger 1.8.x Installer / Updater (Windows)</a> (Passwort für Alts: "henrydatei")<br>
				<a href="http://henrydatei.bplaced.net/alts/lb12.exe" style="text-align: center">vollständiger 1.12.x Installer / Updater (Windows)</a> (Passwort für Alts: "henrydatei")<br>
				<a href="http://henrydatei.bplaced.net/alts/updateWin.exe" style="text-align: center">Updater für die Konfigurationsdateien 1.8.x (Windows)</a><br>
				<a href="http://henrydatei.bplaced.net/alts/updateWin12.exe" style="text-align: center">Updater für die Konfigurationsdateien 1.12.x (Windows)</a>
				</p>
				<p>
				<a href="http://henrydatei.bplaced.net/alts/LB_update_mac_1.8.9.sh" style="text-align: center">Updater für die Konfigurationsdateien 1.8.x (Mac)</a>
				</p>
				<p>
				<a href="http://henrydatei.bplaced.net/alts/LB_update_linux_1.8.9.sh" style="text-align: center">Updater für die Konfigurationsdateien 1.8.x (Linux)</a><br>
				<a href="http://henrydatei.bplaced.net/alts/LB_update_linux_1.12.2.sh" style="text-align: center">Updater für die Konfigurationsdateien 1.12.x (Linux)</a>
				</p>
				<span style="text-align: center"><h3>Tastaturbelegung</h3></span>
				<img src="KB.png" alt="" width="80%">
				
				<p></p>
				<p></p>
				<p></p>
				<span style="text-align: center"><h3>Anfängerguide:</h3></span>
				<ul>
					<li>PDF-Version: <a href="Anfaengerguide.pdf">Anfaengerguide.pdf</a></li>
					<li>Version zum Editieren: <a href="https://drive.google.com/open?id=1tLHgeR2YrgrjGCbg_VvuUKD0uOCNOu_aXGCzkw0AqoY">https://drive.google.com/open?id=1tLHgeR2YrgrjGCbg_VvuUKD0uOCNOu_aXGCzkw0AqoY</a></li>
				<ul>

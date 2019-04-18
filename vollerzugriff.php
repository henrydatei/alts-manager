<?php
include("dbconnect.php");
include("functions.php");

$alts = array();
$namen = mysqli_query($db, "DESCRIBE `alts` ");
while($infos = mysqli_fetch_array($namen)) {
	array_push($alts,$infos[Field]);
}
$anzahl = count($alts);

$servers = array();
$sql = "SELECT `server` FROM `alts`";
$back = mysqli_query($db, $sql);
while ($row = mysqli_fetch_array($back)) {
  $servers[] = $row['server'];
}
$anzahl_server = count($servers);

// Listen erzeugen
include("create_lists.php");
?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link href="style.css" type="text/css" rel="stylesheet" />
    <title>Der organisierte Hacker</title>
		<script src="autoupdate.js" charset="utf-8" defer="defer"></script>
		<link rel="shortcut icon" href="favicon.ico" />
  </head>
  <body>
    <div id="header">
  		<div align="center" id="header-schrift">Der organisierte Hacker</div>
  	</div>

    <main>
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
  												for ($l = 0; $l < ($anzahl-2); $l++) {
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
  												$anfrage = mysqli_query($db, "SELECT `server` FROM `alts`");
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
        <p></p><p></p><p></p>
  		</div>

      <?php
			// Entbannung von abgelaufenen Bans
      for ($i = 0; $i < $anzahl-3; $i++) {
        // einmal durch alle Alts laufen
        $serverid = 0;
        $sql = "SELECT `$alts[$i]` FROM `alts`";
        $back = mysqli_query($db, $sql);
        while ($row = mysqli_fetch_array($back)) {
          $ban_ends = strtotime($row[$alts[$i]]);
          if (time() > $ban_ends && $row[$alts[$i]] != "" && $row[$alts[$i]] != "9999-12-31 23:59:59") {
            print "<div class=\"message\">";
            print "$alts[$i] wurde auf $servers[$serverid] entbannt.";
            print "</div>";

            $sql = "SELECT `id` FROM `alts` WHERE `server` = '$servers[$serverid]'";
            $back = mysqli_query($db, $sql);
            $row = mysqli_fetch_array($back);
            $serverID = $row['id'];
            $weg="UPDATE `henrydatei`.`alts` SET `$alts[$i]` = NULL WHERE `alts`.`id` = $serverID";
            $wegres=mysqli_query($db, $weg);
          }
          $serverid++;
        }
      }
      ?>

			<?php
			// Message nachdem neuner Bann eingetragen wurde: Gelb: temporär, Rot: permanent
			$gebannterAlt = $_GET['alt'];
			$gebannterServer = $_GET['server'];
			$permanent = $_GET['perma'];
			if ($permanent == 1) {
				// permanenter Bann -> rote Box
				print "<div class=\"permanent\">";
				print "$gebannterAlt wurde auf $gebannterServer permanent gebannt.";
				print "</div>";
			}
			if ($permanent === "0") {
				// temporaerer Bann -> gelbe Box
				print "<div class=\"temporaer\">";
				print "$gebannterAlt wurde auf $gebannterServer temporär gebannt.";
				print "</div>";
			}

			?>

      <div id="text" align="center">
        <table id="bantabelle" align="center">
          <tr>
            <th></th>
            <?php
						$freeArray = array();
						$tempArray = array();
						$permaArray = array();
  					for ($i = 0; $i < $anzahl_server; $i++) {
							$free = 0;
							$temp = 0;
							$perma = 0;
							$sql = "SELECT * FROM `alts` WHERE `server` = \"$servers[$i]\"";
							$back = mysqli_query($db, $sql);
							$row = mysqli_fetch_array($back);

							for ($j=0; $j < $anzahl - 2; $j++) {
							  $current_alt = $alts[$j];
							  if ($row["$current_alt"] == "") {
							    // alt ist frei
									$free = $free + 1;
							  }
								if ($row["$current_alt"] == "9999-12-31 23:59:59") {
							    // alt ist perma gebannt
									$perma = $perma + 1;
							  }
								if ($row["$current_alt"] != "9999-12-31 23:59:59" && $row["$current_alt"] != "") {
									// alt ist temp gebannt
									$temp = $temp + 1;
								}
							}

							$freeArray[] = $free;
							$tempArray[] = $temp;
							$permaArray[] = $perma;
							$rgbvalues = calcRGBlogistisch($anzahl - 2, $perma, $temp, $free);
              print "<th style=\"background-color: rgba($rgbvalues[0],$rgbvalues[1],$rgbvalues[2],0.5);\">$servers[$i]</th>";
							//print "<th>$servers[$i]</th>";
            }
  					?>
          </tr>
          <?php
					$zeiten = array();
					$zeitenserver = array();
					$zeitenalts = array();
					$anzahlTempBans = 0;
					$anzahlPermaBans = 0;
					$gesamteTempBanZeit = 0;
					$anzahlFrei = 0;
          for ($i = 0; $i < $anzahl-2; $i++) {
            // einmal durch alle Alts laufen
            $sql = "SELECT `$alts[$i]`,`server` FROM `alts`";
            $back = mysqli_query($db, $sql);
            print "<tr>";
            print "<td>$alts[$i]</td>";
            while ($row = mysqli_fetch_array($back)) {
              $banZelle = banZelle($row[$alts[$i]]);
              print "<td style=\"background-color: $banZelle[0];\" id=\"zelle\">$banZelle[1]</td>";
							if ($banZelle[2] == 1) {
								// Alt nur temp gebannt -> zum Array hinzufügen, damit dies später die nächsten Entbannungen anzeigen kann
								$zeiten[] = strtotime($row[$alts[$i]]);
						    $zeitenalts[] = $alts[$i];
						    $zeitenserver[] = $row['server'];

								$anzahlTempBans = $anzahlTempBans + 1;
								$gesamteTempBanZeit = $gesamteTempBanZeit + abs(strtotime($row[$alts[$i]]) - time());
							}
							if ($banZelle[2] == 0) {
								$anzahlFrei = $anzahlFrei + 1;
							}
							if ($banZelle[2] == 2) {
								$anzahlPermaBans = $anzahlPermaBans + 1;
							}
            }
            print "</tr>";
          }
					print "<tr>";
					print "<td></td>";
					for ($k=0; $k < $anzahl_server; $k++) {
						print "<td>";
						print "Free: $freeArray[$k], Temp: $tempArray[$k], Perma: $permaArray[$k]";
						print "</td>";
					}
					print "</tr>";
           ?>
        </table>
      </div>

			<section>
				<div class="ueberschrift">
					<h3>nächste Entbannungen</h3>
				</div>
				<div class="section_text">
					<?php
					asort($zeiten);
					for ($k=0; $k < 5; $k++) {
							$bannummer = key($zeiten);
							$endpunkt = date("d.m.Y H:i:s", $zeiten[$bannummer]);
							$banserver = $zeitenserver[$bannummer];
							$banalt = $zeitenalts[$bannummer];
							print "$banalt ist noch bis zum $endpunkt vom Server $banserver gebannt. <br>";
							next($zeiten);
					}
					?>
				</div>
			</section>

			<section>
				<div class="ueberschrift">
					<h3>Stats über unsere Alts</h3>
				</div>
				<div class="section_text">
					<table align="center">
						<tr>
							<td>Alts insgesamt:</td>
							<td><?php print $anzahl - 2; ?> (abzüglich 2 Main-Accounts)</td>
						</tr>
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
				</div>
			</section>

			<section>
				<div class="ueberschrift">
					<h3>Updater-Skripts</h3>
				</div>
				<div class="section_text">
					<p>
						<a href="http://henrydatei.bplaced.net/alts/lb.exe" target="_blank">vollständiger 1.8.x Installer / Updater (Windows)</a> (Passwort für Alts: "henrydatei")<br>
						<a href="http://henrydatei.bplaced.net/alts/lb12.exe" target="_blank">vollständiger 1.12.x Installer / Updater (Windows)</a> (Passwort für Alts: "henrydatei")<br>
						<a href="http://henrydatei.bplaced.net/alts/updateWin.exe" target="_blank">Updater für die Konfigurationsdateien 1.8.x (Windows)</a><br>
						<a href="http://henrydatei.bplaced.net/alts/updateWin12.exe" target="_blank">Updater für die Konfigurationsdateien 1.12.x (Windows)</a>
					</p>
					<p>
						<a href="http://henrydatei.bplaced.net/alts/LB_update_mac_1.8.9.sh" target="_blank">Updater für die Konfigurationsdateien 1.8.x (Mac)</a>
					</p>
					<p>
						<a href="http://henrydatei.bplaced.net/alts/LB_update_linux_1.8.9.sh" target="_blank">Updater für die Konfigurationsdateien 1.8.x (Linux)</a><br>
						<a href="http://henrydatei.bplaced.net/alts/LB_update_linux_1.12.2.sh" target="_blank">Updater für die Konfigurationsdateien 1.12.x (Linux)</a>
					</p>
				</div>
			</section>

			<section>
				<div class="ueberschrift">
					<h3>Tastaturbelegung</h3>
				</div>
				<div class="section_text">
					<img src="KB.png" alt="Tastaturbelegung" width="80%">
				</div>
			</section>

			<section>
				<div class="ueberschrift">
					<h3>Anfängerguide</h3>
				</div>
				<div class="section_text">
					PDF-Version: <a href="Anfaengerguide.pdf">Anfaengerguide.pdf</a><br>
					Version zum Editieren: <a href="https://drive.google.com/open?id=1tLHgeR2YrgrjGCbg_VvuUKD0uOCNOu_aXGCzkw0AqoY" target="_blank">https://drive.google.com/open?id=1tLHgeR2YrgrjGCbg_VvuUKD0uOCNOu_aXGCzkw0AqoY</a>
				</div>
			</section>
    </main>
  </body>
</html>

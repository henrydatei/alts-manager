<?php
include("dbconnect.php");
include("functions.php");
include("create_arrays.php");

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
    <script src="javascript.js" charset="utf-8" defer="defer"></script>
		<link rel="shortcut icon" href="media/favicon.ico" />
  </head>
  <body>
    <header>
      <div align="center" id="header-schrift">Der organisierte Hacker</div>
    </header>

    <main>
      <div class="control">
        <ul>
          <li><a href="newAlt/">Neuer Alt</a></li>
          <li><a href="newServer/">Neuer Server</a></li>
          <li><a href="removeAlt/">Alt löschen</a></li>
          <li><a href="removeServer/">Server löschen</a></li>
        </ul>
        <form method="post" action="eintragen.php"><table align="center">
          <tr>
            <td>Alt:</td>
            <td colspan="2">
              <select name="alt">
                <<?php
                  for ($l = 0; $l < $numberOfAllAccounts; $l++) {
                    if ($all_accounts[$l] == $_GET['alt']) {
                      print "<option selected>$all_accounts[$l]</option>";
                    } else {
                      print "<option>$all_accounts[$l]</option>";
                    }

                  }
                 ?>
              </select>
            </td>
          </tr>
          <tr>
            <td>Server:</td>
            <td colspan="2">
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
          <tr>
            <td>Datum:</td>
            <td colspan="2"><input type="text" name="dauer" placeholder="JJJJ-MM-DD HH:MM:SS" /></td>
          </tr>
          <tr>
            <td>Anzahl Tage:</td>
            <td><input type="text" name="anzahl" placeholder="auch gebr. Zahlen mit Komma möglich" /></td>
            <?php
            if ($_GET['perma'] == 1) {
              print "<td><input type=\"checkbox\" name=\"perma\" value=\"perma\" checked /> Permanent</td>";
            } else {
              print "<td><input type=\"checkbox\" name=\"perma\" value=\"perma\" /> Permanent</td>";
            }
            ?>
          </tr>
          <tr>
            <td></td>
            <td colspan="2"><input type="submit" name="s" value="Bann eintragen" /></td>
          </tr>
        </table></form>
        <ul>
          <li><a href="verlauf/">Verlauf</a></li>
        </ul>
      </div>

      <div class="options">
        <table>
          <tr>
            <td>Partymode: </td>
            <td>
              <select id="partymode">
                <option selected>/party </option>
                <option>/party invite </option>
                <option>kein Party Prefix</option>
              </select> + <i>Accountname</i>
            </td>
          </tr>
        </table>
        <table>
          <tr>
            <td>Skins: </td>
            <td id="showSkins"><button onclick="showAllSkins()">alle Skins zeigen (dauert lange)</button></td>
            <td id="hideSkins"><button onclick="unshowAllSkins()">alle Skins verstecken</button></td>
          </tr>
          <tr>
            <td>Login-Daten: </td>
            <td id="showLogin"><button onclick="showUserPass()">alle Login-Daten zeigen</button></td>
            <td id="hideLogin"><button onclick="hideUserPass()">alle Login-Daten verstecken</button></td>
          </tr>
        </table>
      </div>

      <?php
			// Entbannung von abgelaufenen Bans
      for ($i = 0; $i < $numberOfAllAccounts; $i++) {
        // einmal durch alle Alts laufen
        $serverid = 0;
        $sql = "SELECT `$all_accounts[$i]` FROM `alts`";
        $back = mysqli_query($db, $sql);
        while ($row = mysqli_fetch_array($back)) {
          $ban_ends = strtotime($row[$all_accounts[$i]]);
          if (time() > $ban_ends && $row[$all_accounts[$i]] != "" && $row[$all_accounts[$i]] != "9999-12-31 23:59:59") {
            print "<div class=\"message\">";
            print "$all_accounts[$i] wurde auf $servers[$serverid] entbannt.";
            print "</div>";

            $sql = "SELECT `id` FROM `alts` WHERE `server` = '$servers[$serverid]'";
            $back = mysqli_query($db, $sql);
            $row = mysqli_fetch_array($back);
            $serverID = $row['id'];
            $weg="UPDATE `alts` SET `$all_accounts[$i]` = NULL WHERE `alts`.`id` = $serverID";
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

							for ($j=0; $j < $numberOfAllAccounts; $j++) {
							  $current_alt = $all_accounts[$j];
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
							$rgbvalues = calcRGBlogistisch($numberOfAllAccounts, $perma, $temp, $free);
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
          for ($i = 0; $i < $numberOfAllAccounts; $i++) {
            // einmal durch alle Alts laufen
            $sql = "SELECT `$all_accounts[$i]`,`server` FROM `alts`";
            $back = mysqli_query($db, $sql);
            if ($i == $anzahl_mains - 1) {
              print "<tr class=\"after_main_accounts\">";
            } else {
              print "<tr>";
            }
            print "<td onclick=\"buildParty('$all_accounts[$i]')\" class=\"cursor\" id=\"$all_accounts[$i]\">";
            print "$all_accounts[$i]";
            print "<br class=\"userpass\">";
            print "<span class=\"userpass\">$usernames[$i]:$passwords[$i]</span>";
            print "<input type=\"hidden\" value=\"$all_accounts[$i]\" id=\"$all_accounts[$i]Party\"/>";
            print "</td>";
            while ($row = mysqli_fetch_array($back)) {
              $banZelle = banZelle($row[$all_accounts[$i]]);
              print "<td style=\"background-color: $banZelle[0];\" id=\"zelle\">$banZelle[1]</td>";
							if ($banZelle[2] == 1) {
								// Alt nur temp gebannt -> zum Array hinzufügen, damit dies später die nächsten Entbannungen anzeigen kann
								$zeiten[] = strtotime($row[$all_accounts[$i]]);
						    $zeitenalts[] = $all_accounts[$i];
						    $zeitenserver[] = $row['server'];

								$anzahlTempBans = $anzahlTempBans + 1;
								$gesamteTempBanZeit = $gesamteTempBanZeit + abs(strtotime($row[$all_accounts[$i]]) - time());
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
							<td><?php print $numberOfAllAccounts; ?> (abzüglich <?php print $anzahl_mains; ?> Main-Accounts)</td>
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
						<a href="updater/lb.exe" target="_blank">vollständiger 1.8.x Installer / Updater (Windows)</a> (Passwort für Alts: "henrydatei")<br>
						<a href="updater/lb12.exe" target="_blank">vollständiger 1.12.x Installer / Updater (Windows)</a> (Passwort für Alts: "henrydatei")<br>
						<a href="updater/updateWin.exe" target="_blank">Updater für die Konfigurationsdateien 1.8.x (Windows)</a><br>
						<a href="updater/updateWin12.exe" target="_blank">Updater für die Konfigurationsdateien 1.12.x (Windows)</a>
					</p>
					<p>
						<a href="updater/LB_update_mac_1.8.9.sh" target="_blank">Updater für die Konfigurationsdateien 1.8.x (Mac)</a>
					</p>
					<p>
						<a href="updater/LB_update_linux_1.8.9.sh" target="_blank">Updater für die Konfigurationsdateien 1.8.x (Linux)</a><br>
						<a href="updater/LB_update_linux_1.12.2.sh" target="_blank">Updater für die Konfigurationsdateien 1.12.x (Linux)</a>
					</p>
				</div>
			</section>

			<section>
				<div class="ueberschrift">
					<h3>Tastaturbelegung</h3>
				</div>
				<div class="section_text">
					<img src="media/KB.png" alt="Tastaturbelegung" width="80%">
				</div>
			</section>

			<section>
				<div class="ueberschrift">
					<h3>Anfängerguide</h3>
				</div>
				<div class="section_text">
					PDF-Version: <a href="media/Anfaengerguide.pdf">Anfaengerguide.pdf</a><br>
					Version zum Editieren: <a href="https://drive.google.com/open?id=1tLHgeR2YrgrjGCbg_VvuUKD0uOCNOu_aXGCzkw0AqoY" target="_blank">https://drive.google.com/open?id=1tLHgeR2YrgrjGCbg_VvuUKD0uOCNOu_aXGCzkw0AqoY</a>
				</div>
			</section>
    </main>
    <hr>
    <footer>
      Made by henrydatei and cl0rm |
      <a href="https://github.com/henrydatei/alts-manager" target="_blank">GitHub</a> |
      2017 - <?php print date("Y",time()); ?>
    </footer>
  </body>
  <!-- Zeug für javascript !-->
  <div class="unsichtbar">
    <?php
    $AccountNamenString = $all_accounts[0];
    for ($i=1; $i <= $numberOfAllAccounts - 1; $i++) {
      $AccountNamenString = $AccountNamenString." ".$all_accounts[$i];
    }
     ?>
    <input type="hidden" name="accountList" id="accountList" value="<?php print $AccountNamenString; ?>">
  </div>
</html>

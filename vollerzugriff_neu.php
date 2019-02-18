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
    <link href="style_neu.css" type="text/css" rel="stylesheet" />
    <title>Der organisierte Hacker</title>
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

      <div id="text" align="center">
        <table id="bantabelle" align="center">
          <tr>
            <th></th>
            <?php
  					for ($i = 0; $i < $anzahl_server; $i++) {
              print "<th>$servers[$i]</th>";
            }
  					?>
          </tr>
          <?php
          for ($i = 0; $i < $anzahl-3; $i++) {
            // einmal durch alle Alts laufen
            $sql = "SELECT `$alts[$i]` FROM `alts`";
            $back = mysqli_query($db, $sql);
            print "<tr>";
            print "<td>$alts[$i]</td>";
            while ($row = mysqli_fetch_array($back)) {
              $banZelle = banZelle($row[$alts[$i]]);
              print "<td style=\"background-color: $banZelle[0];\" id=\"zelle\">$banZelle[1]</td>";
            }
            print "</tr>";
          }
           ?>
        </table>
      </div>
    </main>
  </body>
</html>

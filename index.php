<?php
include("dbconnect.php");

$alts=array();
$namen=mysqli_query($db, "DESCRIBE `alts` ");
while($infos=mysqli_fetch_array($namen)) {
	array_push($alts,$infos[Field]);
}
$anzahl=count($alts);
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

<p></p>
<p></p>
<p></p>



		</div>

		<div id="text" align="center">
			<table border="1px" id="bantabelle">
				<tr>
					<?php
					for($j=0;$j<=($anzahl-3);$j++) {
						print "<th>$alts[$j]</th>";
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
								}
								if($werta=="9999-12-31 23:59:59") {
									$ausgabea="Permanent gebannt";
									$bgcolora="#FF0000";
								}
								if($werta!='' && $werta!="9999-12-31 23:59:59") {
									$getrennta=explode(' ', $werta);
									$datuma=explode('-', $getrennta[0]);
									$uhrzeita=explode(':', $getrennta[1]);
									$ausgabea=$datuma[2].'.'.$datuma[1].'.'.$datuma[0].' '.$uhrzeita[0].':'.$uhrzeita[1].':'.$uhrzeita[2];
									$bgcolora="#FFFF00";

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
				<span style="text-align: center"><h3>Updater-Skripts:</h3></span>
				<p><a href="http://henrydatei.bplaced.net/alts/lb.exe" style="text-align: center">vollständiger Installer / Updater (Windows)</a></p>
				<p></p>
				<p></p>
				<p> .</p>
		</div>
	</div>
</body>
</html>

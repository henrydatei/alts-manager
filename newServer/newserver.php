<?php
include("../dbconnect.php");
include("../create_arrays.php");

$server = $_GET['server'];

// Zeile für Server erzeugen
$beispielaccount = $all_accounts[1];
$sql = "INSERT INTO `alts` (`$beispielaccount`) VALUES (DEFAULT)";
$back = mysqli_query($db, $sql);

// Namen des Servers updaten
$sql = "UPDATE `alts` SET `server` = \"$server\" WHERE `id` = (SELECT MAX(`id`) FROM `alts`)";
$back = mysqli_query($db, $sql);

// Eintrag in history-Datenbank machen
$datum = date("d.m.Y", time());
$uhrzeit = date("H:i", time());
$ip = $_SERVER['REMOTE_ADDR'];
$useragent = $_SERVER['HTTP_USER_AGENT'];
$account = "Webseite/API";
$action = "Server hinzu";
$sql = "INSERT INTO `history` (`id`, `datum`, `uhrzeit`, `ip`, `useragent`, `account`, `action`, `alt`, `main`, `bann_vorher`, `bann_nachher`, `server`) VALUES (NULL, '$datum', '$uhrzeit', '$ip', '$useragent', '$account', '$action', NULL, NULL, NULL, NULL, '$server')";
mysqli_query($db, $sql);

// for automatic update
$f = fopen('../lastupdate.txt','w');
$time = time();
fwrite($f,"$time");
fclose($f);

header("Location: ../")
?>

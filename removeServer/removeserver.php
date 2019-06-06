<?php
include("../dbconnect.php");

$server = $_GET['serverweg'];

$sql = "DELETE FROM `alts` WHERE `server` = \"$server\"";
$back = mysqli_query($db, $sql);

// Eintrag in history-Datenbank machen
$datum = date("d.m.Y", time());
$uhrzeit = date("H:i", time());
$ip = $_SERVER['REMOTE_ADDR'];
$useragent = $_SERVER['HTTP_USER_AGENT'];
$account = "Webseite/API";
$action = "Server weg";
$sql = "INSERT INTO `history` (`id`, `datum`, `uhrzeit`, `ip`, `useragent`, `account`, `action`, `alt`, `main`, `bann_vorher`, `bann_nachher`, `server`) VALUES (NULL, '$datum', '$uhrzeit', '$ip', '$useragent', '$account', '$action', NULL, NULL, NULL, NULL, '$server')";
mysqli_query($db, $sql);

// for automatic update
$f = fopen('../lastupdate.txt','w');
$time = time();
fwrite($f,"$time");
fclose($f);

header("Location: ../");
?>

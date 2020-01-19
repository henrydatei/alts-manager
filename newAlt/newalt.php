<?php
include("../dbconnect.php");
include("../create_arrays.php");

//Accounts-Datenbank
$zugangsdaten= htmlentities($_GET['LoginData'], ENT_QUOTES);
$zugangsdaten = mysqli_real_escape_string($db, $zugangsdaten);
$userpass = explode(':',$zugangsdaten);
$neueralt = htmlentities($_GET['neueralt'], ENT_QUOTES);
$neueralt = mysqli_real_escape_string($db, $neueralt);
$adddb= "INSERT INTO `accounts`(`username`, `password`, `displayed_name`, `id`) VALUES ('$userpass[0]','$userpass[1]','$neueralt','')";
$einfugen = mysqli_query($db, $adddb);

//Alts-Datenbank
$letzteralt = $all_accounts[$numberOfAllAccounts - 1];
$neueralt = htmlentities($_GET['neueralt'], ENT_QUOTES);
$neueralt = mysqli_real_escape_string($db, $neueralt);
$spalteres = mysqli_query($db, "ALTER TABLE `alts` ADD `$neueralt` TEXT NULL AFTER `$letzteralt`");

// Eintrag in history-Datenbank machen
$datum = date("d.m.Y", time());
$uhrzeit = date("H:i", time());
$ip = htmlentities($_SERVER['REMOTE_ADDR'], ENT_QUOTES);
$ip = mysqli_real_escape_string($db, $ip);
$useragent = htmlentities($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES);
$useragent = mysqli_real_escape_string($db, $useragent);
$account = "Webseite/API";
$action = "Alt hinzu";
$sql = "INSERT INTO `history` (`id`, `datum`, `uhrzeit`, `ip`, `useragent`, `account`, `action`, `alt`, `main`, `bann_vorher`, `bann_nachher`, `server`) VALUES (NULL, '$datum', '$uhrzeit', '$ip', '$useragent', '$account', '$action', '$neueralt', NULL, NULL, NULL, NULL)";
mysqli_query($db, $sql);

$f=fopen('../lastupdate.txt','w');
$time = time();
fwrite($f,"$time");
fclose($f);

header("Location: ../");
?>

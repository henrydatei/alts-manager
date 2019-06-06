<?php
include("../dbconnect.php");
include("../create_arrays.php");

//Accounts-Datenbank
$zugangsdaten= $_GET['LoginData'];
$userpass = explode(':',$zugangsdaten);
$neueralt = $_GET['neueralt'];
$adddb= "INSERT INTO `accounts`(`username`, `password`, `displayed_name`, `id`) VALUES ('$userpass[0]','$userpass[1]','$neueralt','')";
$einfugen = mysqli_query($db, $adddb);

//Alts-Datenbank
$letzteralt = $all_accounts[$numberOfAllAccounts - 1];
$neueralt = $_GET['neueralt'];
$spalteres = mysqli_query($db, "ALTER TABLE `alts` ADD `$neueralt` TEXT NULL AFTER `$letzteralt`");

// Eintrag in history-Datenbank machen
$datum = date("d.m.Y", time());
$uhrzeit = date("H:i", time());
$ip = $_SERVER['REMOTE_ADDR'];
$useragent = $_SERVER['HTTP_USER_AGENT'];
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

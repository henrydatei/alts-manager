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

$f=fopen('../lastupdate.txt','w');
$time = time();
fwrite($f,"$time");
fclose($f);

header("Location: ../");
?>

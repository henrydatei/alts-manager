<?php
include("../dbconnect.php");
include("../create_arrays.php");

//Accounts-Datenbank
$zugangsdaten= $_GET['LoginData'];
$userpass = explode(':',$zugangsdaten);
$neueralt=$_GET['neueralt'];
//SQL Befehl
print "Email-Adresse: $userpass[0]";
print "<br />";
print "Passwort: $userpass[1]";
print "<br />";
$adddb= "INSERT INTO `accounts`(`username`, `password`, `displayed_name`, `id`) VALUES ('$userpass[0]','$userpass[1]','$neueralt','')";
// Befehl durchführen / in DB eintragen
$einfugen = mysqli_query($db, $adddb);
//print "neuer Eintrag: UPDATE `henrydatei`.`accounts` SET `$neueralt` = $temp WHERE `alts`.`id` =$id";

//Alts-Datenbank
$letzteralt=$alts[$numberOfAllAccounts - 1];
$neueralt=$_GET['neueralt'];
print "neue Spalte: ALTER TABLE `alts` ADD `$neueralt` TEXT NULL AFTER `$letzteralt`";
print "<br />";
$spalteres=mysqli_query($db, "ALTER TABLE `alts` ADD `$neueralt` TEXT NULL AFTER `$letzteralt`");
$server="SELECT `server` FROM alts";
$ergb=mysqli_query($db, $server);
while($serv=mysqli_fetch_array($ergb)) {
	$banserver=$serv['server'];
	$temp=$_POST["$banserver"];
	if($temp=='') $temp="NULL";
	else $temp="'$temp'";

	$res=mysqli_query($db, "SELECT `id` FROM `alts` WHERE `server` = '$banserver'");
	$resid=mysqli_fetch_object($res);
	$id=$resid->id;

	print "neuer Eintrag: UPDATE `henrydatei`.`alts` SET `$neueralt` = $temp WHERE `alts`.`id` =$id";
	print "<br />";
	$neuereintrag=mysqli_query($db, "UPDATE `henrydatei`.`alts` SET `$neueralt` = $temp WHERE `alts`.`id` =$id");

	// for automatic update
	$f=fopen('lastupdate.txt','w');
	$time = time();
	fwrite($f,"$time");
	fclose($f);
}
?>

<?php
include("dbconnect.php");

$alts=array();
$namen=mysqli_query($db, "DESCRIBE `alts` ");
while($infos=mysqli_fetch_array($namen)) {
	array_push($alts,$infos[Field]);
}
$anzahl=count($alts);
/*
for($j=0;$j<=($anzahl-3);$j++) {
	print $alts[$j];
	print "<br />";
}
*/
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
<?php
	//Accounts-Datenbank
	$zugangsdaten= $_POST['LoginData'];
	$userpass = explode(':',$zugangsdaten);
	$neueralt=$_POST['neueralt'];
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
	$letzteralt=$alts[$anzahl-3];
	$neueralt=$_POST['neueralt'];
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
	}







?>
</body>
</html>

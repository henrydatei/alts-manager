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

// for automatic update
$f = fopen('../lastupdate.txt','w');
$time = time();
fwrite($f,"$time");
fclose($f);

header("Location: ../")
?>

<?php
include("../dbconnect.php");

$server = $_GET['serverweg'];

$sql = "DELETE FROM `alts` WHERE `server` = \"$server\"";
$back = mysqli_query($db, $sql);

// for automatic update
$f = fopen('../lastupdate.txt','w');
$time = time();
fwrite($f,"$time");
fclose($f);

header("Location: ../");
?>

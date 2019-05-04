<?php
include("../dbconnect.php");

$alt = $_GET['altweg'];

$ausaccounts = "DELETE FROM `accounts` WHERE `accounts`.`displayed_name` = '$alt'";
$ausmaindb = "ALTER TABLE `alts` DROP `$alt`";
$today = date("Y-m-d");
$sql = "SELECT * FROM `accounts` WHERE `displayed_name` = '$alt'";
$back = mysqli_query($db,$sql);
$row = mysqli_fetch_array($back);
$username = $row['username'];
$password = $row['password'];
$into_remove_db = "INSERT INTO `removed_alts` (`id`, `username`, `password`, `displayed_name`, `date`) VALUES (NULL, '$username', '$password', '$alt', '$today');";

mysqli_query($db,$ausaccounts);
mysqli_query($db,$ausmaindb);
mysqli_query($db,$into_remove_db);

// for automatic update
$f = fopen('../lastupdate.txt','w');
$time = time();
fwrite($f,"$time");
fclose($f);

header("Location: ../");
?>

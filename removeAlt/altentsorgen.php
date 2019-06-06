<?php
include("../dbconnect.php");
include("../create_arrays.php");

$alt = $_GET['altweg'];

if (in_array($alt, $mains)) {
  $main = 1;
  $ausaccounts = "DELETE FROM `main_accounts` WHERE `username` = '$alt'";
} else {
  $main = 0;
  $ausaccounts = "DELETE FROM `accounts` WHERE `displayed_name` = '$alt'";
}
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

// Eintrag in history-Datenbank machen
$datum = date("d.m.Y", time());
$uhrzeit = date("H:i", time());
$ip = $_SERVER['REMOTE_ADDR'];
$useragent = $_SERVER['HTTP_USER_AGENT'];
$account = "Webseite/API";
$action = "Alt weg";
$sql = "INSERT INTO `history` (`id`, `datum`, `uhrzeit`, `ip`, `useragent`, `account`, `action`, `alt`, `main`, `bann_vorher`, `bann_nachher`, `server`) VALUES (NULL, '$datum', '$uhrzeit', '$ip', '$useragent', '$account', '$action', '$alt', $main, NULL, NULL, NULL)";
mysqli_query($db, $sql);

// for automatic update
$f = fopen('../lastupdate.txt','w');
$time = time();
fwrite($f,"$time");
fclose($f);

header("Location: ../");
?>

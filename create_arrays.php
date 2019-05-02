<?php
include('dbconnect.php');

$alts = array();
$namen = mysqli_query($db, "SELECT `displayed_name` FROM `accounts`");
while($infos = mysqli_fetch_array($namen)) {
	$alts[] = $infos['displayed_name'];
}
$anzahl = count($alts);

$servers = array();
$sql = "SELECT `server` FROM `alts`";
$back = mysqli_query($db, $sql);
while ($row = mysqli_fetch_array($back)) {
  $servers[] = $row['server'];
}
$anzahl_server = count($servers);

$mains = array();
$sql = "SELECT * FROM `main_accounts` WHERE `only_friendlist` = 0";
$back = mysqli_query($db, $sql);
while ($row = mysqli_fetch_array($back)) {
	$mains[] = $row['username'];
}
$anzahl_mains = count($mains);

$all_accounts = array();
$all_accounts = array_merge($mains,$alts);
$numberOfAllAccounts = count($all_accounts);
 ?>

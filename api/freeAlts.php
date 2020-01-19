<?php
include("../dbconnect.php");
$alts=array();
$namen=mysqli_query($db, "DESCRIBE `alts` ");
while($infos=mysqli_fetch_array($namen)) {
	array_push($alts,$infos[Field]);
}
$anzahl=count($alts);

$server = htmlentities($_GET['server'], ENT_QUOTES);
$server = mysqli_real_escape_string($db, $server);

$sql = "SELECT * FROM `alts` WHERE `server` = \"$server\"";
$back = mysqli_query($db, $sql);
$row = mysqli_fetch_array($back);

for ($i=2; $i < $anzahl - 2; $i++) {
  $current_alt = $alts[$i];
  if ($row["$current_alt"] == "") {
    // alt ist frei, Login-Daten holen
    $sql = "SELECT * FROM `accounts` WHERE `displayed_name` = \"$current_alt\"";
    $back = mysqli_query($db, $sql);
    $zugangsdaten = mysqli_fetch_array($back);
    $username = $zugangsdaten['username'];
    $password = $zugangsdaten['password'];
    $name = $zugangsdaten['displayed_name'];
    print "$username:$password:$name";
		print "<br>";
  }
}
 ?>

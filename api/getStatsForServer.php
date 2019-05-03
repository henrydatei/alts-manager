<?php
include('../dbconnect.php');
$free = 0;
$temp = 0;
$perma = 0;

$alts = array();
$namen = mysqli_query($db, "DESCRIBE `alts` ");
while($infos = mysqli_fetch_array($namen)) {
	array_push($alts,$infos[Field]);
}
$anzahl = count($alts);


$server = $_GET['server'];
$sql = "SELECT * FROM `alts` WHERE `server` = \"$server\"";
$back = mysqli_query($db, $sql);
$row = mysqli_fetch_array($back);

for ($j=0; $j < $anzahl - 2; $j++) {
  $current_alt = $alts[$j];
  if ($row["$current_alt"] == "") {
    // alt ist frei
    $free = $free + 1;
  }
  if ($row["$current_alt"] == "9999-12-31 23:59:59") {
    // alt ist perma gebannt
    $perma = $perma + 1;
  }
  if ($row["$current_alt"] != "9999-12-31 23:59:59" && $row["$current_alt"] != "") {
    // alt ist temp gebannt
    $temp = $temp + 1;
  }
}
print "Free: $free, Temp: $temp, Perma: $perma";
 ?>

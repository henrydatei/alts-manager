<?php
include('../dbconnect.php');
$sql = "SELECT * FROM `accounts`";
$back = mysqli_query($db, $sql);
while ($row = mysqli_fetch_array($back)) {
  $username = $row["username"];
  $password = $row["password"];
  $alt = $row["displayed_name"];
  print "$username:$password:$alt";
  print "<br>";
}
 ?>

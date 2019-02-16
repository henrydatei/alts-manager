<?php
$db = mysqli_connect("localhost", "henrydatei", "ihenrydatei", "henrydatei");
if(!$db)
{
  exit("Verbindungsfehler: ".mysqli_connect_error());
}
?>

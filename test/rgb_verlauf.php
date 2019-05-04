<?php
include('../functions.php');
$NumberAccounts = 38;

print "<table style=\"border-collapse: collapse; border: 1px solid black;\">";
for ($line=1; $line <= $NumberAccounts ; $line++) {
  print "<tr>";
  for ($row=1; $row <= $NumberAccounts ; $row++) {
    if ($line + $row <= $NumberAccounts) {
      $colors = calcRGBlogistisch($NumberAccounts, $line, $row, $NumberAccounts - $line - $row);
      print "<td style=\"width: 26px; height: 30px; border: 1px solid black; background-color: rgba($colors[0],$colors[1],$colors[2],0.5)\">";
      print "&nbsp";
      print "</td>";
    }
  }
  print "</tr>";
}
print "</table>";

print "<br>";
print "<br>";
print "<br>";

// Temp Bann Farbe - 0-30 Tage
print "<table style=\"border-collapse: collapse; border: 1px solid black;\">";
print "<tr>";
print "<td style=\"width: 26px; height: 30px; border: 1px solid black; text-align: center; background-color: rgb(0,255,0)\">0</td>";
print "<td style=\"width: 26px; height: 30px; border: 1px solid black; background-color: rgb(255,255,255)\"></td>";
for ($i=1; $i <= 30; $i++) {
  $colors = calcTempColor($i);
  print "<td style=\"width: 26px; height: 30px; border: 1px solid black; text-align: center; background-color: rgb($colors[0],$colors[1],$colors[2])\">";
  print "$i";
  print "</td>";
}
print "</tr>";
print "</table>";

print "<br>";
print "<br>";
print "<br>";

// Temp Bann Farbe - 31-365 Tage
print "<table style=\"border-collapse: collapse; border: 1px solid black;\">";
print "<tr>";
for ($i=30; $i <= 365; $i=$i+10) {
  $colors = calcTempColor($i);
  print "<td style=\"width: 26px; height: 30px; border: 1px solid black; text-align: center; background-color: rgb($colors[0],$colors[1],$colors[2])\">";
  print "$i";
  print "</td>";
}
print "</tr>";
print "</table>";
 ?>

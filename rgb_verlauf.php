<?php
include('functions.php');
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
 ?>

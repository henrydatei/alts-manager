<?php
include("dbconnect.php");

$alts=array();
$namen=mysqli_query($db, "DESCRIBE `alts` ");
while($infos=mysqli_fetch_array($namen)) {
	array_push($alts,$infos[Field]);
}
print_r($alts);
print "<br />";
$anzahl=count($alts);
print $anzahl;
/*
for($j=0;$j<=($anzahl-3);$j++) {
	print $alts[$j];
	print "<br />";
}
*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">

<head>
    <title>Der organisierte Hacker</title>

    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="keywords" content="" />
    <meta name="generator" content="Webocton - Scriptly (www.scriptly.de)" />

    <link href="style.css" type="text/css" rel="stylesheet" />
</head>

<body>
	<div id="header">
		<div align="center" id="header-schrift">Der organisierte Hacker</div>
	</div>
	
	<div id="main">
		<div id="text" align="center">
			<h2>neuen Server eintragen</h2>
			<form method="post" action="server.php">
				<table>
					<tr>
						<td>Server:</td>
						<td><input type="text" name="server" size="15" /></td>
					</tr>
					<?php
					for($j=0;$j<=($anzahl-3);$j++) {
						$aktuell=$alts[$j];
						print "<tr>";
						print "<td>Bann von $alts[$j]</td>";
						print "<td><input type=\"text\" name=\"$aktuell\" size=\"15\" /></td>";
						print "</tr>";
					}
					?>
					<tr>
						<td></td>
						<td><input type="submit" name="s" value="absenden" /></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</body>
</html>
<?php
include("../dbconnect.php");

$alts=array();
$namen=mysqli_query($db, "DESCRIBE `alts` ");
while($infos=mysqli_fetch_array($namen)) {
	array_push($alts,$infos[Field]);
}
$anzahl=count($alts);

$mains = array();
$sql = "SELECT * FROM `main_accounts` WHERE `only_friendlist` = 0";
$back = mysqli_query($db, $sql);
while ($row = mysqli_fetch_array($back)) {
	$mains[] = $row['username'];
}
$anzahl_mains = count($mains);
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

    <link href="/alts/style.css" type="text/css" rel="stylesheet" />
</head>

<body>
	<div id="header">
		<div align="center" id="header-schrift">Der organisierte Hacker</div>
	</div>

	<div id="main">
		<div id="text" align="center">
			<h2>vorhandenen Alt l&ouml;schen</h2>
			<form method="get" action="altentsorgen.php">
				<table>
					<tr>
						<td> zu l&ouml;schender Alt:</td>
						<td><select name="altweg">
											<?php
												for ($l=0; $l<($anzahl-$anzahl_mains) ; $l++) {
													print "<option>$alts[$l]</option>";
												}
											 ?>
										</select></td>
					</tr>
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

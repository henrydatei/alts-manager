<?php
include("dbconnect.php");
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
			<h2>neuen Alt eintragen</h2>
			<form method="post" action="alt.php">
				<table>
					<tr>
						<td> neuer Alt (InGame-Name):</td>
						<td><input type="text" name="neueralt" size="15" /></td>
					</tr>
          <tr>
            <td>E-Mail und Passwort:</td>
            <td><input type="text" name="LoginData" placeholder="email:password" size="15"></td>
          </tr>
					<?php
					$server="SELECT server FROM alts";
					$ergb=mysqli_query($db, $server);
						while($serv=mysqli_fetch_object($ergb)) {
							$banserver=$serv->server;
							print "<tr>";
							print "<td>Vom Server $banserver gebannt bis:</td>";
							print "<td><input type=\"text\" name=\"$banserver\" size=\"15\" /></td>";
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

<?php
include("dbconnect.php");

$alts=array();
$namen=mysqli_query($db, "DESCRIBE `alts` ");
while($infos=mysqli_fetch_array($namen)) {
	array_push($alts,$infos[Field]);
}
$anzahl=count($alts);
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
<?php
$bandaten=array();
for($j=0;$j<=($anzahl-3);$j++) {	
	$neu=$alts[$j];
	$eingabe=$_POST["$neu"];
	if($eingabe=='') $eingabe="NULL";
	else $eingabe="'$eingabe'";
	array_push($bandaten,$eingabe);
}
	
	$server=$_POST['server'];

	
$vorne="";
for($k=0;$k<=($anzahl-3);$k++) {
	$vorne=$vorne."`$alts[$k]`";
	$vorne=$vorne.", ";
}
$vorne=$vorne."`server`,"."`id`";

	$eintragen="INSERT INTO `alts`($vorne) VALUES ($bandaten[0],$bandaten[1],$bandaten[2],$bandaten[3],'$server',NULL)";
	print $eintragen;
	$eingetragen=mysqli_query($db, $eintragen);
	print "Erfolgreich eingetragen";
	

?>
</body>
</html>
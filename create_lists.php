<?php
include('dbconnect.php');
// friends.json generator
$handle=fopen("data/friends.json", 'w');
for ($a=0; $a<($anzahl-2) ; $a++) {
	$inhalt=$alts[$a].":".$alts[$a];
	fwrite($handle, $inhalt);
	fwrite($handle, "\n");
}
$sql = "SELECT * FROM `main_accounts` WHERE `only_friendlist` = 1";
$back = mysqli_query($db, $sql);
while ($row = mysqli_fetch_array($back)) {
	$friendname = $row['username'];
	fwrite($handle, "$friendname:$friendname");
	fwrite($handle, "\n");
}

// accounts.json generator
$accName=array();
$accLogin=array();
$accPwd=array();
$query = mysqli_query($db, "SELECT `displayed_name`,`username`,`password` FROM `accounts`");
while($row = mysqli_fetch_array($query))
{
   $accName[] = $row['displayed_name'];
   $accLogin[] = $row['username'];
   $accPwd[] = $row['password'];
}
$accCount=count($accLogin);
$handle2=fopen("data/accounts.json", 'w');
fwrite($handle2, "[");
fwrite($handle2, "\n");
fwrite($handle2, "\"MsBrony::\",");
fwrite($handle2,"\n");
for ($a=0; $a<=($accCount-1) ; $a++) {
	$inhalt2 = "  \"$accLogin[$a]:$accPwd[$a]:$accName[$a]\",";
	if ($a==($accCount-1)) {
		$inhalt2 = substr($inhalt2,0,-1);
	}
	fwrite($handle2, $inhalt2);
	fwrite($handle2, "\n");
}
fwrite($handle2, "]");
fclose($handle2);

// altliste.txt generator
$handle3=fopen("altliste.txt", 'w');
for ($b=0; $b<=($accCount-1) ; $b++) {
	//$inhalt3= accLogin:accPwd
	$inhalt3 = "$accLogin[$b]:$accPwd[$b] \n";
	fwrite($handle3, $inhalt3);
}
fclose($handle3);
 ?>

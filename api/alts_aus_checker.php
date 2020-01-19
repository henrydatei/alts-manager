<?php
include("../dbconnect.php");

$alts=array();
$namenderalts=mysqli_query($db, "DESCRIBE `alts` ");
while($infos=mysqli_fetch_array($namenderalts)) {
	array_push($alts,$infos[Field]);
}
$anzahl=count($alts);

// Datei einlesen
$input=file_get_contents('../out.txt');
if ($input == "") {
  print "Keine Datei gefunden";
}
else {
  # Datei Auswertung
  $usernames = array();
  $passwords = array();
  $namen = array();

  $einzelneoutputs = explode("--------------------------------------------------------------------------------",$input);

  for ($i=1; $i < (count($einzelneoutputs)-1) ; $i++) {
    $infos = explode("\n",$einzelneoutputs[$i]);

    if ($infos[1] !== 'Error authenticating, response: {"error":"ForbiddenOperationException","errorMessage":"Invalid credentials. Invalid username or password."}'
    && $infos[2] !== 'name: null') {
      print_r($infos);
      print "<br />";
      print "Username: ".htmlentities(substr($infos[4],10), ENT_QUOTES);
      $usernames[] = htmlentities(substr($infos[4],10), ENT_QUOTES);
      print "<br />";
      print "Passwort: ".htmlentities(substr($infos[5],10), ENT_QUOTES);
      $passwords[] = htmlentities(substr($infos[5],10), ENT_QUOTES);
      print "<br />";
      print "Name: ".htmlentities(substr($infos[2],6), ENT_QUOTES);
      $namen[] = htmlentities(substr($infos[2],6), ENT_QUOTES);
      print "<br />";
      print "<br />";
      print "<br />";
    }

  }
}

print_r($usernames);
print "<br />";
print "<br />";

print_r($passwords);
print "<br />";
print "<br />";

print_r($namen);
print "<br />";
print "<br />";

//ab damit in die Datenbank

for ($a=0; $a < count($usernames) ; $a++) {
  //ueberpruefen, ob es den Alt schon gibt
  $zumueberpruefen = $namen[$a];
  if (in_array($zumueberpruefen,$alts)) {
    print "$zumueberpruefen ist bereits in der Datenbank";
    print "<br />";
  } else {
    //Accounts-Datenbank
    $user = $usernames[$a];
		$user = mysqli_real_escape_string($db, $user);
    $pass = $passwords[$a];
		$pass = mysqli_real_escape_string($db, $pass);
    $name = $namen[$a];
		$name = mysqli_real_escape_string($db, $name);
  	$adddb= "INSERT INTO `accounts`(`username`, `password`, `displayed_name`, `id`) VALUES ('$user','$pass','$name','')";
  	// Befehl durchführen / in DB eintragen
  	$einfugen = mysqli_query($db, $adddb);

  	//Alts-Datenbank
  	$letzteralt=$alts[$anzahl-3];
  	$neueralt=$name;
  	print "neue Spalte: ALTER TABLE `alts` ADD `$neueralt` TEXT NULL AFTER `$letzteralt`";
  	print "<br />";
  	$spalteres=mysqli_query($db, "ALTER TABLE `alts` ADD `$neueralt` TEXT NULL AFTER `$letzteralt`");
    //Alt-Liste aktualisieren, um immer den neuen Alt als letzte Spalte einzutragen
    $namenderalts=mysqli_query($db, "DESCRIBE `alts` ");
    while($infos=mysqli_fetch_array($namenderalts)) {
    	array_push($alts,$infos[Field]);
    }
    $anzahl=count($alts);
    }
	}


 ?>

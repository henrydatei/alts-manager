<?php
include("dbconnect.php");

$alts=array();
$namenderalts=mysqli_query($db, "DESCRIBE `alts` ");
while($infos=mysqli_fetch_array($namenderalts)) {
	array_push($alts,$infos[Field]);
}
$anzahl=count($alts);

// Datei einlesen
$input=file_get_contents('out.txt');
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
      print "Username: ".substr($infos[4],10);
      $usernames[] = substr($infos[4],10);
      print "<br />";
      print "Passwort: ".substr($infos[5],10);
      $passwords[] = substr($infos[5],10);
      print "<br />";
      print "Name: ".substr($infos[2],6);
      $namen[] = substr($infos[2],6);
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
    $pass = $passwords[$a];
    $name = $namen[$a];
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

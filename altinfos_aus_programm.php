<?php
include("dbconnect.php");

// Datei einlesen
$input=file_get_contents('altinfos.txt');
if ($input == "") {
  print "Keine Datei altinfos.txt gefunden";
}
else {
  # Datei Auswertung

  $einzelneoutputs = explode("--------------------------------------------------------------------------------",$input);

  for ($i=1; $i < (count($einzelneoutputs)-1) ; $i++) {
    $infos = explode("\n",$einzelneoutputs[$i]);

      print_r($infos);
			print "<br />";
			print "<br />";
      $id = substr($infos[1],4);
			$email = substr($infos[2],7);
			$username = substr($infos[3],10);
			$registerip = substr($infos[4],12);
			$registeredat = substr($infos[5],14);
			$passwordchangedat = substr($infos[6],18);
			$dateofbirth = substr($infos[7],13);
			$deleted = substr($infos[8],9);
			$blocked = substr($infos[9],9);
			$secured = substr($infos[10],9);
			$migrated = substr($infos[11],10);
			$emailverified = substr($infos[12],15);
			$legacyuser = substr($infos[13],12);
			$verfiedbyparent = substr($infos[14],17);
			$fullname = substr($infos[15],10);
			$frommigrateduser = substr($infos[16],18);
			$hashed = substr($infos[17],8);
			$country=$infos[18];
			$region=$infos[19];
			$city=$infos[20];

			$abfrage="SELECT `displayed_name`,`password` FROM `accounts` WHERE `username`='$username'";
			$ergebnis=mysqli_query($db, $abfrage);
			$weiteredaten=mysqli_fetch_object($ergebnis);
			$displayed_name = $weiteredaten->displayed_name;
			$password = $weiteredaten->password;

			print $displayed_name;
			print "<br />";
			print $password;
			print "<br />";
			print $id;
			print "<br />";
			print $email;
			print "<br />";
			print $username;
			print "<br />";
			print $registerip;
			print "<br />";
			print $registeredat;
			print "<br />";
			print $passwordchangedat;
			print "<br />";
			print $dateofbirth;
			print "<br />";
			print $deleted;
			print "<br />";
			print $blocked;
			print "<br />";
			print $secured;
			print "<br />";
			print $migrated;
			print "<br />";
			print $emailverified;
			print "<br />";
			print $legacyuser;
			print "<br />";
			print $verfiedbyparent;
			print "<br />";
			print $fullname;
			print "<br />";
			print $frommigrateduser;
			print "<br />";
			print $hashed;
			print "<br />";
			print $country;
			print "<br />";
			print $region;
			print "<br />";
			print $city;
			print "<br />";
			print "<br />";

			$eintragen = "INSERT INTO `alt_infos`(`id`, `name`, `password`, `idUser`, `email`, `username`, `registerIP`, `registeredAt`, `passwordChangedAt`, `dateOfBirth`,
			`deleted`, `blocked`, `secured`, `migrated`, `emailVerified`, `legacyUser`, `verifiedByParent`, `fullName`, `fromMigratedUser`, `hashed`, `country`, `region`, `city`) VALUES
			('','$displayed_name','$password','$id','$email','$username','$registerip','$registeredat','$passwordchangedat','$dateOfBirth','$deleted','$blocked','$secured'
			,'$migrated','$emailverified','$legacyuser','$verfiedbyparent','$fullname','$frommigrateduser','$hashed','$country','$region','$city')";
			$eintrag=mysqli_query($db, $eintragen);
    }

  }

 ?>

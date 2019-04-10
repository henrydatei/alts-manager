<?php
function sekundentoalles($zeitInSekunden) {
	if($zeitInSekunden >= 86400) {
		$anzahlTage = ($zeitInSekunden - $zeitInSekunden%86400)/86400;
		$zeitInSekunden = $zeitInSekunden - $anzahlTage * 86400;
	}
	if($zeitInSekunden >= 3600) {
		$anzahlStunden = ($zeitInSekunden - $zeitInSekunden%3600)/3600;
		$zeitInSekunden = $zeitInSekunden - $anzahlStunden * 3600;
	}
	if($zeitInSekunden >= 60) {
		$anzahlMinuten = ($zeitInSekunden - $zeitInSekunden%60)/60;
		$zeitInSekunden = $zeitInSekunden - $anzahlMinuten * 60;
	}
	return "$anzahlTage Tage, $anzahlStunden Stunden, $anzahlMinuten Minuten und $zeitInSekunden Sekunden";
}

function banZelle($time) {
  if($time == "") {
    $ausgabe = "frei";
    $color = "#00FF00";
    $code = 0;
  }
  if($time == "9999-12-31 23:59:59") {
    $ausgabe = "Permanent gebannt";
    $color = "#FF0000";
    $code = 2;
  }
  if($time != "" && $time != "9999-12-31 23:59:59") {
    $getrennt = explode(' ', $time);
    $datum = explode('-', $getrennt[0]);
    $uhrzeit = explode(':', $getrennt[1]);
    $ausgabe = $datum[2].'.'.$datum[1].'.'.$datum[0].' '.$uhrzeit[0].':'.$uhrzeit[1].':'.$uhrzeit[2];
    $color = "#FFFF00";
    $code = 1;
  }
  $return = array($color, $ausgabe, $code);
  return $return;
}

function calcRGB($gesamt, $perma, $temp, $free) {
	$red = $perma/$gesamt * 255 + $temp/$gesamt * 255;
	$green = $free/$gesamt * 255 + $temp/$gesamt * 255;
	$blue = 0;
	$back = array($red,$green,$blue);
	return $back;
}

function calcRGBlogistisch($gesamt, $perma, $temp, $free) {
	$k = 2*log(254)/255;
	$red = 255 / (1 + exp(-255*$k*($perma/$gesamt))*((255/1)-1)) + 255 / (1 + exp(-255*$k*($temp/$gesamt))*((255/1)-1));
	$green = 255 / (1 + exp(-255*$k*($free/$gesamt))*((255/1)-1)) + 255 / (1 + exp(-255*$k*($temp/$gesamt))*((255/1)-1));
	$blue = 0;
	$back = array($red,$green,$blue);
	return $back;
}
 ?>

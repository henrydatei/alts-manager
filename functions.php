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
    $anzahlFrei = $anzahlFrei + 1;
    $code = 0;
  }
  if($time == "9999-12-31 23:59:59") {
    $ausgabe = "Permanent gebannt";
    $color = "#FF0000";
    $anzahlPermaBans = $anzahlPermaBans + 1;
    $code = 2;
  }
  if($time != "" && $time != "9999-12-31 23:59:59") {
    $getrennt = explode(' ', $time);
    $datum = explode('-', $getrennt[0]);
    $uhrzeit = explode(':', $getrennt[1]);
    $ausgabe = $datum[2].'.'.$datum[1].'.'.$datum[0].' '.$uhrzeit[0].':'.$uhrzeit[1].':'.$uhrzeit[2];
    $color = "#FFFF00";
    $anzahlTempBans = $anzahlTempBans + 1;
    $gesamteTempBanZeit = $gesamteTempBanZeit + abs(strtotime($time) - time());
    $code = 1;
  }
  $return = array($color, $ausgabe, $code);
  return $return;
}
 ?>
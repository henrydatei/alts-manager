<?php
include("dbconnect.php");

function addtime($addtage) {
    $time=time();
    $endunix=$time+($addtage*86400);

    $endrichtig=date("Y-m-d H:i:s",$endunix);
    return "'$endrichtig'";
}

$alt = htmlentities($_POST['alt'], ENT_QUOTES);
$alt = mysqli_real_escape_string($db, $alt);
$server = htmlentities($_POST['server'], ENT_QUOTES);
$server = mysqli_real_escape_string($db, $server);
$dauer = htmlentities($_POST['dauer'], ENT_QUOTES);
$dauer = mysqli_real_escape_string($db, $dauer);
$perm = htmlentities($_POST['perma'], ENT_QUOTES);
$anzahl = htmlentities($_POST['anzahl'], ENT_QUOTES);

// vorheringen Bann auslesen
$sql = "SELECT `$alt` FROM `alts` WHERE `server` = '$server'";
$back = mysqli_query($db, $sql);
$row = mysqli_fetch_array($back);
$bann_vorher = $row["$alt"];

if($perm=='') $perma=0;
else $perma=1;

if($dauer!='') $zeit="'$dauer'";
elseif($perma==1) $zeit="'9999-12-31 23:59:59'";
elseif($perma==0 && $dauer=='' && $anzahl=='') $zeit="NULL";
else $zeit=addtime($anzahl);

$sqlid="SELECT `id` FROM `alts` WHERE `server` = '$server'";

$res=mysqli_query($db, $sqlid);
$resid=mysqli_fetch_object($res);
$id=$resid->id;

$sql="UPDATE `alts` SET `$alt` = $zeit WHERE `alts`.`id` =$id";

$result=mysqli_query($db, $sql);

// Eintrag in history-Datenbank machen
$datum = date("d.m.Y", time());
$uhrzeit = date("H:i", time());
$ip = htmlentities($_SERVER['REMOTE_ADDR'], ENT_QUOTES);
$ip = mysqli_real_escape_string($db, $ip);
$useragent = htmlentities($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES);
$useragent = mysqli_real_escape_string($db, $useragent);
$account = "Webseite";
$action = "bannaenderung";
$bann_nachher = $zeit;
$sql = "INSERT INTO `history` (`id`, `datum`, `uhrzeit`, `ip`, `useragent`, `account`, `action`, `alt`, `main`, `bann_vorher`, `bann_nachher`, `server`) VALUES (NULL, '$datum', '$uhrzeit', '$ip', '$useragent', '$account', '$action', '$alt', NULL, '$bann_vorher', $bann_nachher, '$server')";
mysqli_query($db, $sql);

// for automatic update
$f=fopen('lastupdate.txt','w');
$time = time();
fwrite($f,"$time");
fclose($f);

header("Location: index.php?alt=$alt&server=$server&perma=$perma");
?>

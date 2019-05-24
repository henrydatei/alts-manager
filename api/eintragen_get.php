<?php
include("../dbconnect.php");

function addtime($addtage) {
    $time=time();
    $endunix=$time+($addtage*86400);

    $endrichtig=date("Y-m-d H:i:s",$endunix);
    return "'$endrichtig'";
}

$alt=$_GET['alt'];
$server=$_GET['server'];
$dauer=$_GET['dauer'];
$perm=$_GET['perma'];
$anzahl=$_GET['anzahl'];

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

print "Alt: $alt<br />";
print "Server: $server<br />";
print "Endtime: $zeit";
?>

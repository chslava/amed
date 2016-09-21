<?php
//ielâdçjam funkcijas
require_once("../config.php");
if($ar > 0){header("Location: ".$wolf_path."member.php$li");	exit;}
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

$ren=mysql_query("Select * from $tabula where id='$id'");
$row=mysql_fetch_array($ren);
if($row["publish"]=="off"){$st="on";}
else{$st="off";}
$result=mysql_query("update $tabula set publish='$st' where id='$id'"); 

$links = $wolf_path."member.php".$li;
header("Location: $links");
exit;
?>
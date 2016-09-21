<?php
//ielâdçjam funkcijas
require_once("config.php");
if($ar > 0){header("Location: ".$wolf_path."member.php$li");	exit;}
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");


$ren=mysql_query("Select * from $tabula where id='$id'");
$row=mysql_fetch_array($ren);
if($row["statuss"]=="2"){$st="1";}
else{$st="2";}
$result=mysql_query("update $tabula set statuss='$st' where id='$id'"); 

$links = "index.php".$li;
header("Location: $links");
exit;
?>
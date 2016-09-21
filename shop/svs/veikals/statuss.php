<?php
//iel�d�jam funkcijas
require_once("config.php");
if($ar > 0){header("Location: ".$wolf_path."member.php$li");	exit;}
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");


$ren=mysqli_query($result_db,"Select * from $tabula where id='$id'");
$row=mysqli_fetch_array($ren);
if($row["statuss"]=="2"){$st="1";}
else{$st="2";}
$result=mysqli_query($result_db,"update $tabula set statuss='$st' where id='$id'"); 

$links = "index.php".$li;
header("Location: $links");
exit;
?>
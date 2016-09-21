<?php
//iel�d�jam funkcijas
require_once("../config.php");
if($ar > 0){header("Location: ".$wolf_path."member.php$li");	exit;}
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

$ren=mysqli_query($result_db,"Select * from $tabula where id='$id'");
$row=mysqli_fetch_array($ren);
if($row["publish"]=="off"){$st="on";}
else{$st="off";}
$result=mysqli_query($result_db,"update $tabula set publish='$st' where id='$id'"); 

$links = $wolf_path."member.php".$li;
header("Location: $links");
exit;
?>
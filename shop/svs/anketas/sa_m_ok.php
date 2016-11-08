<?php
//iel�d�jam funkcijas
require_once("../config.php");
if($ar > 0){header("Location: ".$wolf_path."member.php$li");	exit;}
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

$ren=mysqli_query($result_db,"Select * from sabloni where id='$name'");
$row=mysqli_fetch_array($ren);
mysqli_free_result($ren);

$ren1=mysqli_query($result_db,"Select * from $row[tab] where id=$k");
$row1=mysqli_fetch_array($ren1);
mysqli_free_result($ren1);

$change_from=array("'","\"");
$change_to=array("`","&quot;");

$nosaukums=str_replace($change_from,$change_to,$_POST["nosaukums"]);
$ieraksti=str_replace($change_from,$change_to,$_POST["ieraksti"]);
$garums=str_replace($change_from,$change_to,$_POST["garums"]);

$ieraksti=str_replace("\n","<br>",$_POST["ieraksti"]);
$datums1=str_replace("\n","<br>",$_POST["datums1"]);
$datums2=str_replace("\n","<br>",$_POST["datums2"]);
$datums3=str_replace("\n","<br>",$_POST["datums3"]);
$sa=explode("_",$_POST["saistitie"]);

$result = mysqli_query($result_db,"update $row[tab] set nosaukums='$nosaukums', tips='$_POST[tips]', maks='$garums', ieraksti='$ieraksti', parbaude='$_POST[parbaude]', obligati='$_POST[obligati]', sai='$sa[0]', saii='$sa[1]', kol='$_POST[vienigais]', width='$_POST[width]', datums1='$datums1', datums2='$datums2', datums3='$datums3' where id='$k'"); 


$links = $wolf_path."formas/sa.php".$li1."&name=$name";
header("Location: $links");
exit;
?>
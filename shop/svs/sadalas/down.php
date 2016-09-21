<?php
//ielâdçjam funkcijas
require_once("../config.php");
if($ar > 0){header("Location: ".$wolf_path."member.php$li");	exit;}
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

$rep=mysql_query("Select parent_id from $tabula where id='$id'");
$f=mysql_fetch_array($rep);
mysql_free_result($rep);

$rep=mysql_query("Select * from $tabula where place>'$iz' and parent_id='$f[parent_id]' and lang ='$ver' order by place asc limit 0, 1");

$place_old=$iz;
if($rop=mysql_fetch_array($rep))
{
	$place_new=$rop["place"];
}
else
{
	$place_new=$place_old;
}
$nn=$rop["id"];
mysql_free_result($rep);

$result = mysql_query("update $tabula set place='$place_old' where id='$nn'"); 
$result = mysql_query("update $tabula set place='$place_new' where id='$id'"); 

$links = $wolf_path."member.php".$li;
header("Location: $links");
exit;
?>
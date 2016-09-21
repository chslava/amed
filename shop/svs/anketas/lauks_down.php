<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");


$rep=mysql_query("Select * from anketas where place>'$iz' and parent_id='$name' order by place asc limit 0, 1");

$place_old=$iz;
if($rop=mysql_fetch_array($rep))
{
	$place_new=$rop["place"];
}
else{$place_new=$place_old;}
$nn=$rop["id"];
mysql_free_result($rep);

$result = mysql_query("update anketas set place='$place_old' where id='$nn'"); 
$result = mysql_query("update anketas set place='$place_new' where id='$k'"); 

$links = "lauki.php".$li1."&name=$name";
header("Location: $links");
exit;
?>
<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

$rep=mysql_query("Select * from banners where place<'$_GET[iz]' order by place desc limit 0, 1");

$place_old=$_GET["iz"];
if($rop=mysql_fetch_array($rep)){
$place_new=$rop["place"];

}
else{$place_new=$place_old;}
$nn=$rop["id"];
mysql_free_result($rep);

$result = mysql_query("update banners set place='$place_old' where id='$nn'"); 
$result = mysql_query("update banners set place='$place_new' where id='$_GET[k]'"); 

$links = $wolf_path."banneri/index.php".$li1;
header("Location: $links");
exit;
?>
<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

$rep=mysql_query("Select * from albums where id = '$_GET[k]'");
$rop=mysql_fetch_array($rep);
mysql_free_result($rep);


$rep=mysql_query("Select * from albums where place>'$_GET[iz]' and parent_id='$rop[parent_id]' order by place asc limit 0, 1");

$place_old=$_GET["iz"];
if($rop=mysql_fetch_array($rep)){
$place_new=$rop["place"];

}
else{$place_new=$place_old;}
$nn=$rop["id"];
mysql_free_result($rep);

$result = mysql_query("update albums set place='$place_old' where id='$nn'"); 
$result = mysql_query("update albums set place='$place_new' where id='$_GET[k]'"); 

$links = "index.php".$li1;
header("Location: $links");
exit;
?>
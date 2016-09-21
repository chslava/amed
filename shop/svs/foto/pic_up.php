<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

$rep=mysql_query("Select parent_id from pictures where id='$_GET[k]'");
$f=mysql_fetch_array($rep);
mysql_free_result($rep);

$rep=mysql_query("Select * from pictures where parent_id='$f[parent_id]' and place<'$_GET[iz]' order by place desc limit 0, 1");

$place_old=$_GET["iz"];
if($rop=mysql_fetch_array($rep)){
$place_new=$rop["place"];

}
else{$place_new=$place_old;}
$nn=$rop["id"];
mysql_free_result($rep);

$result = mysql_query("update pictures set place='$place_old' where id='$nn'"); 
$result = mysql_query("update pictures set place='$place_new' where id='$_GET[k]'"); 

$links = "foto_p.php".$li1."&name=$name";
header("Location: $links");
exit;
?>
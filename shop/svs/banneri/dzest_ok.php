<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");


$ren=mysql_query("Select * from banners where id='$name'");
$row=mysql_fetch_array($ren);
mysql_free_result($ren);

$file="../../banners/$row[datne]";
unlink($file);

$result1=mysql_query("delete from banners where id='$name'");

$links = $wolf_path."banneri/index.php".$li1;
header("Location: $links");
exit;
?>
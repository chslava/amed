<?php
//iel�d�jam funkcijas
require_once("config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

					
$rep=mysql_query("Select * from images where id='$k' ");
$rop=mysql_fetch_array($rep);
mysql_free_result($rep);


$file="../../pictures/items/pic-small/".$rop["file"].".jpg";
unlink($file);

$file="../../pictures/items/pic-big/".$rop["file"].".jpg";
unlink($file);

$result = mysql_query("delete from images where id='$k'");

$links = "p_atteli.php".$li."&name=$name";
header("Location: $links");
exit;
?>
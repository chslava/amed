<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

					
$rep=mysql_query("Select * from pictures where id='$k' ");
$rop=mysql_fetch_array($rep);
mysql_free_result($rep);
$result = mysql_query("delete from pictures where id='$k'");

$file=$wolf_path."../pictures/albums/small/".$rop["file_name"].".jpg";
unlink($file);

$file=$wolf_path."../pictures/albums/big/".$rop["file_name"].".jpg";
unlink($file);



$links = "foto_p.php".$li1."&name=$name";
header("Location: $links");
exit;
?>
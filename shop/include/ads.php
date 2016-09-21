<?php
//ielâdçjam funkcijas
require_once("config.php");
$info = explode("/",$_GET["id"]);
$saite_lang = 'saite_'.$info[0];
$ren=mysql_query("SELECT * FROM banners where id='$info[1]'");
$row=mysql_fetch_array($ren);
mysql_free_result($ren);
header("Location: $row[$saite_lang]");
exit;
?>
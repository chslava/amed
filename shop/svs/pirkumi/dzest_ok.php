<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");
require_once("user_auth.php");

$ren=mysql_query("Select * from flowers where id='$k'");
$row=mysql_fetch_array($ren);
mysql_free_result($ren);

$file="../../flowers/flowers_small/$row[picture]";
unlink($file);
$file="../../flowers/flowers_middle/$row[picture]";
unlink($file);
$file="../../flowers/flowers_big/$row[picture]";
unlink($file);

$result=mysql_query("delete from flowers where id='$k'");

$links = "index.php".$li1."&limit=$limit";
header("Location: $links");
exit;
?>
<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

$result1=mysql_query("delete from anketas where id='$k'");

$links = "lauki.php".$li1."&name=$name";
header("Location: $links");
exit;
?>
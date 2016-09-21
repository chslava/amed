<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

$result=mysql_query("delete from anketas where parent_id='$name'");
$result=mysql_query("delete from anketas where id='$name'");

$links = "index.php".$li1;
header("Location: $links");
exit;
?>
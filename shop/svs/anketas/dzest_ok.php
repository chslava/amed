<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

$result=mysql_query("delete from anketas where parent_id='$name'");
$result=mysql_query("delete from anketas where id='$name'");

$links = "index.php".$li1;
header("Location: $links");
exit;
?>
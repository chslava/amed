<?php
//ielādējam funkcijas
require_once("../config.php");
require_once($wolf_path."check.php");

// izdzēšam visas apakšsadaļas

mysql_query("delete from discounts where id='$name'");

$links = "index.php".$li;
header("Location: $links");
exit;
?>
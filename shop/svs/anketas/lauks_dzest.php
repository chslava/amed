<?php
//ielādējam funkcijas
require_once("../config.php");
//pārbaudam, vai lietotājs ir reģistrējies
require_once($wolf_path."check.php");

$result1=mysql_query("delete from anketas where id='$k'");

$links = "lauki.php".$li1."&name=$name";
header("Location: $links");
exit;
?>
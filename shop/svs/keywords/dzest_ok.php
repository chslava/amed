<?php
//ielādējam funkcijas
require_once("../config.php");
//pārbaudam, vai lietotājs ir reģistrējies
require_once($wolf_path."check.php");


$result=mysql_query("delete from keywords where id='$_GET[k]'");


$links = "index.php".$li1;
header("Location: $links");
exit;
?>
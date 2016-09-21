<?php
//ielâdçjam funkcijas
require_once("config.php");
if($ar > 0){header("Location: ".$wolf_path."member.php$li");	exit;}
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");



mysql_query("delete from $tabula where id='$id'");


$links = "index.php".$li1;
header("Location: $links");
exit;
?>
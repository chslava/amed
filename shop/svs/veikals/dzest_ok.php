<?php
//ielādējam funkcijas
require_once("config.php");
if($ar > 0){header("Location: ".$wolf_path."member.php$li");	exit;}
//pārbaudam, vai lietotājs ir reģistrējies
require_once($wolf_path."check.php");



mysql_query("delete from $tabula where id='$id'");


$links = "index.php".$li1;
header("Location: $links");
exit;
?>
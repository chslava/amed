<?php
//iel�d�jam funkcijas
require_once("config.php");
if($ar > 0){header("Location: ".$wolf_path."member.php$li");	exit;}
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");



mysqli_query($result_db,"delete from $tabula where id='$id'");


$links = "index.php".$li1;
header("Location: $links");
exit;
?>
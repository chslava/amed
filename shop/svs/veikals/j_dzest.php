<?php
//ielâdçjam funkcijas
require_once("config.php");
if($ar > 0){header("Location: ".$wolf_path."member.php$li");	exit;}
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

$r=mysql_query("Select * from preces_f where id='$k'");
$f=mysql_fetch_array($r);
mysql_free_result($r);

unlink("../../preces/small/$f[filename]");
unlink("../../preces/big/$f[filename]");

$result = mysql_query("delete from preces_f  where id='$k'");


$links = "p_mainit.php".$li."&name=$name";
header("Location: $links");
exit;
?>
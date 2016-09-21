<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

$res=mysql_query("Select * from albums where id='$name'");
$ros=mysql_fetch_array($res);
mysql_free_result($res);

$ren=mysql_query("Select * from pictures where parent_id='$name'");

while($row=mysql_fetch_array($ren))
{
	$file=$wolf_path."../pictures/small/".$row["file_name"];
	unlink($file);

	$file=$wolf_path."../pictures/big/".$row["file_name"];
	unlink($file);

	mysql_query("delete from pictures where parent_id='$name'");

}

mysql_free_result($ren);

mysql_query("delete from albums where id='$name'");

$links = "index.php".$li1;
header("Location: $links");
exit;
?>
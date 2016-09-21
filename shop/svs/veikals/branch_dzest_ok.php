<?php
//ielâdçjam funkcijas
require_once("config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

$nos = "branches";
/*
$va="*".$k."*";
$ren=mysql_query("Select * from preces where color like '%$va%'");
while($row=mysql_fetch_array($ren))
{
	$valstis = str_replace($va,"",$row["color"]);
	mysql_query("update preces set color = '$valstis' where id='$row[id]'");
}
mysql_free_result($ren);
*/

$query = mysql_query("delete from branches_items where branche_id = '$k'");
$result = mysql_query("delete from $nos where id='$k'");

$links = "branch.php".$li1;
header("Location: $links");
exit;
?>
<?php
//iel�d�jam funkcijas
require_once("config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

$nos = "rates";
/*
$va="*".$k."*";
$ren=mysqli_query($result_db,"Select * from preces where color like '%$va%'");
while($row=mysqli_fetch_array($ren))
{
	$valstis = str_replace($va,"",$row["color"]);
	mysqli_query($result_db,"update preces set color = '$valstis' where id='$row[id]'");
}
mysqli_free_result($ren);
*/

$result=mysqli_query($result_db,"delete from $nos where id='$k'");

$links = "rate.php".$li1;
header("Location: $links");
exit;
?>
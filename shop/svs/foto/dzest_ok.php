<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

$res=mysqli_query($result_db,"Select * from albums where id='$name'");
$ros=mysqli_fetch_array($res);
mysqli_free_result($res);

$ren=mysqli_query($result_db,"Select * from pictures where parent_id='$name'");

while($row=mysqli_fetch_array($ren))
{
	$file=$wolf_path."../pictures/small/".$row["file_name"];
	unlink($file);

	$file=$wolf_path."../pictures/big/".$row["file_name"];
	unlink($file);

	mysqli_query($result_db,"delete from pictures where parent_id='$name'");

}

mysqli_free_result($ren);

mysqli_query($result_db,"delete from albums where id='$name'");

$links = "index.php".$li1;
header("Location: $links");
exit;
?>
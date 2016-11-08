<?php
//iel�d�jam funkcijas
require_once("config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

					
$rep=mysqli_query($result_db,"Select * from images where id='$k' ");
$rop=mysqli_fetch_array($rep);
mysqli_free_result($rep);


$file="../../pictures/items/pic-small/".$rop["file"].".jpg";
unlink($file);

$file="../../pictures/items/pic-big/".$rop["file"].".jpg";
unlink($file);

$result = mysqli_query($result_db,"delete from images where id='$k'");

$links = "p_atteli.php".$li."&name=$name";
header("Location: $links");
exit;
?>
<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

					
$rep=mysqli_query($result_db,"Select * from pictures where id='$k' ");
$rop=mysqli_fetch_array($rep);
mysqli_free_result($rep);
$result = mysqli_query($result_db,"delete from pictures where id='$k'");

$file=$wolf_path."../pictures/albums/small/".$rop["file_name"].".jpg";
unlink($file);

$file=$wolf_path."../pictures/albums/big/".$rop["file_name"].".jpg";
unlink($file);



$links = "foto_p.php".$li1."&name=$name";
header("Location: $links");
exit;
?>
<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");
require_once("user_auth.php");

$ren=mysqli_query($result_db,"Select * from flowers where id='$k'");
$row=mysqli_fetch_array($ren);
mysqli_free_result($ren);

$file="../../flowers/flowers_small/$row[picture]";
unlink($file);
$file="../../flowers/flowers_middle/$row[picture]";
unlink($file);
$file="../../flowers/flowers_big/$row[picture]";
unlink($file);

$result=mysqli_query($result_db,"delete from flowers where id='$k'");

$links = "index.php".$li1."&limit=$limit";
header("Location: $links");
exit;
?>
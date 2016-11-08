<?php
//iel�d�jam funkcijas
require_once("config.php");
$info = explode("/",$_GET["id"]);
$saite_lang = 'saite_'.$info[0];
$ren=mysqli_query($result_db,"SELECT * FROM banners where id='$info[1]'");
$row=mysqli_fetch_array($ren);
mysqli_free_result($ren);
header("Location: $row[$saite_lang]");
exit;
?>
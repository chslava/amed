<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

$result1=mysqli_query($result_db,"delete from anketas where id='$k'");

$links = "lauki.php".$li1."&name=$name";
header("Location: $links");
exit;
?>
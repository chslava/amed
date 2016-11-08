<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");


$result=mysqli_query($result_db,"delete from keywords where id='$_GET[k]'");


$links = "index.php".$li1;
header("Location: $links");
exit;
?>
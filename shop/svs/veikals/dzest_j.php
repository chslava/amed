<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

$rex=mysql_query("Select * from categories where id='$id'");
$rox=mysql_fetch_array($rex);
mysql_free_result($rex);

unlink("../../categories/$rox[picture].png");

$result=mysql_query("update categories set picture='' where id='$id'");

$links = "mainit.php".$li;
header("Location: $links");
exit;
?>
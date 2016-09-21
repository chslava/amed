<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

$rex=mysqli_query($result_db,"Select * from categories where id='$id'");
$rox=mysqli_fetch_array($rex);
mysqli_free_result($rex);

unlink("../../categories/$rox[picture].png");

$result=mysqli_query($result_db,"update categories set picture='' where id='$id'");

$links = "mainit.php".$li;
header("Location: $links");
exit;
?>
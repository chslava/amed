<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");
require_once("user_auth.php");

$result=mysqli_query($result_db,"update pasutijumi set arhivs='2' where id='$name'");

$links = "index.php".$li1."&limit=$limit";
header("Location: $links");
exit;
?>
<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");
require_once("user_auth.php");

$result=mysql_query("update pasutijumi set arhivs='2' where id='$name'");

$links = "index.php".$li1."&limit=$limit";
header("Location: $links");
exit;
?>
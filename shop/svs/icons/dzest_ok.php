<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

unlink("../../images/icons/$_GET[file]");

$links = "index.php".$li1;
header("Location: $links");
exit;
?>
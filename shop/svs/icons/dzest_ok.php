<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

unlink("../../images/icons/$_GET[file]");

$links = "index.php".$li1;
header("Location: $links");
exit;
?>
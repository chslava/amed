<?php
//ielādējam funkcijas
require_once("../config.php");
//pārbaudam, vai lietotājs ir reģistrējies
require_once($wolf_path."check.php");

unlink("../../images/icons/$_GET[file]");

$links = "index.php".$li1;
header("Location: $links");
exit;
?>
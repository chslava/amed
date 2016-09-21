<?php
//ielвdзjam funkcijas
require_once("../config.php");
require_once($wolf_path."check.php");

// izdzзрam visas apakрsadaпas

mysql_query("delete from discounts where id='$name'");

$links = "index.php".$li;
header("Location: $links");
exit;
?>
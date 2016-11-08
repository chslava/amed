<?php
//iel�d�jam funkcijas
require_once("../config.php");
require_once($wolf_path."check.php");

// izdz��am visas apak�sada�as

mysqli_query($result_db,"delete from discounts where id='$name'");

$links = "index.php".$li;
header("Location: $links");
exit;
?>
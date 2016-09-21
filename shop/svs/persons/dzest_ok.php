<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

$ren=mysql_query("Select * from persons where id='$_GET[k]'");
$row=mysql_fetch_array($ren);
mysql_free_result($ren);
	
if(file_exists("../../pictures/persons/small/$row[picture]"))
{				
	unlink("../../pictures/persons/small/$row[picture]");
}

if(file_exists("../../pictures/persons/big/$row[picture]"))
{				
	unlink("../../pictures/persons/big/$row[picture]");
}

$result=mysql_query("delete from persons where id='$_GET[k]'");


$links = "index.php".$li1;
header("Location: $links");
exit;
?>
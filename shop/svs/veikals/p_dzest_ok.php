<?php
//ielâdçjam funkcijas
require_once("config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

// izdzçðam visas apakðsadaïas

$query = mysql_query("select id, picture from items where `copy` = '$name'");
while($mysql = mysql_fetch_array($query))
{
	if(file_exists("../../pictures/items/small/$mysql[picture]"))
	{
		unlink("../../pictures/items/small/$mysql[picture]");
		unlink("../../pictures/items/big/$mysql[picture]");	
	}

	mysql_query("delete from branches_items where item_id='$mysql[id]'");
	mysql_query("delete from items where id='$mysql[id]'");
}

$r=mysql_query("Select * from items where id='$name'");
$f=mysql_fetch_array($r);

if(file_exists("../../pictures/items/small/$f[picture]"))
{
	unlink("../../pictures/items/small/$f[picture]");
	unlink("../../pictures/items/big/$f[picture]");	
}

mysql_query("delete from branches_items where item_id='$name'");
mysql_query("delete from items where id='$name'");


$links = "index.php".$li;
header("Location: $links");
exit;
?>
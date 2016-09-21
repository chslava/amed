<?php
//iel�d�jam funkcijas
require_once("config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

// izdz��am visas apak�sada�as

$query = mysqli_query($result_db,"select id, picture from items where `copy` = '$name'");
while($mysql = mysqli_fetch_array($query))
{
	if(file_exists("../../pictures/items/small/$mysql[picture]"))
	{
		unlink("../../pictures/items/small/$mysql[picture]");
		unlink("../../pictures/items/big/$mysql[picture]");	
	}

	mysqli_query($result_db,"delete from branches_items where item_id='$mysql[id]'");
	mysqli_query($result_db,"delete from items where id='$mysql[id]'");
}

$r=mysqli_query($result_db,"Select * from items where id='$name'");
$f=mysqli_fetch_array($r);

if(file_exists("../../pictures/items/small/$f[picture]"))
{
	unlink("../../pictures/items/small/$f[picture]");
	unlink("../../pictures/items/big/$f[picture]");	
}

mysqli_query($result_db,"delete from branches_items where item_id='$name'");
mysqli_query($result_db,"delete from items where id='$name'");


$links = "index.php".$li;
header("Location: $links");
exit;
?>
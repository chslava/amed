<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

$ren=mysqli_query($result_db,"Select * from persons where id='$_GET[k]'");
$row=mysqli_fetch_array($ren);
mysqli_free_result($ren);
	
if(file_exists("../../pictures/persons/small/$row[picture]"))
{				
	unlink("../../pictures/persons/small/$row[picture]");
}

if(file_exists("../../pictures/persons/big/$row[picture]"))
{				
	unlink("../../pictures/persons/big/$row[picture]");
}

$result=mysqli_query($result_db,"delete from persons where id='$_GET[k]'");


$links = "index.php".$li1;
header("Location: $links");
exit;
?>
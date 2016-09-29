<?php
//iel�d�jam funkcijas
require_once("config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once("check.php");

if($name > 0)
{
	$ren=mysqli_query($result_db,"Select * from $tabula where id='$id'");
	$row=mysqli_fetch_array($ren);
	mysqli_free_result($ren);
	
	$laiks = time();
	$backup = mysqli_query($result_db,"insert into content_backup values (
	null,
	'$id',
	'$laiks',	
	'$row[name]',
	'$row[text]'
	)");
	
	$ren=mysqli_query($result_db,"Select * from content_backup where id='$name'");
	$row=mysqli_fetch_array($ren);
	mysqli_free_result($ren);

	$rens=mysqli_query($result_db,"update $tabula set text='$row[text]' where id='$id'");
}

$links = "member.php".$li;
header("Location: $links");
exit;

?>
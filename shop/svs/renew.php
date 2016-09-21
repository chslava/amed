<?php
//ielâdçjam funkcijas
require_once("config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once("check.php");

if($name > 0)
{
	$ren=mysql_query("Select * from $tabula where id='$id'");
	$row=mysql_fetch_array($ren);
	mysql_free_result($ren);
	
	$laiks = time();
	$backup = mysql_query("insert into content_backup values (
	'',
	'$id',
	'$laiks',	
	'$row[name]',
	'$row[text]'
	)");
	
	$ren=mysql_query("Select * from content_backup where id='$name'");
	$row=mysql_fetch_array($ren);
	mysql_free_result($ren);

	$rens=mysql_query("update $tabula set text='$row[text]' where id='$id'");
}

$links = "member.php".$li;
header("Location: $links");
exit;

?>
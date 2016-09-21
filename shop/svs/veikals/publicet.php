<?php
//ielâdçjam funkcijas
require_once("config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

$res=mysql_query("Select * from items where id='$k'");
$ros=mysql_fetch_array($res);
if($ros["statuss"]=="1"){$st="2";}
else{$st="1";}
$result=mysql_query("update items set statuss='$st' where id='$k'"); 

$res=mysql_query("Select * from items where id='$k'");
$ros=mysql_fetch_array($res);
if($ros["statuss"]==1)
{
	$publicet=$pr[57];
}
else
{
	$publicet=$pr[58];
}

echo "<INPUT TYPE=\"Button\" VALUE=\"$publicet\" class=\"button1\" onclick=\"ChangeStatuss('statuss_$k','$k')\">";
?>
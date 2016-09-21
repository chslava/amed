<?php
//iel�d�jam funkcijas
require_once("config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

$res=mysqli_query($result_db,"Select * from items where id='$k'");
$ros=mysqli_fetch_array($res);
if($ros["statuss"]=="1"){$st="2";}
else{$st="1";}
$result=mysqli_query($result_db,"update items set statuss='$st' where id='$k'"); 

$res=mysqli_query($result_db,"Select * from items where id='$k'");
$ros=mysqli_fetch_array($res);
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
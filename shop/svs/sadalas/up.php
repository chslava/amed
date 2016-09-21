<?php
//iel�d�jam funkcijas
require_once("../config.php");
if($ar > 0){header("Location: ".$wolf_path."member.php$li");	exit;}
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

$rep=mysqli_query($result_db,"Select parent_id from $tabula where id='$id'");
$f=mysqli_fetch_array($rep);
mysqli_free_result($rep);

$rep=mysqli_query($result_db,"Select * from $tabula where place<'$iz' and parent_id='$f[parent_id]' and lang ='$ver' order by place desc limit 0, 1");

$place_old=$iz;
if($rop=mysqli_fetch_array($rep))
{
	$place_new=$rop["place"];
}
else
{
	$place_new=$place_old;
}
$nn=$rop["id"];
mysqli_free_result($rep);

$result = mysqli_query($result_db,"update $tabula set place='$place_old' where id='$nn'"); 
$result = mysqli_query($result_db,"update $tabula set place='$place_new' where id='$id'"); 

$links = $wolf_path."member.php".$li;
header("Location: $links");
exit;
?>
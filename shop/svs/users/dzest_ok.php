<?php
//iel�d�jam funkcijas
require_once("../config.php");
if($ar > 0){header("Location: ".$wolf_path."member.php$li");	exit;}
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

$rr=mysqli_query($result_db,"Select * from user where id='$_GET[name]'");
$rrr=mysqli_fetch_array($rr);
$useris=$rrr["username"];
mysqli_free_result($rr);

$cik = count($valodas);

$s=0;
while($s<$cik)
{
	$tab="content";
	$rr=mysqli_query($result_db,"Select * from $tab");
	while($rrr=mysqli_fetch_array($rr))
	{
		$info=$rrr["user"];
		$info=str_replace("$useris*","",$info);
		$ziel=mysqli_query($result_db,"update $tab set user='$info' where id='$rrr[id]'"); 
	}
mysqli_free_result($rr);
$s++;
}

$result=mysqli_query($result_db,"delete from user where id='$_GET[name]'");

$links = $wolf_path."users/index.php".$li1;
header("Location: $links");
exit;
?>
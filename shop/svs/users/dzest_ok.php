<?php
//ielâdçjam funkcijas
require_once("../config.php");
if($ar > 0){header("Location: ".$wolf_path."member.php$li");	exit;}
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

$rr=mysql_query("Select * from user where id='$_GET[name]'");
$rrr=mysql_fetch_array($rr);
$useris=$rrr["username"];
mysql_free_result($rr);

$cik = count($valodas);

$s=0;
while($s<$cik)
{
	$tab="content";
	$rr=mysql_query("Select * from $tab");
	while($rrr=mysql_fetch_array($rr))
	{
		$info=$rrr["user"];
		$info=str_replace("$useris*","",$info);
		$ziel=mysql_query("update $tab set user='$info' where id='$rrr[id]'"); 
	}
mysql_free_result($rr);
$s++;
}

$result=mysql_query("delete from user where id='$_GET[name]'");

$links = $wolf_path."users/index.php".$li1;
header("Location: $links");
exit;
?>
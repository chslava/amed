<?php
//ielâdçjam funkcijas
require_once("../config.php");
if($ar > 0){header("Location: ".$wolf_path."member.php$li");	exit;}
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

// izdzçðam visas apakðsadaïas
function dzest($parent_id,$tabula,$ver)
{
	$r1=mysql_query("Select * from $tabula where parent_id='$parent_id' and lang='$ver' order by place asc");
	while($f1=mysql_fetch_array($r1))
	{
		dzest($f1["id"],$tabula,$ver);
		
		
		
		mysql_query("delete from $tabula where id='$f1[id]'");
	}
}

$r=mysql_query("Select * from $tabula where id='$id' and lang='$ver' order by place asc");
$f=mysql_fetch_array($r);
dzest($f["id"],$tabula,$ver);
mysql_free_result($r);

// izdzçðam galveno sadaïu
if(mysql_query("delete from $tabula where id='$id'"))
{
	
}


$links = $wolf_path."member.php".$li1;
header("Location: $links");
exit;
?>
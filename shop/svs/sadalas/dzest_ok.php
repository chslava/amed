<?php
//iel�d�jam funkcijas
require_once("../config.php");
if($ar > 0){header("Location: ".$wolf_path."member.php$li");	exit;}
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

// izdz��am visas apak�sada�as
function dzest($parent_id,$tabula,$ver)
{
	$r1=mysqli_query($result_db,"Select * from $tabula where parent_id='$parent_id' and lang='$ver' order by place asc");
	while($f1=mysqli_fetch_array($r1))
	{
		dzest($f1["id"],$tabula,$ver);
		
		
		
		mysqli_query($result_db,"delete from $tabula where id='$f1[id]'");
	}
}

$r=mysqli_query($result_db,"Select * from $tabula where id='$id' and lang='$ver' order by place asc");
$f=mysqli_fetch_array($r);
dzest($f["id"],$tabula,$ver);
mysqli_free_result($r);

// izdz��am galveno sada�u
if(mysqli_query($result_db,"delete from $tabula where id='$id'"))
{
	
}


$links = $wolf_path."member.php".$li1;
header("Location: $links");
exit;
?>
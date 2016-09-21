<?php
/*error_reporting(0);*/
header('Content-Type: text/html; charset=utf-8');
session_name("amedicalsvs");
session_start();
$sess_id = session_id();
$frkohgb = "ok";
// Encoding
$encoding = "charset=utf-8";

// ielâdçjam ceïu
require_once("path.php");

// pieslçdzamies datubâzei
require_once($wolf_path."db.php");



// ielâdçjam funkcijas
require_once($wolf_path."funkcijas.php");

// ielâdçjam mainîgo GET pârbaudes failu
require_once($wolf_path."get.php");

// ielâdçjam valodas failu
require_once($wolf_path."lang/$lang/dati.php");

// izvçlamies mysql valodu tabulu
$tabula="categories";

$teksts = "";

if($id==0){
$row=mysql_query("Select id from $tabula where parent_id='0' order by place asc limit 0,1");
	if($fe=mysql_fetch_array($row))
	{
		$id=$fe["id"];
	}
	else
	{
		$id=0;
	}
mysql_free_result($row);
}

$li = "?lang=$lang&ver=$ver&id=$id";
$li1 = "?lang=$lang&ver=$ver";
$e = array();
$valo = "text_".$ver;
$ev=mysql_query("Select * from texts order by id asc");
while($es=mysql_fetch_array($ev))
{
	$gid = $es["id"];
	$e[$gid] = $es[$valo];
}
mysql_free_result($ev);

?>
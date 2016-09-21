<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");
$error="";

$rez=mysql_query("Select * from anketas where id='$name'");
$roz=mysql_fetch_array($rez);
mysql_free_result($rez);

$ren=mysql_query("Select * from anketas where value='1' order by place desc Limit 0, 1");
$row=mysql_fetch_array($ren);
$place=$row["place"];
if(empty($place))
{
	$place=1;
}
else
{
	$place++;
}
	
$result = mysql_query("insert into anketas values (
'',
'0',
'$place',
'1',
'$roz[lang]',
'$roz[name] - KOPIJA',
'$roz[email]',
'$roz[sent_text]',
'',
'',
'',
'',
'',
'',
'',
'$roz[before_text]',
'$roz[type]'
)"); 

$n_id = mysql_insert_id();

$rez=mysql_query("Select * from anketas where parent_id='$name' order by place asc");
while($roz=mysql_fetch_array($rez))
{	
	$result = mysql_query("insert into anketas values (
	'',
	'$n_id',
	'$roz[place]',
	'$roz[value]',
	'$roz[lang]',
	'$roz[name]',
	'$roz[email]',
	'$roz[sent_text]',
	'$roz[field_name]',
	'$roz[field_type]',
	'$roz[field_length]',
	'$roz[field_width]',
	'$roz[field_check]',
	'$roz[field_fill]',
	'$roz[field_value]',
	'$roz[before_text]',
	'$roz[type]'
	)");
}
mysql_free_result($rez);
		

$links = "index.php";
header("Location: $links");
exit;

?>
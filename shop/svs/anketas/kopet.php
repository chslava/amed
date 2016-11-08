<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");
$error="";

$rez=mysqli_query($result_db,"Select * from anketas where id='$name'");
$roz=mysqli_fetch_array($rez);
mysqli_free_result($rez);

$ren=mysqli_query($result_db,"Select * from anketas where value='1' order by place desc Limit 0, 1");
$row=mysqli_fetch_array($ren);
$place=$row["place"];
if(empty($place))
{
	$place=1;
}
else
{
	$place++;
}
	
$result = mysqli_query($result_db,"insert into anketas values (
null,
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

$n_id = mysqli_insert_id($result_db);

$rez=mysqli_query($result_db,"Select * from anketas where parent_id='$name' order by place asc");
while($roz=mysqli_fetch_array($rez))
{	
	$result = mysqli_query($result_db,"insert into anketas values (
	null,
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
mysqli_free_result($rez);
		

$links = "index.php";
header("Location: $links");
exit;

?>
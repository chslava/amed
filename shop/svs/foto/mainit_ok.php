<?php
//iel�d�jam funkcijas
require_once("../config.php");
if($ar > 0){header("Location: ".$wolf_path."member.php$li");	exit;}
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

$change_from=array("'","\\","&","\n");
$change_to=array("`","","&amp;","<br />");
		
$name_lv = trim(str_replace($change_from,$change_to,$_POST["name_lv"]));
$name_ru = trim(str_replace($change_from,$change_to,$_POST["name_ru"]));
$name_en = trim(str_replace($change_from,$change_to,$_POST["name_en"]));
$name_ee = trim(str_replace($change_from,$change_to,$_POST["name_ee"]));
$name_lt = trim(str_replace($change_from,$change_to,$_POST["name_lt"]));

$title_lv = trim(str_replace($change_from,$change_to,$_POST["title_lv"]));
$title_ru = trim(str_replace($change_from,$change_to,$_POST["title_ru"]));
$title_en = trim(str_replace($change_from,$change_to,$_POST["title_en"]));
$title_ee = trim(str_replace($change_from,$change_to,$_POST["title_ee"]));
$title_lt = trim(str_replace($change_from,$change_to,$_POST["title_lt"]));

$description_lv = trim(str_replace($change_from,$change_to,$_POST["description_lv"]));
$description_ru = trim(str_replace($change_from,$change_to,$_POST["description_ru"]));
$description_en = trim(str_replace($change_from,$change_to,$_POST["description_en"]));
$description_ee = trim(str_replace($change_from,$change_to,$_POST["description_ee"]));
$description_lt = trim(str_replace($change_from,$change_to,$_POST["description_lt"]));

$keywords_lv = trim(str_replace($change_from,$change_to,$_POST["keywords_lv"]));
$keywords_ru = trim(str_replace($change_from,$change_to,$_POST["keywords_ru"]));
$keywords_en = trim(str_replace($change_from,$change_to,$_POST["keywords_en"]));
$keywords_ee = trim(str_replace($change_from,$change_to,$_POST["keywords_ee"]));
$keywords_lt = trim(str_replace($change_from,$change_to,$_POST["keywords_lt"]));

$url_lv = trim(str_replace($change_from,$change_to,$_POST["url_lv"]));
$url_ru = trim(str_replace($change_from,$change_to,$_POST["url_ru"]));
$url_en = trim(str_replace($change_from,$change_to,$_POST["url_en"]));
$url_ee = trim(str_replace($change_from,$change_to,$_POST["url_ee"]));
$url_lt = trim(str_replace($change_from,$change_to,$_POST["url_lt"]));

$text_lv = mysqli_real_escape_string($result_db, str_replace($change_from,$change_to,$_POST["text_lv"]));
$text_ru = mysqli_real_escape_string($result_db, str_replace($change_from,$change_to,$_POST["text_ru"]));
$text_en = mysqli_real_escape_string($result_db, str_replace($change_from,$change_to,$_POST["text_en"]));
$text_ee = mysqli_real_escape_string($result_db, str_replace($change_from,$change_to,$_POST["text_ee"]));
$text_lt = mysqli_real_escape_string($result_db, str_replace($change_from,$change_to,$_POST["text_lt"]));

$limenis = trim(str_replace($change_from,$change_to,$_POST["limenis"]));

/*
$rep=mysqli_query($result_db,"Select * from albums where id='$name'");
$rop=mysqli_fetch_array($rep);
mysqli_free_result($rep);

if($rop["type"]!=$limenis)
{
	$ren=mysqli_query($result_db,"Select place from albums where parent_id = '$limenis' order by place desc Limit 0, 1");
	$row=mysqli_fetch_array($ren);
	mysqli_free_result($ren);

	// uzliekam jaunu main�go place
	$place=$row["place"];
	if(empty($place))
	{
		$place=1;
	}
	else
	{
		$place++;
	}
	
}	
else
{
	$place = $rop["place"];
}
*/

$result = mysqli_query($result_db,"update  albums set 

parent_id = '$limenis',

name_lv='$name_lv',
name_ru='$name_ru',
name_en='$name_en',
name_ee='$name_ee',
name_lt='$name_lt',

title_lv='$title_lv',
title_ru='$title_ru',
title_en='$title_en',
title_ee='$title_ee',
title_lt='$title_lt',

description_lv='$description_lv',
description_ru='$description_ru',
description_en='$description_en',
description_ee='$description_ee',
description_lt='$description_lt',

keywords_lv='$keywords_lv',
keywords_ru='$keywords_ru',
keywords_en='$keywords_en',
keywords_ee='$keywords_ee',
keywords_lt='$keywords_lt',

url_lv = '$url_lv',
url_ru = '$url_ru',
url_en = '$url_en',
url_ee = '$url_ee',
url_lt = '$url_lt',

text_lv = '$text_lv',
text_ru = '$text_ru',
text_en = '$text_en',
text_ee = '$text_ee',
text_lt = '$text_lt'


where id='$name'"); 
	
$links = "index.php".$li."&name=".$name;
header("Location: $links");
exit;
?>
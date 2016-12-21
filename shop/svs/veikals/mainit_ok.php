<?php
//iel�d�jam funkcijas
require_once("config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

$change_from=array("'","\\");
$change_to=array("`","");
		
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

$link_lv = trim(str_replace($change_from,$change_to,$_POST["link_lv"]));
$link_ru = trim(str_replace($change_from,$change_to,$_POST["link_ru"]));
$link_en = trim(str_replace($change_from,$change_to,$_POST["link_en"]));
$link_ee = trim(str_replace($change_from,$change_to,$_POST["link_ee"]));
$link_lt = trim(str_replace($change_from,$change_to,$_POST["link_lt"]));

$target_lv = trim(str_replace($change_from,$change_to,$_POST["target_lv"]));
$target_ru = trim(str_replace($change_from,$change_to,$_POST["target_ru"]));
$target_en = trim(str_replace($change_from,$change_to,$_POST["target_en"]));
$target_ee = trim(str_replace($change_from,$change_to,$_POST["target_ee"]));
$target_lt = trim(str_replace($change_from,$change_to,$_POST["target_lt"]));

$text_lv = mysqli_real_escape_string($result_db,str_replace($change_from,$change_to,$_POST["text_lv"]));
$text_ru = mysqli_real_escape_string($result_db,str_replace($change_from,$change_to,$_POST["text_ru"]));
$text_en = mysqli_real_escape_string($result_db,str_replace($change_from,$change_to,$_POST["text_en"]));
$text_ee = mysqli_real_escape_string($result_db,str_replace($change_from,$change_to,$_POST["text_ee"]));
$text_lt = mysqli_real_escape_string($result_db,str_replace($change_from,$change_to,$_POST["text_lt"]));

if(isset($_POST["discount"]))
{
	$discount=str_replace($change_from,$change_to,$_POST["discount"]);
	$discount=trim($discount);
}
else
{
	$discount = 2;
}


if(isset($_POST["group_type"]))
{
	$group_type=str_replace($change_from,$change_to,$_POST["group_type"]);
	$group_type=trim($group_type);
}
else
{
	$group_type = 1;
}

if(isset($_POST["type"]))
{
	$type=str_replace($change_from,$change_to,$_POST["type"]);
	$type=trim($type);
}
else
{
	$type = 0;
}

if(isset($_POST["industry"]))
{
	$industry=str_replace($change_from,$change_to,$_POST["industry"]);
	$industry=trim($industry);
}
else
{
	$industry = 0;
}


if(isset($_POST["style"]))
{
	$style=str_replace($change_from,$change_to,$_POST["style"]);
	$style=trim($style);
}
else
{
	$style = 0;
}

$result=mysqli_query($result_db,"update $tabula set 

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

target_lv='$target_lv',
target_ru='$target_ru',
target_en='$target_en',
target_ee='$target_ee',
target_lt='$target_lt',

link_lv='$link_lv',
link_ru='$link_ru',
link_en='$link_en',
link_ee='$link_ee',
link_lt='$link_lt',

url_lv = '$url_lv',
url_ru = '$url_ru',
url_en = '$url_en',
url_ee = '$url_ee',
url_lt = '$url_lt',

text_lv = '$text_lv',
text_ru = '$text_ru',
text_en = '$text_en',
text_ee = '$text_ee',
text_lt = '$text_lt',
type = '$type',
style = '$style',
group_type = '$group_type',
industry = '$industry',
discount = '$discount'

where id='$id'"); 

if($group_type == 2)
{
	$query = mysqli_query($result_db,"update branches_items set group_type = '0' where category_id = '$id'");
}
else
{
	
	$query = mysqli_query($result_db,"select * from branches_items where category_id = '$id'");
	while($mysql = mysqli_fetch_array($query))
	{
	
		$result= mysqli_query($result_db,"update branches_items set group_type = '$mysql[item_id]' where id = '$mysql[id]'");
		
	}
	mysqli_free_result($query);
}

$links = "index.php".$li;
header("Location: $links");
exit;
?>
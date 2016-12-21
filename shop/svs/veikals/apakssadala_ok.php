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


if(isset($_POST["group_type"]))
{
	$group_type=str_replace($change_from,$change_to,$_POST["group_type"]);
	$group_type=trim($group_type);
}
else
{
	$group_type = 1;
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

$ren=mysqli_query($result_db,"Select * from $tabula where parent_id='$id ' order by place desc Limit 0, 1");
$row=mysqli_fetch_array($ren);
mysqli_free_result($ren);

// uzliekam jaunu main�go place
$place=$row["place"];
$place++;


	$result = mysqli_query($result_db,"insert into $tabula values (null,'$id','2','$place','$title_ee','$title_lv','$title_lt','$title_ru','$title_en','$description_ee','$description_lv','$description_lt','$description_ru','$description_en','$keywords_ee','$keywords_lv','$keywords_lt','$keywords_ru','$keywords_en','$url_ee','$url_lv','$url_lt','$url_ru','$url_en','$name_ee','$name_lv','$name_lt','$name_ru','$name_en','$link_ee','$link_lv','$link_lt','$link_ru','$link_en','$target_ee','$target_lv','$target_ru','$target_ru','$target_en','$text_ee','$text_lv','$text_lt','$text_ru','$text_en','$type','$style','$group_type','$industry','$discount')"); 
	$n_id=mysqli_insert_id($result_db);
	if (!$result)
	return "<b>$head[2]</b>";
	

$links = "index.php".$li1."&id=$n_id";
header("Location: $links");
exit;
?>
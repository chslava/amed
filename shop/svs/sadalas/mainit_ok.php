<?php
//iel�d�jam funkcijas
require_once("../config.php");
if($ar > 0){header("Location: ".$wolf_path."member.php$li");	exit;}
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

$change_from=array("'","\\","&","<");
$change_to=array("`","","&amp;","&lt;");
		
$name=str_replace($change_from,$change_to,$_POST["name"]);
$name=trim($name);

$url=str_replace($change_from,$change_to,$_POST["url"]);
$url=trim($url);

$link=str_replace($change_from,$change_to,$_POST["link"]);
$link=trim($link);

$target=str_replace($change_from,$change_to,$_POST["target"]);
$target=trim($target);

if(empty($link)){$link="null";$target = "null";}

$title=str_replace($change_from,$change_to,$_POST["title"]);
$title=trim($title);

$description=str_replace($change_from,$change_to,$_POST["description"]);
$description=trim($description);

$keywords=str_replace($change_from,$change_to,$_POST["keywords"]);
$keywords=trim($keywords);

$template=str_replace($change_from,$change_to,$_POST["template"]);
$template=trim($template);

$type=str_replace($change_from,$change_to,$_POST["type"]);
$type=trim($type);

$anketa=str_replace($change_from,$change_to,$_POST["anketa"]);
$anketa=trim($anketa);

$icon=str_replace($change_from,$change_to,$_POST["icon"]);
$icon=trim($icon);

$album=str_replace($change_from,$change_to,$_POST["album"]);
$album=trim($album);

$choosen = $name;

$result=mysqli_query($result_db,"update $tabula set name='$name', link='$link', target='$target', title='$title', description='$description', keywords='$keywords', url='$url', choosen='$choosen', template = '$template', type = '$type', form = '$anketa', icon='$icon', album = '$album' where id='$id'"); 

$links = $wolf_path."member.php".$li;
header("Location: $links");
exit;
?>
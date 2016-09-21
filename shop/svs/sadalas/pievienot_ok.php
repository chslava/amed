<?php
//ielâdçjam funkcijas
require_once("../config.php");
if($ar > 0){header("Location: ".$wolf_path."member.php$li");	exit;}
//pârbaudam, vai lietotâjs ir reìistrçjies
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

$album=str_replace($change_from,$change_to,$_POST["album"]);
$album=trim($album);

$icon=str_replace($change_from,$change_to,$_POST["icon"]);
$icon=trim($icon);

	if($ver=="lv")
	{
		$under=$teksti[13];
	}
	if($ver=="en")
	{
		$under=$teksti[14];
	}
	if($ver=="ru")
	{
		$under=$teksti[15];
	}

// aizliedzam visiem useriem pieeju jaunajai sadaïai

	
	
	$ren=mysql_query("Select * from $tabula where id='$id'");
	$row=mysql_fetch_array($ren);
	
	$pp = $row["parent_id"];
	mysql_free_result($ren);
	
	$useri="";
	$rin=mysql_query("Select * from user");
	while($riw=mysql_fetch_array($rin))
	{
		if($riw["value"]=="no")
		{
			$useri=$useri.$riw["username"]."*";
		}
	}
	
	
	if($us=="no")
	{
		$useri=str_replace($_SESSION['valid_user']."*","",$useri);
	}
	
	

$choosen = $name;
if($row['parent_id']>0)
{
	while($row["parent_id"]>0)
	{	
		$ren=mysql_query("Select id,parent_id,name from $tabula where id='$row[parent_id]' order by place asc");
		$row=mysql_fetch_array($ren);
		mysql_free_result($ren);
		$choosen="<a href=\"$row[url]\" class=\"izveleta\">".$fe["name"]."</a> / ".$choosen;
			
	}
}
	

if($id!=0){

	$ren=mysql_query("Select * from $tabula where parent_id='$pp' and lang='$ver' order by place desc Limit 0, 1");
	$row=mysql_fetch_array($ren);
	mysql_free_result($ren);

	// uzliekam jaunu mainîgo place
	$place=$row["place"];
	$place++;






	// izveidojam jaunu pirmâs pakâpes sadaïu
	if($row["parent_id"]==0)
	{
		
		$result = mysql_query("insert into $tabula values ('','0','$ver','$place','off','on','$name','$under','','$title','$description','$keywords','$choosen','$url','$link','$target','$useri','$template','$type','$icon','$anketa','$album')"); 
		$n_id=mysql_insert_id();
		if (!$result)
		return "</b>$sadala[4]</b>";
	}
	
	// izveidojam n-tâs pakâpes sadaïu
	else
	{

	$choosen = $name;
		$result = mysql_query("insert into $tabula values ('','$pp','$ver','$place','off','on','$name','$under','','$title','$description','$keywords','$choosen','$url','$link','$target','$useri','$template','$type','$icon','$anketa','$album')"); 
		$n_id=mysql_insert_id();
		if (!$result)
		return "</b>$sadala[4]</b>";
	}
}

else
{
$choosen = $name;

	$result = mysql_query("insert into $tabula values ('','0','$ver','1','off','on','$name','$under','','$title','$description','$keywords','$choosen','$url','$link','$target','$useri','$template','$type','$icon','$anketa','$album')");
	$n_id=mysql_insert_id();
	if (!$result)
	return "</b>$sadala[4]</b>";
}

$links = $wolf_path."member.php".$li1."&id=$n_id";
header("Location: $links");
exit;
?>
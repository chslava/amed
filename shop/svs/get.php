<?php
// izdzçðam nevajadzîgos simbolus un pârbaudam mainîgâ $lv saturu, ja neeksistç, pieðíiram vçrtîbu "lv"
$valodas = array ("lv","en","ru");

if(!empty($_GET["lang"]))
{
	$lang=str_replace("<","",$_GET["lang"]);
	$lang=str_replace(">","",$lang);
	$lang=str_replace("'","",$lang);
	$lang=str_replace("/","",$lang);
	$lang=str_replace("\"","",$lang);
	$lang=str_replace("'","",$lang);
	$lang=str_replace("\'","",$lang);
	if(!empty($lang))
	{
		$cik=count($valodas); $n=0; $a=0;
		while($n<$cik)
		{
			if($lang==$valodas[$n])
			{
				$a++;
			}
			$n++;
		}
		if($a==0)
		{
			$lang="lv";
		}
	}
	else
	{
		$lang="lv";
	}
}
else
{
	$lang="lv";
}


if(!empty($_GET["ver"]))
{
	$ver=str_replace("<","",$_GET["ver"]);
	$ver=str_replace(">","",$ver);
	$ver=str_replace("'","",$ver);
	$ver=str_replace("/","",$ver);
	$ver=str_replace("\"","",$ver);
	$ver=str_replace("'","",$ver);
	$ver=str_replace("\'","",$ver);
	if(!empty($ver)){
	$cik=count($valodas); $n=0; $a=0;
		while($n<$cik){
			if($ver==$valodas[$n]){$a++;}
		$n++;
		}
		if($a==0){$ver="lv";}
	}
	else{$ver="lv";}
}
else
{
	$ver="lv";
}


$p_cipari="^([0-9]+)$";
// pârbaudam id vçrtîbu

if(!empty($_GET["id"])){
if(filter_var($_GET["id"], FILTER_VALIDATE_INT))
{
	$id=$_GET["id"];
}
else
{
	$id=0;
}
}
else{$id="0";}


$p_cipari="^([0-9]+)$";
// pârbaudam id vçrtîbu

if(!empty($_GET["k_id"])){
if(filter_var($_GET["k_id"], FILTER_VALIDATE_INT))
{
	$k_id=$_GET["k_id"];
}
else
{
	$k_id=0;
}
}
else{$k_id="0";}

// pârbaudam id vçrtîbu
if(!empty($_GET["k"])){
if(filter_var($_GET["k"], FILTER_VALIDATE_INT))
{
	$k=$_GET["k"];
}
else
{
	$k=0;
}
}
else{$k="0";}

// pârbaudam id vçrtîbu
if(!empty($_GET["name"])){
if(filter_var($_GET["name"], FILTER_VALIDATE_INT))
{
	$name=$_GET["name"];
}
else
{
	$name=0;
}
}
else{$name="0";}

if(!empty($_GET["num"])){
if(filter_var($_GET["num"], FILTER_VALIDATE_INT))
{
	$num=$_GET["num"];
}
else
{
	$num=0;
}
}
else{$num="0";}


// pârbaudam id vçrtîbu
if(!empty($_GET["iz"])){
if(filter_var($_GET["iz"], FILTER_VALIDATE_INT))
{
	$iz=$_GET["iz"];
}
else
{
	$iz=1;
}
}
else{$iz="1";}


// pârbaudam limit vçrtîbu
if(!empty($_GET["limit"])){
if(filter_var($_GET["limit"], FILTER_VALIDATE_INT))
{
	if(empty($_GET["limit"]))
	{
		$limit=0;
	}
	else
	{
		$limit=$_GET["limit"];
	}
}
else
{
	$limit=0;
}
}
else{$limit="0";}

if(!empty($_GET["page"])){
if(filter_var($_GET["page"], FILTER_VALIDATE_INT))
{
	if(empty($_GET["page"]))
	{
		$_GET["page"] = 1;
	}
}
else
{
	$_GET["page"] = 1;
}
}
else{$_GET["page"] = 1;}
?>
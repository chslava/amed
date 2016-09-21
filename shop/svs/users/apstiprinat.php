<?php
//ielâdçjam funkcijas
require_once("../config.php");
if($ar > 0){header("Location: ".$wolf_path."member.php$li");	exit;}
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

$ren=mysql_query("Select * from user where username='$_SESSION[valid_user]'");
$row=mysql_fetch_array($ren);
mysql_free_result($ren);
if($row["value"]=="yes")
{
	$ren1=mysql_query("Select * from user where id='$_GET[name]'");
	$row1=mysql_fetch_array($ren1);
	
	$rr=mysql_query("Select * from $tabula");
	while($rrr=mysql_fetch_array($rr))
	{
		$fi=explode("*",$rrr["user"]);
		$p=0;
		$cik=count($fi);
		while ($p<$cik)
		{
			$uk=each ($fi);
			if($uk["value"]==$row1["username"])
			{
				$key=$uk["key"];
				unset($fi[$key]);
			}
		$p++;
		}
		$info=implode("*",$fi);
		$ziel=mysql_query("update $tabula set user='$info' where id='$rrr[id]'"); 
	}
	mysql_free_result($rr);

	if(!empty($_POST["vvv"])){
	$n=0;
	$masivs="";
	while($n<count($_POST["vvv"]))
	{
		$line=each ($_POST["vvv"]);
		$masivs=$masivs."and id!='$line[value]'";
		$n++;
	}
	}
	else{
	$masivs="";
	}
	$ren2=mysql_query("Select * from $tabula where id>'0' $masivs");
	while($row2=mysql_fetch_array($ren2))
	{
		$result=mysql_query("update $tabula set user='$row2[user]$row1[username]*' where id='$row2[id]'"); 
	}



$info="";
$n=0;
$v=$_POST["valo"];
while($n<$v)
{
	if(!empty($valodas[$n])){
	$d_dd="valodas_$valodas[$n]";
	}
	else{$d_dd="";}
	if(!empty($_POST[$d_dd])){
	$d_d=$_POST[$d_dd];
	}
	else{
	$d_d="";
	}
	if(empty($d_d))
	{
		$info=$info.$valodas[$n]."*";
	}
$n++;
}

$rult=mysql_query("update user set lang='$info' where id='$name'");
}

$module_1 = "off";
if(isset($_POST["module_1"]))
{
	if($_POST["module_1"] == "on")
	{
		$module_1 = "on";
	}
}
$rult=mysql_query("update user set module_1='$module_1' where id='$name'");	


$module_2 = "off";
if(isset($_POST["module_2"]))
{
	if($_POST["module_2"] == "on")
	{
		$module_2 = "on";
	}
}
$rult=mysql_query("update user set module_2='$module_2' where id='$name'");	

$module_3 = "off";
if(isset($_POST["module_3"]))
{
	if($_POST["module_3"] == "on")
	{
		$module_3 = "on";
	}
}
$rult=mysql_query("update user set module_3='$module_3' where id='$name'");	

$module_4 = "off";
if(isset($_POST["module_4"]))
{
	if($_POST["module_4"] == "on")
	{
		$module_4 = "on";
	}
}
$rult=mysql_query("update user set module_4='$module_4' where id='$name'");	


$module_5 = "off";
if(isset($_POST["module_5"]))
{
	if($_POST["module_5"] == "on")
	{
		$module_5 = "on";
	}
}
$rult=mysql_query("update user set module_5='$module_5' where id='$name'");	


$module_6 = "off";
if(isset($_POST["module_6"]))
{
	if($_POST["module_6"] == "on")
	{
		$module_6 = "on";
	}
}
$rult=mysql_query("update user set module_6='$module_6' where id='$name'");	

$module_7 = "off";
if(isset($_POST["module_7"]))
{
	if($_POST["module_7"] == "on")
	{
		$module_7 = "on";
	}
}
$rult=mysql_query("update user set module_7='$module_7' where id='$name'");

$module_8 = "off";
if(isset($_POST["module_8"]))
{
	if($_POST["module_8"] == "on")
	{
		$module_8 = "on";
	}
}
$rult=mysql_query("update user set module_8='$module_8' where id='$name'");

$module_9 = "off";
if(isset($_POST["module_9"]))
{
	if($_POST["module_9"] == "on")
	{
		$module_9 = "on";
	}
}
$rult=mysql_query("update user set module_9='$module_9' where id='$name'");

$module_10 = "off";
if(isset($_POST["module_10"]))
{
	if($_POST["module_10"] == "on")
	{
		$module_10 = "on";
	}
}
$rult=mysql_query("update user set module_10='$module_10' where id='$name'");

$links = $wolf_path."users/index.php".$li1;
header("Location: $links");
exit;
?>
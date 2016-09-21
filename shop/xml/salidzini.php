<?php
header('Content-Type: text/html; charset=utf-8');

require_once("../include/config.php");

global $_xml;

$_xml ="<?xml version='1.0' encoding='utf-8' ?>
<root>";

$category="";

function izvelnes($parent_id,$category,$_xml)
{
	global $_xml;
	$r1=mysql_query("Select * from categories where parent_id='$parent_id' and statuss='2' order by place asc");
	while($f1=mysql_fetch_array($r1))
	{
		$category1=$category." &gt; ".$f1["name_lv"];
		$pr1=mysql_query("Select * from items where parent_id='$f1[id]' and statuss='2' order by place asc");
		while($pf1=mysql_fetch_array($pr1))
		{
			$price = $pf1["price"];
			if($pf1["discount"] == 2){
				if($pf1["discount_price"] > 0){
					$price = $pf1["price"] - $pf1["discount_price"];
				}else{
					$price = $pf1["price"] - $pf1["price"] * $pf1["discount_percent"] / 100;
				}
			}

			$_xml .="
			<item>
				<name>$pf1[name_lv]</name>
				<link>http://www.amedical.eu/lv/$pf1[url_lv]</link>
				<price>$price</price>
				<image>http://www.amedical.eu/pictures/items/big/$pf1[picture]</image>
				<category>$f1[name_lv]</category>
				<category_full>$category1</category_full>
				<category_link>http://www.amedical.eu/lv/$f1[url_lv]</category_link>
			</item>";
		}
		mysql_free_result($pr1);
		izvelnes($f1["id"],$category1,$_xml);
	}
	mysql_free_result($r1);
}


$r=mysql_query("Select * from categories where parent_id='0' and statuss='2' order by place asc");
while($f=mysql_fetch_array($r))
{
	$category=$f["name_lv"];
	$pr=mysql_query("Select * from items where parent_id='$f[id]' and statuss='2' order by place asc");
	while($pf=mysql_fetch_array($pr))
	{
		$price = $pf["price"];
		if($pf["discount"] == 2){
			if($pf["discount_price"] > 0){
				$price = $pf["price"] - $pf["discount_price"];
			}else{
				$price = $pf["price"] - $pf["price"] * $pf["discount_percent"] / 100;
			}
		}

		$_xml .="
		<item>
			<name>$pf[name_lv]</name>
			<link>http://www.amedical.eu/lv/$pf[url]</link>
			<price>$price</price>
			<image>http://www.amedical.eu/pictures/items/big/$pf[picture]</image>
			<category>$f[name_lv]</category>
			<category_full>$f[name_lv]</category_full>
			<category_link>http://www.amedical.eu/lv/$f[url_lv]</category_link>
		</item>";

	}
	mysql_free_result($pr);

	izvelnes($f["id"],$category,$_xml);
}
mysql_free_result($r);

$_xml .= "
</root>";

echo $_xml
?>
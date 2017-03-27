<?php
header('Content-Type: text/html; charset=utf-8');

require_once("../include/config.php");

global $_xml;

$_xml ="<?xml version='1.0' encoding='utf-8' ?>
<root>";

$category="";

function izvelnes($parent_id,$category,$_xml)
{
	global $result_db;
	global $_xml;
	$r1=mysqli_query($result_db,"Select * from categories where parent_id='$parent_id' and statuss='2' order by place asc");
	while($f1=mysqli_fetch_array($r1))
	{
		$category1=$category." &gt; ".$f1["name_lv"];
		$pr1=mysqli_query($result_db,"Select * from items where parent_id='$f1[id]' and statuss='2' and copy = '0' order by place asc");
		while($pf1=mysqli_fetch_array($pr1))
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
				<link>http://www.amedical.eu/shop/lv/$pf1[url_lv]</link>
				<price>$price</price>
				<image>http://www.amedical.eu/shop/pictures/items/big/$pf1[picture]</image>
				<category>$f1[name_lv]</category>
				<category_full>$category1</category_full>
				<category_link>http://www.amedical.eu/shop/lv/$f1[url_lv]</category_link>
			</item>";
		}
		mysqli_free_result($pr1);
		izvelnes($f1["id"],$category1,$_xml);
	}
	mysqli_free_result($r1);
}


$r=mysqli_query($result_db,"Select * from categories where parent_id='0' and statuss='2' order by place asc");
while($f=mysqli_fetch_array($r))
{
	$category=$f["name_lv"];
	$pr=mysqli_query($result_db,"Select * from items where parent_id='$f[id]' and statuss='2' and copy = '0' order by place asc");
	while($pf=mysqli_fetch_array($pr))
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
			<link>http://www.amedical.eu/shop/lv/$pf[url]</link>
			<price>$price</price>
			<image>http://www.amedical.eu/shop/pictures/items/big/$pf[picture]</image>
			<category>$f[name_lv]</category>
			<category_full>$f[name_lv]</category_full>
			<category_link>http://www.amedical.eu/shop/lv/$f[url_lv]</category_link>
		</item>";

	}
	mysqli_free_result($pr);

	izvelnes($f["id"],$category,$_xml);
}
mysqli_free_result($r);

$_xml .= "
</root>";

echo $_xml
?>
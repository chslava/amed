<?php
//iel�d�jam funkcijas
require_once("config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

// izdz��am visas apak�sada�as

$r=mysqli_query($result_db,"Select * from items where id='$name'");
$f=mysqli_fetch_array($r);
mysqli_free_result($r);

$ren=mysqli_query($result_db,"Select * from items where parent_id='$f[parent_id]' order by place desc Limit 0,1");
$row=mysqli_fetch_array($ren);
mysqli_free_result($ren);

$place=$row["place"];
$place++;

if (!empty($f["picture"]))
{
	$file = trim(str_replace("/","-",$f["url_lv"]));
	$name_file = $file.".jpg";
	$picture = $file."-".time().".jpg";
	
	copy("../../items/small/$f[picture]","../../items/small/$picture");
	
		
	copy("../../items/big/$f[picture]","../../items/big/$picture");
	
				
}
else
{
	$picture = "";
}

$rakstam=mysqli_query($result_db,"insert into items values 
	(
	'',
	'$f[parent_id]',
	'$place',
	'$f[statuss]',
	'$picture',
	
	'$f[title_lv]',
	'$f[title_ru]',
	'$f[title_en]',
	
	'$f[description_lv]',
	'$f[description_ru]',
	'$f[description_en]',
	
	'$f[keywords_lv]',
	'$f[keywords_ru]',
	'$f[keywords_en]',
	
	'$f[url_lv]',
	'$f[url_ru]',
	'$f[url_en]',
	
	'$f[name_lv]',
	'$f[name_ru]',
	'$f[name_en]',
	
	'$f[text_lv]',
	'$f[text_ru]',
	'$f[text_en]',
	
	'$f[code]',
	'$f[price]',
	'$f[discount]',
	'$f[discount_price]',
	'$f[new]',
	'$f[card_text]',
	'$f[items]'
	)");
	
	$n_id=mysqli_insert_id();
		

$links = "index.php".$li."&page=$_GET[page]";
header("Location: $links");
exit;
?>
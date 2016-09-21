<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotājs ir reìistrçjies
require_once($wolf_path."check.php");

$file = "keywords.txt";

function fopen_utf8($filename)
{
	$encoding='';
	$handle = fopen($filename, 'r');
	$bom = fread($handle,  2);
	//    fclose($handle);
	rewind($handle);
		
	if($bom === chr(0xff).chr(0xfe)  || $bom === chr(0xfe).chr(0xff))
	{
		// UTF16 Byte Order Mark present
		$encoding = 'UTF-16';
	}
	else
	{
		$file_sample = fread($handle, 1000) + 'e'; //read first 1000 bytes
		// + e is a workaround for mb_string bug
		rewind($handle);
			 
		$encoding = mb_detect_encoding($file_sample , 'UTF-8, UTF-7, ASCII, EUC-JP,SJIS, eucJP-win, SJIS-win, JIS, ISO-2022-JP');
	}
	if ($encoding)
	{
		stream_filter_append($handle, 'convert.iconv.'.$encoding.'/UTF-8');
	}
	return  ($handle);
} 

$file = fopen_utf8($file);

$ch_from = array("\"","'","\n");
$ch_to = array("","","");
    
$contents = fread($file,10485760);
$all = explode("\r",$contents);



	
for($i = 0; $i < count($all); $i++)
{
	$row = explode("\t",$all[$i]);
	
		if(isset($row[0])){ $name = mysql_real_escape_string(str_replace($ch_from,$ch_to,$row[0])); }	else{ $name = "";}
		/*				
		$write = mysql_query("insert into keywords values (
		'',
		'$name',
		'',
		'',
		'',			
		'',
		''
		    		
		)");
		
			*/
			echo "$name, ";
	
}
?>
<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

$change_from=array("\"","\'","'","\\","\n");
$change_to=array("&quot;","&rsquo;","&rsquo;","","<br>");

	
$change_from=array("'","\\","&","\n");
$change_to=array("`","","&amp;","<br />");
		
$comment_lv = trim(str_replace($change_from,$change_to,$_POST["comment_lv"]));
$comment_ru = trim(str_replace($change_from,$change_to,$_POST["comment_ru"]));
$comment_en = trim(str_replace($change_from,$change_to,$_POST["comment_en"]));


$rakstam=mysqli_query($result_db,"update pictures set 
	
		comment_lv = '$comment_lv',
		comment_ru = '$comment_ru',		
		comment_en = '$comment_en'
		
		where id='$k'");

echo "success";
?>
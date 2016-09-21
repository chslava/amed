<?php
//ielâdçjam funkcijas
require_once("../config.php");
if($ar > 0){header("Location: ".$wolf_path."member.php$li");	exit;}
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

if(empty($HTTP_POST_FILES["bilde"]["name"]))
{
	echo "$foto[17]";
	exit;
}

$change_from=array("'","\\","&","\n");
$change_to=array("`","","&amp;","<br />");
		
$comment_lv = trim(str_replace($change_from,$change_to,$_POST["comment_lv"]));
$comment_ru = trim(str_replace($change_from,$change_to,$_POST["comment_ru"]));
$comment_en = trim(str_replace($change_from,$change_to,$_POST["comment_en"]));

$name_file=$HTTP_POST_FILES["bilde"]["name"];
$filename=$HTTP_POST_FILES["bilde"]["tmp_name"];

$parb="off";
while($parb == "off")
{
	$n=6;
	$chars='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	$x="";
	srand((double)microtime()*1000000);  
	$m=strlen($chars);  
	while($n--) 
	{ 
 		$x.=substr($chars,rand()%$m,1); 
	} 
	$name_file = $x;
	
	if(file_exists("../../pictures/small/$name_file.jpg"))
	{
		$parb = "off";
	}
	else
	{
		$parb = "on";
	}
}

$nw = 100;
$nh = 68;
$source = $filename;

$dest = "../../pictures/small/$name_file.jpg";
		
$size = getimagesize($source);
$w = $size[0];
$h = $size[1];
$stype = $size[2]; 

switch($stype)
{
   case 1:
   $simg = imagecreatefromgif($source);
   break;
	
   case 2:
	$simg = imagecreatefromjpeg($source);
   break;
	
   case 3:
   $simg = imagecreatefrompng($source);
   break;
}
 
$dimg = imagecreatetruecolor($nw, $nh);
 
$wm = $w/$nw;
$hm = $h/$nh;
 
$h_height = $nh/2;
$w_height = $nw/2;
	 
if($w > $h)
{
	$adjusted_width = $w / $hm;
	if($adjusted_width<$nw)
	{
		$adjusted_height = $h / $wm;
   	$half_height = $adjusted_height / 2;
   	$int_height = $half_height - $h_height;
		imagecopyresampled($dimg,$simg,0,0,0,0,$nw,$adjusted_height,$w,$h);
	}
	else
	{
   	$half_width = $adjusted_width / 2;
   	$int_width = $half_width - $w_height;
		imagecopyresampled($dimg,$simg,-$int_width,0,0,0,$adjusted_width,$nh,$w,$h);
	}
}
elseif(($w < $h) || ($w == $h))
{
	$adjusted_height = $h / $wm;
   $half_height = $adjusted_height / 2;
   $int_height = $half_height - $h_height;
   imagecopyresampled($dimg,$simg,0,0,0,0,$nw,$adjusted_height,$w,$h);
}
else
{
   imagecopyresampled($dimg,$simg,0,0,0,0,$nw,$nh,$w,$h);
}

imagejpeg($dimg,$dest,90);
//chmod($dest, 0777);

	 
$newwidth = 500;
$percent = $newwidth/$w;
$newheight = round($h * $percent);

$dimg = imagecreatetruecolor($newwidth, $newheight);
imagecopyresampled ($dimg, $simg, 0, 0, 0, 0, $newwidth, $newheight, $w, $h);
imagejpeg($dimg,'../../pictures/big/'.$name_file.".jpg",90);
//chmod('../../pictures/big/'.$name_file.".jpg", 0777);


$ren1=mysqli_query($result_db,"Select place from pictures where parent_id='$name' order by place desc limit 0,1");
$row1=mysqli_fetch_array($ren1);
mysqli_free_result($ren1);
$place=$row1["place"];

if(empty($place))
{
	$place=1;
}
else
{
	$place++;
}

$laiks=time(); 
$result = mysqli_query($result_db,"insert into pictures values ('','$name','$name_file','$place','$laiks','$comment_lv','$comment_ru','$comment_en')"); 
if(!$result){
echo "$foto[18]";
exit;
}

$links = "foto_p.php".$li1."&name=$name";
header("Location: $links");
exit;
?>
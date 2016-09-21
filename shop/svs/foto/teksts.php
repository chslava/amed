<?php
//ielâdçjam funkcijas
require_once("../config.php");
if($ar > 0){header("Location: ".$wolf_path."member.php$li");	exit;}
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

$ww = 562;
$hh = 436;


$newfile = "../uploads/images/galerijas/galerija_8.jpg";

//PHP's GD class functions can create a variety of output image 
//types, this example creates a jpeg 
header("Content-Type: image/jpeg"); 

//open up the image you want to put text over 
$im = imagecreatefromjpeg($newfile); 

//The numbers are the RGB values of the color you want to use 
$black = imagecolorallocate($im, 0, 0, 0); 

$font_size = 25;

//The canvas's (0,0) position is the upper left corner 
//So this is how far down and to the right the text should start 

$text = "text to write";
$start_x = round(($ww/2)-((strlen($text)*imagefontwidth($font_size))/2), 1); 
$start_y = round(($hh/2)-(imagefontheight($font_size)/2)); 


//This writes your text on the image in 12 point using verdana.ttf 
//For the type of effects you quoted, you'll want to use a truetype font 
//And not one of GD's built in fonts. Just upload the ttf file from your 
//c: windows fonts directory to your web server to use it. 
imagettftext($im, $font_size, 0, $start_x, $start_y, $black, 'tahoma.ttf', $text); 

//Creates the jpeg image and sends it to the browser 
//100 is the jpeg quality percentage 
imagejpeg ($im,'',100);

imagedestroy($im); 


?>
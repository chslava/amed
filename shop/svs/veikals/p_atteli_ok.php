<?php
//iel�d�jam funkcijas
require_once("config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");
if(isset($_POST["add-file"]))
{
	if (!empty($HTTP_POST_FILES["picture"]["name"]))
	{
		$gh=$HTTP_POST_FILES["picture"]["name"];
		
		$filename=$HTTP_POST_FILES["picture"]["tmp_name"];
		$source = $filename;
		
		$req=mysqli_query($result_db,"Select * from images where parent_id = '$name' order by place desc Limit 0, 1");
		if($roq=mysqli_fetch_array($req))
		{
			$place = $roq["place"];
			$place++;
		}
		else
		{
			$place = 1;
		}
		mysqli_free_result($req);
		
		$ext = substr(strrchr($gh,'.'),1);
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
			$name_file = $x.".".$ext;
			
			if(file_exists("../../items/small/$name_file"))
			{
				$parb = "off";
			}
			else
			{
				$parb = "on";
			}
		}
		
		$picture = $name_file;
		
			
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
		
		
		
		
		
		$nw = 150;
		$nh = 150;		
		$dest = "../../items/small/$name_file";		
		 
		$newwidth = $nw;
		$percent = $newwidth/$w;
		$newheight = round($h * $percent);
				
		if($newheight>$nh)
		{
			$newheight = $nh;
			$percent = $newheight/$h;
			$newwidth = round($w * $percent);			
		}
		
		$img_left = ($nw - $newwidth) / 2;		
		$img_top = ($nh - $newheight) / 2;
		
		$dimg = imagecreatetruecolor($nw, $nh);
		$white = imagecolorallocate($dimg, 255, 255, 255);
		imagefilledrectangle($dimg, 0, 0, $nw, $nh, $white);
		imagecopyresampled ($dimg, $simg, $img_left, $img_top, 0, 0, $newwidth, $newheight, $w, $h);	 
		imagejpeg($dimg,$dest,90);
		chmod($dest, 0777); 
		
		
		
		
		$nw = 250;
		$nh = 250;		
		$dest = "../../items/big/$name_file";
		$dimg = imagecreatetruecolor($nw, $nh);
		 
		$newwidth = $nw;
		$percent = $newwidth/$w;
		$newheight = round($h * $percent);
				
		if($newheight>$nh)
		{
			$newheight = $nh;
			$percent = $newheight/$h;
			$newwidth = round($w * $percent);			
		}
		
		$img_left = ($nw - $newwidth) / 2;		
		$img_top = ($nh - $newheight) / 2;
		
		$dimg = imagecreatetruecolor($nw, $nh);
		$white = imagecolorallocate($dimg, 255, 255, 255);
		imagefilledrectangle($dimg, 0, 0, $nw, $nh, $white);
		imagecopyresampled ($dimg, $simg, $img_left, $img_top, 0, 0, $newwidth, $newheight, $w, $h);	 
		imagejpeg($dimg,$dest,90);
		chmod($dest, 0777);
		
		
	}
	
	$rakstam = mysqli_query($result_db,"insert into images values (
		'',
		'$name',
		'$place',
		'$name_file'
		)");
		
		$links = "p_atteli.php".$li."&name=$name";
header("Location: $links");
exit;
		
		
}
	
?>
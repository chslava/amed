<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

if(isset($_POST["submit"]))
{
	if (!empty($_FILES["icon"]["name"]))
	{
		$filename=$_FILES["icon"]["tmp_name"];
		$source = $filename;
		
		$size = getimagesize($source);
		$w = $size[0];
		$h = $size[1];		
		$stype = $size[2];			
				
		switch($stype)
		{
			case 1:
			$source = imagecreatefromgif($source);		
			break;
			
			case 2:
			$source = imagecreatefromjpeg($source);			
			break;
			
			case 3:
			$source = imagecreatefrompng($source);
			break;
		}
		
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
			
			if(file_exists("../../images/icons/$name_file.png"))
			{
				$parb = "off";
			}
			else
			{
				$parb = "on";
			}
		}		
		$picture = $name_file.".png";	
		
		
		$newwidth = 25;
		$percent = $newwidth/$w;
		$newheight = round($h * $percent);
		$thumb = imagecreatetruecolor($newwidth, $newheight);			
		imagealphablending($thumb, false);
		imagecopyresampled ($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $w, $h);
		imagesavealpha($thumb, true);
		imagepng($thumb,"../../images/icons/$dir/".$picture);
		chmod("../../images/icons/".$picture, 0777);	
		
		/*
			$newheight = 50;
			$percent = $newheight/$height;
			$newwidth = round($width * $percent);
			$thumb = imagecreatetruecolor($newwidth, $newheight);
			if($type==3)
			{
				imagealphablending($thumb, false);
			}
			imagecopyresampled ($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			if($type==3)
			{
				imagesavealpha($thumb, true);
				$funk($thumb,"../../symbols/small/$dir/".$name_file);
			}
			else
			{
				$funk($thumb,"../../symbols/small/$dir/".$name_file,90);
			}
			chmod("../../symbols/small/$dir/".$name_file, 0777);	*/
	}
	
	$links = "index.php".$li1;
	header("Location: $links");
	exit;
}


?>

<html>
	<head>
		<title><?php echo $head[0]; ?></title>
		<meta http-equiv="Content-Type" content="text/html; <?php echo $head[1]; ?>">
		<link rel="stylesheet" href="<?php echo $wolf_path; ?>style.css" type="text/css">
		<script language="JavaScript">
			function go( url){
			window.location.href = url;
			}
		</script>
		<style>
			.thumb {
				float: left;
				margin: 0 5px 5px 0;
				border: 1px solid #d0d2dd;
				padding: 5px;
				text-align: center;
			}
		</style>
	</head>
	<body leftmargin="0" topmargin="0" background="<?php echo $wolf_path; ?>img/fons.gif" marginheight="0" marginwidth="0">
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
		<?php	require_once($wolf_path."augsa.php");?>
			<tr>
				<td colspan="2" valign="top" height="25">
				<?php require_once($wolf_path."menu.php"); ?>
				</td>
			</tr>
			<tr>
				<td colspan="2" height="20" bgcolor="d0d2dd">&nbsp;</td>
			</tr>
			<tr>
				<td bgcolor="#ffffff" width="100%" valign="top" class="text">
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
                  		<tr>
                     		<td height="30" valign="top" class="sad"><a href="index.php<?php echo $li1; ?>" class="sad_link"><?php echo $menu_it[42]; ?></a></td>
                  		</tr>
                  		<tr>
                  			<td height="30" valign="top">
                  				<form action="index.php<?php echo $li1; ?>" method="post" name="add-icon" enctype="multipart/form-data" style="margin:0px;">
                  					<input type="file" class="input" name="icon" /> <input type="submit" class="button" name="submit" value="<?php echo $teksti[162]; ?>">
                  				</form>
                  			</td>
                  		</tr>
               		</table>
					<table cellpadding="0" cellspacing="0" border="0" >
	  	    			<tr>
		 					<td class="text1">
		 				  	<?php 
						
							$direk="../../images/icons/";
	  						$d=opendir($direk);
							$s=1;
	  						while(($files=readdir($d))!==false)
							{
							
	  							$filename=$direk.$files;
	   							if($files=="."||$files==".." || $files=="Thumbs.db" || $files==".DS_Store"){}
	  							else{
									
							
									echo "
									<div class=\"thumb\">
										<form method=\"get\" action=\"\" name=\"a\" style=\"margin:0px;\">
											<p><img  src=\"../../images/icons/$files\" width=\"25\" height=\"25\" /></p>
											<p><INPUT TYPE=Button VALUE=\"$teksti[23]\" class=button2 onclick='go(\"dzest_ok.php?file=$files\")'></p>									
										</form> 
									</div>";
									$s++;
							}							
						}
						?>
		 				  </td>
	   				</tr>						
			    	</table>
	 				
					
				</td>
			</tr>
		</table>
	</body>
</html>


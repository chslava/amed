<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

$error = "";
if(isset($_POST["submit"])){

	$change_from=array("\"","\'","'","\\","\n","&");
	$change_to=array("&quot;","&rsquo;","&rsquo;","","<br />","&amp;");

	$name_surname=trim(str_replace($change_from,$change_to,$_POST["name_surname"]));
	$phone=trim(str_replace($change_from,$change_to,$_POST["phone"]));
	$email=trim(str_replace($change_from,$change_to,$_POST["email"]));
	
	
	$n=10;				
	$chars='abcdefghijklmnopqrstuvwxyz1234567890';
	$code="";
						
	srand((double)microtime()*1000000);  
	$m=strlen($chars);  
	while($n--) 
	{ 
		$code.=substr($chars,rand()%$m,1); 
	} 	
	
	if (!empty($_FILES["photo"]["name"]))
	{
		$name_file = $code.".jpg";
		if(file_exists("../../pictures/persons/small/$name_file"))
		{
			$name_file = $file."-".time().".jpg";			
		}
		
		$photo = $name_file;
		
		$filename=$_FILES["photo"]["tmp_name"];
		$source = $filename;
		
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
		
		$nw = 120;
		$nh = 160;		
		$dest = "../../pictures/persons/small/$name_file";		
		 
		if($w >= $nw)
		{
			$newwidth = $nw;
			$percent = $newwidth/$w;
			$newheight = round($h * $percent);
					
			if($newheight>$nh)
			{
				$newheight = $nh;
				$percent = $newheight/$h;
				$newwidth = round($w * $percent);			
			}
		}
		else
		{
			$newwidth = $w;
			$percent = $newwidth/$w;
			$newheight = round($h * $percent);
					
			if($newheight>$nh)
			{
				$newheight = $nh;
				$percent = $newheight/$h;
				$newwidth = round($w * $percent);			
			}
		}
				
		$dimg = imagecreatetruecolor($newwidth, $newheight);
		$white = imagecolorallocate($dimg, 255, 255, 255);
		imagefilledrectangle($dimg, 0, 0, $newheight, $newheight, $white);
		imagecopyresampled ($dimg, $simg, 0, 0, 0, 0, $newwidth, $newheight, $w, $h);	 
		imagejpeg($dimg,$dest,90);
		chmod($dest, 0777); 
		
		
		$nw = 480;
		$nh = 320;		
		$dest = "../../pictures/persons/big/$name_file";
		$dimg = imagecreatetruecolor($nw, $nh);
		 
		if($w >= $nw)
		{
			$newwidth = $nw;
			$percent = $newwidth/$w;
			$newheight = round($h * $percent);
					
			if($newheight>$nh)
			{
				$newheight = $nh;
				$percent = $newheight/$h;
				$newwidth = round($w * $percent);			
			}
		}
		else
		{
			$newwidth = $w;
			$percent = $newwidth/$w;
			$newheight = round($h * $percent);
					
			if($newheight>$nh)
			{
				$newheight = $nh;
				$percent = $newheight/$h;
				$newwidth = round($w * $percent);			
			}
		}
		
		$dimg = imagecreatetruecolor($newwidth, $newheight);
		$white = imagecolorallocate($dimg, 255, 255, 255);
		imagefilledrectangle($dimg, 0, 0, $newheight, $newheight, $white);
		imagecopyresampled ($dimg, $simg, 0, 0, 0, 0, $newwidth, $newheight, $w, $h);	 
		imagejpeg($dimg,$dest,90);
		chmod($dest, 0777); 		
	}
	else
	{
		$photo = "";
	}
	
		
	$result = mysql_query("insert into persons values (
	'',
	'1',
	'$photo',
	'$name_surname',
	'$name_surname',
	'$name_surname',
	'$name_surname',
	'$name_surname',
	
	'',
	'',
	'',
	'',
	'',
	
	'$email',		
	'$phone'
	)");
		
	$n_id = mysql_insert_id();
	$links = "index.php".$li1;
	header("Location: $links");
	exit;

}
else
{
	$name_surname="";
	$phone = "";
	$email = "";

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
					
					<table cellpadding="0" cellspacing="0" width="100%">
						<tr>
		 				  <td height="30" valign="top" class="sad"><a href="index.php<?php echo $li1; ?>" class="sad_link"><?php echo $menu_it[8]; ?></a> <img src="<?php echo $wolf_path; ?>img/next.gif" align="absmiddle"> <a href="pievienot.php<?php echo $li1; ?>" class="sad_link"><?php echo $brokers[49]; ?></a></td>
	   					</tr>
	   					<tr>
                       		<td height="10" ></td>
                      	</tr>
	   				</table>
	   				
	   				<form name="jaunumi" enctype="multipart/form-data" action="pievienot.php<?php echo "$li1"; ?>" method="post">
					<table cellpadding="5" cellspacing="1" border="0" style="border: 1px solid #d0d2dd" width="100%">
                    	<tr>
                        	<td class="standart" bgcolor="#f2f3f7" colspan="2"><b><?php echo $brokers[50]; ?></b></td>
                      	</tr>
						
                        <tr>
							<td valign="middle" align="right" class="standart" width="250"><b><?php echo $brokers[51]; ?></b></td>
							<td valign="middle" class="text1"><input type="text" name="name_surname" style="width: 300px" class="input" value="<?php echo $name_surname; ?>"></td>
						</tr>
                        <tr>
							<td valign="middle" align="right" class="standart" width="250"><b><?php echo $brokers[52]; ?></b></td>
							<td valign="middle" class="text1"><input type="text" name="phone" style="width: 300px" class="input" value="<?php echo $phone; ?>"></td>
						</tr>
                        
                        <tr>
							<td valign="middle" align="right" class="standart" width="250"><b><?php echo $brokers[55]; ?></b></td>
							<td valign="middle" class="text1"><input type="text" name="email" style="width: 200px" class="input" value="<?php echo $email; ?>"></td>
						</tr>
                        
                        <tr>
							<td valign="middle" align="right" class="standart" width="250"><b><?php echo $brokers[54]; ?></b></td>
							<td valign="middle" class="text1"><input type="file" name="photo" class="input"></td>
						</tr>
                        
                                                
                        <tr> 
                  			<td valign="middle" align="right" class="standart" width="150"></td>                	
                     		<td valign="middle" align="left" colspan="2"><INPUT TYPE=Button VALUE="<?php echo $jaunumi[36];?>" class=button onclick='go("index.php<?php echo $li1."&limit=$limit"; ?>")'> <input type="submit" name="submit" class="button" value="<?php echo $brokers[56]; ?>"></td>
                  		</tr>
               		</table>   
					</form>
						
					
					
				</td>
			</tr>
		</table>
	</body>
</html>


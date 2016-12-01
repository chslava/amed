<?php
//ielâdçjam funkcijas
require_once("config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

$ren=mysqli_query($result_db,"Select * from titulpage where id='1'");
$row=mysqli_fetch_array($ren);
mysqli_free_result($ren);

$current_pictures = array($row["picture_1"],$row["picture_2"],$row["picture_3"]);
$error = "";

if(isset($_POST["submit"]))
{
	$change_from=array("\"","\'","'","\n","\\");
	$change_to=array("&quot;","","","<br />","");
	
	$change_from1=array("\\r","\\n","\\","'");
	$change_to1=array("","","","&lsquo;");
	
	$name_1_lv = trim(str_replace($change_from,$change_to,$_POST["name_1_lv"]));
	$name_1_ru = trim(str_replace($change_from,$change_to,$_POST["name_1_ru"]));
	$name_1_en = trim(str_replace($change_from,$change_to,$_POST["name_1_en"]));
	$name_1_ee = trim(str_replace($change_from,$change_to,$_POST["name_1_ee"]));
	$name_1_lt = trim(str_replace($change_from,$change_to,$_POST["name_1_lt"]));
	
	$name_2_lv = trim(str_replace($change_from,$change_to,$_POST["name_2_lv"]));
	$name_2_ru = trim(str_replace($change_from,$change_to,$_POST["name_2_ru"]));
	$name_2_en = trim(str_replace($change_from,$change_to,$_POST["name_2_en"]));
	$name_2_ee = trim(str_replace($change_from,$change_to,$_POST["name_2_ee"]));
	$name_2_lt = trim(str_replace($change_from,$change_to,$_POST["name_2_lt"]));
	
	$name_3_lv = trim(str_replace($change_from,$change_to,$_POST["name_3_lv"]));
	$name_3_ru = trim(str_replace($change_from,$change_to,$_POST["name_3_ru"]));
	$name_3_en = trim(str_replace($change_from,$change_to,$_POST["name_3_en"]));
	$name_3_ee = trim(str_replace($change_from,$change_to,$_POST["name_3_ee"]));
	$name_3_lt = trim(str_replace($change_from,$change_to,$_POST["name_3_lt"]));
	
	$paragraph_1_lv = trim(str_replace($change_from,$change_to,$_POST["paragraph_1_lv"]));
	$paragraph_1_ru = trim(str_replace($change_from,$change_to,$_POST["paragraph_1_ru"]));
	$paragraph_1_en = trim(str_replace($change_from,$change_to,$_POST["paragraph_1_en"]));
	$paragraph_1_ee = trim(str_replace($change_from,$change_to,$_POST["paragraph_1_ee"]));
	$paragraph_1_lt = trim(str_replace($change_from,$change_to,$_POST["paragraph_1_lt"]));
	
	$paragraph_2_lv = trim(str_replace($change_from,$change_to,$_POST["paragraph_2_lv"]));
	$paragraph_2_ru = trim(str_replace($change_from,$change_to,$_POST["paragraph_2_ru"]));
	$paragraph_2_en = trim(str_replace($change_from,$change_to,$_POST["paragraph_2_en"]));
	$paragraph_2_ee = trim(str_replace($change_from,$change_to,$_POST["paragraph_2_ee"]));
	$paragraph_2_lt = trim(str_replace($change_from,$change_to,$_POST["paragraph_2_lt"]));
	
	$paragraph_3_lv = trim(str_replace($change_from,$change_to,$_POST["paragraph_3_lv"]));
	$paragraph_3_ru = trim(str_replace($change_from,$change_to,$_POST["paragraph_3_ru"]));
	$paragraph_3_en = trim(str_replace($change_from,$change_to,$_POST["paragraph_3_en"]));
	$paragraph_3_ee = trim(str_replace($change_from,$change_to,$_POST["paragraph_3_ee"]));
	$paragraph_3_lt = trim(str_replace($change_from,$change_to,$_POST["paragraph_3_lt"]));
	
	$url_1_lv = trim(str_replace($change_from,$change_to,$_POST["url_1_lv"]));
	$url_1_ru = trim(str_replace($change_from,$change_to,$_POST["url_1_ru"]));
	$url_1_en = trim(str_replace($change_from,$change_to,$_POST["url_1_en"]));
	$url_1_ee = trim(str_replace($change_from,$change_to,$_POST["url_1_ee"]));
	$url_1_lt = trim(str_replace($change_from,$change_to,$_POST["url_1_lt"]));
	
	$url_2_lv = trim(str_replace($change_from,$change_to,$_POST["url_2_lv"]));
	$url_2_ru = trim(str_replace($change_from,$change_to,$_POST["url_2_ru"]));
	$url_2_en = trim(str_replace($change_from,$change_to,$_POST["url_2_en"]));
	$url_2_ee = trim(str_replace($change_from,$change_to,$_POST["url_2_ee"]));
	$url_2_lt = trim(str_replace($change_from,$change_to,$_POST["url_2_lt"]));
	
	$url_3_lv = trim(str_replace($change_from,$change_to,$_POST["url_3_lv"]));
	$url_3_ru = trim(str_replace($change_from,$change_to,$_POST["url_3_ru"]));
	$url_3_en = trim(str_replace($change_from,$change_to,$_POST["url_3_en"]));
	$url_3_ee = trim(str_replace($change_from,$change_to,$_POST["url_3_ee"]));
	$url_3_lt = trim(str_replace($change_from,$change_to,$_POST["url_3_lt"]));
		
	$text_lv = mysqli_real_escape_string($result_db, trim(preg_replace('#<\?xml[^(/>)]*/>#m','',$_POST["text_lv"])));
	$text_ru = mysqli_real_escape_string($result_db, trim(preg_replace('#<\?xml[^(/>)]*/>#m','',$_POST["text_ru"])));
	$text_en = mysqli_real_escape_string($result_db, trim(preg_replace('#<\?xml[^(/>)]*/>#m','',$_POST["text_en"])));
	$text_ee = mysqli_real_escape_string($result_db, trim(preg_replace('#<\?xml[^(/>)]*/>#m','',$_POST["text_ee"])));
	$text_lt = mysqli_real_escape_string($result_db, trim(preg_replace('#<\?xml[^(/>)]*/>#m','',$_POST["text_lt"])));
	
	$text_lv = str_replace($change_from1,$change_to1,$text_lv);
	$text_ru = str_replace($change_from1,$change_to1,$text_ru);
	$text_en = str_replace($change_from1,$change_to1,$text_en);
	$text_ee = str_replace($change_from1,$change_to1,$text_ee);
	$text_lt = str_replace($change_from1,$change_to1,$text_lt);
			
	$pictures = array("picture_1","picture_2","picture_3");
	$all_pictures = array();
	
	for($i = 0; $i < count($pictures); $i++)
	{
		$selected_file = $pictures[$i];
		if (!empty($_FILES[$selected_file]["name"]))
		{
			$filename = $_FILES[$selected_file]["tmp_name"];
			$source = $filename;
			
			$ext = "jpg";
			$parb = "off";
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
			    
			    if(file_exists("../pictures/titul/$name_file"))
			    {
			    	$parb = "off";
			    }
			    else
			    {
			    	$parb = "on";
			    }
			}
			
			$picture = $name_file;		
			$all_pictures[$i] = $picture;				
			
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
			
			$nw = 302;
			$nh = 120;	
			$dest = "../pictures/titul/$picture";	
				
			$wm = $w/$nw;
			$hm = $h/$nh;
			 
			$h_height = $nh/2;
			$w_height = $nw/2;
				 
			$dimg = imagecreatetruecolor($nw, $nh);
			$white = imagecolorallocate($dimg, 255, 255, 255);
			imagefilledrectangle($dimg, 0, 0, $nw, $nh, $white);
			
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
			chmod($dest, 0777);
			
			unlink("../pictures/titul/".$current_pictures[$i]);	
				
		}
		else
		{
			$all_pictures[$i] = $current_pictures[$i];								
		}
	}
		
	$rakstam=mysqli_query($result_db,"update titulpage set 
	
	name_1_ee = '$name_1_ee',
  	name_1_lv = '$name_1_lv',
  	name_1_lt = '$name_1_lt',
  	name_1_ru = '$name_1_ru',
  	name_1_en = '$name_1_en',
  	
  	name_2_ee = '$name_2_ee',
  	name_2_lv = '$name_2_lv',
  	name_2_lt = '$name_2_lt',
  	name_2_ru = '$name_2_ru',
  	name_2_en = '$name_2_en',
  	
  	name_3_ee = '$name_3_ee',
  	name_3_lv = '$name_3_lv',
  	name_3_lt = '$name_3_lt',
  	name_3_ru = '$name_3_ru',
  	name_3_en = '$name_3_en',
  	
  	paragraph_1_ee = '$paragraph_1_ee',
  	paragraph_1_lv = '$paragraph_1_lv',
  	paragraph_1_lt = '$paragraph_1_lt',
  	paragraph_1_ru = '$paragraph_1_ru',
  	paragraph_1_en = '$paragraph_1_en',
  	
  	paragraph_2_ee = '$paragraph_2_ee',
  	paragraph_2_lv = '$paragraph_2_lv',
  	paragraph_2_lt = '$paragraph_2_lt',
  	paragraph_2_ru = '$paragraph_2_ru',
  	paragraph_2_en = '$paragraph_2_en',
  	
  	paragraph_3_ee = '$paragraph_3_ee',
  	paragraph_3_lv = '$paragraph_3_lv',
  	paragraph_3_lt = '$paragraph_3_lt',
  	paragraph_3_ru = '$paragraph_3_ru',
  	paragraph_3_en = '$paragraph_3_en',  
  	  	
  	url_1_ee = '$url_1_ee',
  	url_1_lv = '$url_1_lv',
  	url_1_lt = '$url_1_lt',
  	url_1_ru = '$url_1_ru',
  	url_1_en = '$url_1_en',
  	
  	url_2_ee = '$url_2_ee',
  	url_2_lv = '$url_2_lv',
  	url_2_lt = '$url_2_lt',
  	url_2_ru = '$url_2_ru',
  	url_2_en = '$url_2_en',
  	
  	url_3_ee = '$url_3_ee',
  	url_3_lv = '$url_3_lv',
  	url_3_lt = '$url_3_lt',
  	url_3_ru = '$url_3_ru',
  	url_3_en = '$url_3_en',
  	
  	text_ee = '$text_ee',
  	text_lv = '$text_lv',
  	text_lt = '$text_lt',
  	text_ru = '$text_ru',
  	text_en = '$text_en',
	
	picture_1 = '$all_pictures[0]',
	picture_2 = '$all_pictures[1]',
	picture_3 = '$all_pictures[2]'
		
	where id='1'");
	
	$links = "member.php".$li1;
	header("Location: $links");
	exit;
	
}
else
{
	$ren=mysqli_query($result_db,"Select * from titulpage where id='1'");
	$row=mysqli_fetch_array($ren);
	mysqli_free_result($ren);
	
	$name_1_lv=$row["name_1_lv"];
	$name_1_ru=$row["name_1_ru"];
	$name_1_en=$row["name_1_en"];
	$name_1_ee=$row["name_1_ee"];
	$name_1_lt=$row["name_1_lt"];	
	
	$name_2_lv=$row["name_2_lv"];
	$name_2_ru=$row["name_2_ru"];
	$name_2_en=$row["name_2_en"];
	$name_2_ee=$row["name_2_ee"];
	$name_2_lt=$row["name_2_lt"];
	
	$name_3_lv=$row["name_3_lv"];
	$name_3_ru=$row["name_3_ru"];
	$name_3_en=$row["name_3_en"];
	$name_3_ee=$row["name_3_ee"];
	$name_3_lt=$row["name_3_lt"];
	
	$paragraph_1_lv=$row["paragraph_1_lv"];
	$paragraph_1_ru=$row["paragraph_1_ru"];
	$paragraph_1_en=$row["paragraph_1_en"];
	$paragraph_1_ee=$row["paragraph_1_ee"];
	$paragraph_1_lt=$row["paragraph_1_lt"];
	
	$paragraph_2_lv=$row["paragraph_2_lv"];
	$paragraph_2_ru=$row["paragraph_2_ru"];
	$paragraph_2_en=$row["paragraph_2_en"];
	$paragraph_2_ee=$row["paragraph_2_ee"];
	$paragraph_2_lt=$row["paragraph_2_lt"];
	
	$paragraph_3_lv=$row["paragraph_3_lv"];
	$paragraph_3_ru=$row["paragraph_3_ru"];
	$paragraph_3_en=$row["paragraph_3_en"];
	$paragraph_3_ee=$row["paragraph_3_ee"];
	$paragraph_3_lt=$row["paragraph_3_lt"];
	
	$text_lv=$row["text_lv"];
	$text_ru=$row["text_ru"];
	$text_en=$row["text_en"];
	$text_ee=$row["text_ee"];
	$text_lt=$row["text_lt"];
		
	$url_1_lv=$row["url_1_lv"];
	$url_1_ru=$row["url_1_ru"];
	$url_1_en=$row["url_1_en"];
	$url_1_ee=$row["url_1_ee"];
	$url_1_lt=$row["url_1_lt"];
	
	$url_2_lv=$row["url_2_lv"];
	$url_2_ru=$row["url_2_ru"];
	$url_2_en=$row["url_2_en"];
	$url_2_ee=$row["url_2_ee"];
	$url_2_lt=$row["url_2_lt"];
	
	$url_3_lv=$row["url_3_lv"];
	$url_3_ru=$row["url_3_ru"];
	$url_3_en=$row["url_3_en"];
	$url_3_ee=$row["url_3_ee"];
	$url_3_lt=$row["url_3_lt"];
	
	$picture_1=$row["picture_1"];
	$picture_2=$row["picture_2"];
	$picture_3=$row["picture_3"];
		
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
			
						
			function changeLanguageLV() {
				document.getElementById('lv').className = 'select-on';
				document.getElementById('ru').className = 'select';
				document.getElementById('en').className = 'select';
				document.getElementById('ee').className = 'select';
				document.getElementById('lt').className = 'select';
				document.getElementById('lv-content').style.display = "block";
				document.getElementById('ru-content').style.display = "none";
				document.getElementById('en-content').style.display = "none";
				document.getElementById('ee-content').style.display = "none";
				document.getElementById('lt-content').style.display = "none";
			}
			
			function changeLanguageRU() {
				document.getElementById('lv').className = 'select';
				document.getElementById('ru').className = 'select-on';
				document.getElementById('en').className = 'select';
				document.getElementById('ee').className = 'select';
				document.getElementById('lt').className = 'select';
				document.getElementById('lv-content').style.display = "none";
				document.getElementById('ru-content').style.display = "block";
				document.getElementById('en-content').style.display = "none";
				document.getElementById('ee-content').style.display = "none";
				document.getElementById('lt-content').style.display = "none";
			}
			
			function changeLanguageEN() {
				document.getElementById('lv').className = 'select';
				document.getElementById('ru').className = 'select';
				document.getElementById('en').className = 'select-on';
				document.getElementById('ee').className = 'select';
				document.getElementById('lt').className = 'select';
				document.getElementById('lv-content').style.display = "none";
				document.getElementById('ru-content').style.display = "none";
				document.getElementById('en-content').style.display = "block";
				document.getElementById('ee-content').style.display = "none";
				document.getElementById('lt-content').style.display = "none";
			}
			
			function changeLanguageEE() {
				document.getElementById('lv').className = 'select';
				document.getElementById('ru').className = 'select';
				document.getElementById('en').className = 'select';
				document.getElementById('ee').className = 'select-on';
				document.getElementById('lt').className = 'select';
				document.getElementById('lv-content').style.display = "none";
				document.getElementById('ru-content').style.display = "none";
				document.getElementById('en-content').style.display = "none";
				document.getElementById('ee-content').style.display = "block";
				document.getElementById('lt-content').style.display = "none";
			}
			
			function changeLanguageLT() {
				document.getElementById('lv').className = 'select';
				document.getElementById('ru').className = 'select';
				document.getElementById('en').className = 'select';
				document.getElementById('ee').className = 'select';
				document.getElementById('lt').className = 'select-on';
				document.getElementById('lv-content').style.display = "none";
				document.getElementById('ru-content').style.display = "none";
				document.getElementById('en-content').style.display = "none";
				document.getElementById('ee-content').style.display = "none";
				document.getElementById('lt-content').style.display = "block";
			}
		</script>
      <script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
		<script type="text/javascript" src="tinymce/jscripts/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>
		<script type="text/javascript">
		tinyMCE.init({
		        // General options
		       mode : "exact",
				theme : "advanced",
				elements : "text_lv, text_ru, text_en, text_lt, text_ee",
				
				file_browser_callback : "tinyBrowser",
				content_css : 'editor_style.css',    
   				relative_urls : false, 
        		remove_script_host : false,
		        theme_advanced_blockformats : 'partners-border',
				theme_advanced_styles : "<?php echo $teksti[153]; ?>=partners-border",
				entity_encoding : "raw",
		        plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
		        
		
		        // Theme options
		        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,removeformat,|,sub,sup",
			theme_advanced_buttons2 : "pastetext,pasteword,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,image,code,media,|,forecolor,backcolor",
			theme_advanced_buttons3 : "",		        theme_advanced_toolbar_location : "top",
		        theme_advanced_toolbar_align : "left",
		        theme_advanced_statusbar_location : "bottom",
		        theme_advanced_resizing : true,
		
		        // Skin options
		        skin : "o2k7",
		        skin_variant : "silver",
		
		        // Example content CSS (should be your site CSS)
		        content_css : "editor_style.css",
		
		        // Drop lists for link/image/media/template dialogs
		        template_external_list_url : "tinymce/js/template_list.js",
		        external_link_list_url : "tinymce/js/link_list.js",
		        external_image_list_url : "tinymce/js/image_list.js",
		        media_external_list_url : "tinymce/js/media_list.js",
		
		        // Replace values for the template plugin
		        template_replace_values : {
		            username : "<?php echo $_SESSION['valid_user']; ?>",
					staffid : "<?php echo $sess_id; ?>"
		        }
		});
		</script>
      
      <style>
			#lv-content {
				display:block;
			}
			
			#ru-content {
				display:none;
			}
			
			#en-content {
				display:none;
			}
			
			#ee-content {
				display:none;
			}
			
			#lt-content {
				display:none;
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
		 					<td height="30" valign="top" class="sad"><a href="index.php<?php echo $li; ?>" class="sad_link"><?php echo $menu_it[23]; ?></a></td>
	   					</tr>	  	    	
			   		</table>
					<table cellpadding="0" cellspacing="0" border="0" width="100%" >
               			<tr>
               				 <td class="standart" style="border-bottom: 1px solid #d0d2dd;">&nbsp;</td>
                		     <td id="lv" class="select-on"><a href="javascript: void(0)" onClick="changeLanguageLV()"><?php echo $head[2]; ?></a></td>               		                    
                		     <td width="5" style="border-bottom: 1px solid #d0d2dd;">&nbsp;</td>
                		     <td id="ru" class="select"><a href="javascript: void(0)" onClick="changeLanguageRU()"><?php echo $head[3]; ?></a></td>
                		     <td width="5" style="border-bottom: 1px solid #d0d2dd;">&nbsp;</td>
                		     <td id="en" class="select"><a href="javascript: void(0)" onClick="changeLanguageEN()"><?php echo $head[4]; ?></a></td>
                		     <td width="5" style="border-bottom: 1px solid #d0d2dd;">&nbsp;</td>
                		     <td id="ee" class="select"><a href="javascript: void(0)" onClick="changeLanguageEE()"><?php echo $head[5]; ?></a></td>
                		     <td width="5" style="border-bottom: 1px solid #d0d2dd;">&nbsp;</td>
                		     <td id="lt" class="select"><a href="javascript: void(0)" onClick="changeLanguageLT()"><?php echo $head[6]; ?></a></td>  
                		  </tr>
               		</table>
               
               		<form action="titulpage.php<?php echo $li."&name=$name&page=$_GET[page]"; ?>" method="post" name="jaunumi" enctype="multipart/form-data" style="margin:0px;">
               
					<table cellpadding="5" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd; border-top:none; border-bottom:none;" id="lv-content">
               			<tr>
                     		<td class="standart" bgcolor="#f2f3f7" colspan="8"><b><?php echo $titulpage[0]; ?></b></td>
                  		</tr>						
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>1.<?php echo $titulpage[1]; ?></b></td>
							<td valign="middle"><input type="text" name="name_1_lv" class="input" style="width: 270px" value="<?php echo $name_1_lv; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>1.<?php echo $titulpage[3]; ?></b></td>
							<td valign="middle"><input type="text" name="url_1_lv" class="input" style="width: 270px" value="<?php echo $url_1_lv; ?>"></td>
						</tr>
						<tr>
							<td valign="top" align="right" class="standart" width="200"><b>1.<?php echo $titulpage[2]; ?></b></td>
							<td valign="middle"><textarea name="paragraph_1_lv" style="width:500px; height:50px;" class="input"><?php echo $paragraph_1_lv; ?></textarea></td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>2.<?php echo $titulpage[1]; ?></b></td>
							<td valign="middle"><input type="text" name="name_2_lv" class="input" style="width: 270px" value="<?php echo $name_2_lv; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>2.<?php echo $titulpage[3]; ?></b></td>
							<td valign="middle"><input type="text" name="url_2_lv" class="input" style="width: 270px" value="<?php echo $url_2_lv; ?>"></td>
						</tr>
						<tr>
							<td valign="top" align="right" class="standart" width="200"><b>2.<?php echo $titulpage[2]; ?></b></td>
							<td valign="middle"><textarea name="paragraph_2_lv" style="width:500px; height:50px;" class="input"><?php echo $paragraph_2_lv; ?></textarea></td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>3.<?php echo $titulpage[1]; ?></b></td>
							<td valign="middle"><input type="text" name="name_3_lv" class="input" style="width: 270px" value="<?php echo $name_3_lv; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>3.<?php echo $titulpage[3]; ?></b></td>
							<td valign="middle"><input type="text" name="url_3_lv" class="input" style="width: 270px" value="<?php echo $url_3_lv; ?>"></td>
						</tr>
						<tr>
							<td valign="top" align="right" class="standart" width="200"><b>3.<?php echo $titulpage[2]; ?></b></td>
							<td valign="middle"><textarea name="paragraph_3_lv" style="width:500px; height:50px;" class="input"><?php echo $paragraph_3_lv; ?></textarea></td>
						</tr>
						<tr>
							<td valign="top" align="right" class="standart" width="200"><b><?php echo $titulpage[4]; ?></b></td>
							<td valign="middle"><textarea name="text_lv" style="width:500px; height:50px;" class="input"><?php echo $text_lv; ?></textarea></td>
						</tr>
					</table>
               
               		<table cellpadding="5" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd; border-top:none; border-bottom:none;" id="ru-content">
               			<tr>
                     		<td class="standart" bgcolor="#f2f3f7" colspan="8"><b><?php echo $titulpage[0]; ?></b></td>
                  		</tr>						
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>1.<?php echo $titulpage[1]; ?></b></td>
							<td valign="middle"><input type="text" name="name_1_ru" class="input" style="width: 270px" value="<?php echo $name_1_ru; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>1.<?php echo $titulpage[3]; ?></b></td>
							<td valign="middle"><input type="text" name="url_1_ru" class="input" style="width: 270px" value="<?php echo $url_1_ru; ?>"></td>
						</tr>
						<tr>
							<td valign="top" align="right" class="standart" width="200"><b>1.<?php echo $titulpage[2]; ?></b></td>
							<td valign="middle"><textarea name="paragraph_1_ru" style="width:500px; height:50px;" class="input"><?php echo $paragraph_1_ru; ?></textarea></td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>2.<?php echo $titulpage[1]; ?></b></td>
							<td valign="middle"><input type="text" name="name_2_ru" class="input" style="width: 270px" value="<?php echo $name_2_ru; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>2.<?php echo $titulpage[3]; ?></b></td>
							<td valign="middle"><input type="text" name="url_2_ru" class="input" style="width: 270px" value="<?php echo $url_2_ru; ?>"></td>
						</tr>
						<tr>
							<td valign="top" align="right" class="standart" width="200"><b>2.<?php echo $titulpage[2]; ?></b></td>
							<td valign="middle"><textarea name="paragraph_2_ru" style="width:500px; height:50px;" class="input"><?php echo $paragraph_2_ru; ?></textarea></td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>3.<?php echo $titulpage[1]; ?></b></td>
							<td valign="middle"><input type="text" name="name_3_ru" class="input" style="width: 270px" value="<?php echo $name_3_ru; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>3.<?php echo $titulpage[3]; ?></b></td>
							<td valign="middle"><input type="text" name="url_3_ru" class="input" style="width: 270px" value="<?php echo $url_3_ru; ?>"></td>
						</tr>
						<tr>
							<td valign="top" align="right" class="standart" width="200"><b>3.<?php echo $titulpage[2]; ?></b></td>
							<td valign="middle"><textarea name="paragraph_3_ru" style="width:500px; height:50px;" class="input"><?php echo $paragraph_3_ru; ?></textarea></td>
						</tr>
						<tr>
							<td valign="top" align="right" class="standart" width="200"><b><?php echo $titulpage[4]; ?></b></td>
							<td valign="middle"><textarea name="text_ru" style="width:500px; height:50px;" class="input"><?php echo $text_ru; ?></textarea></td>
						</tr>
					</table>
               
               		<table cellpadding="5" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd; border-top:none; border-bottom:none;" id="en-content">
               			<tr>
                     		<td class="standart" bgcolor="#f2f3f7" colspan="8"><b><?php echo $titulpage[0]; ?></b></td>
                  		</tr>						
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>1.<?php echo $titulpage[1]; ?></b></td>
							<td valign="middle"><input type="text" name="name_1_en" class="input" style="width: 270px" value="<?php echo $name_1_en; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>1.<?php echo $titulpage[3]; ?></b></td>
							<td valign="middle"><input type="text" name="url_1_en" class="input" style="width: 270px" value="<?php echo $url_1_en; ?>"></td>
						</tr>
						<tr>
							<td valign="top" align="right" class="standart" width="200"><b>1.<?php echo $titulpage[2]; ?></b></td>
							<td valign="middle"><textarea name="paragraph_1_en" style="width:500px; height:50px;" class="input"><?php echo $paragraph_1_en; ?></textarea></td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>2.<?php echo $titulpage[1]; ?></b></td>
							<td valign="middle"><input type="text" name="name_2_en" class="input" style="width: 270px" value="<?php echo $name_2_en; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>2.<?php echo $titulpage[3]; ?></b></td>
							<td valign="middle"><input type="text" name="url_2_en" class="input" style="width: 270px" value="<?php echo $url_2_en; ?>"></td>
						</tr>
						<tr>
							<td valign="top" align="right" class="standart" width="200"><b>2.<?php echo $titulpage[2]; ?></b></td>
							<td valign="middle"><textarea name="paragraph_2_en" style="width:500px; height:50px;" class="input"><?php echo $paragraph_2_en; ?></textarea></td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>3.<?php echo $titulpage[1]; ?></b></td>
							<td valign="middle"><input type="text" name="name_3_en" class="input" style="width: 270px" value="<?php echo $name_3_en; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>3.<?php echo $titulpage[3]; ?></b></td>
							<td valign="middle"><input type="text" name="url_3_en" class="input" style="width: 270px" value="<?php echo $url_3_en; ?>"></td>
						</tr>
						<tr>
							<td valign="top" align="right" class="standart" width="200"><b>3.<?php echo $titulpage[2]; ?></b></td>
							<td valign="middle"><textarea name="paragraph_3_en" style="width:500px; height:50px;" class="input"><?php echo $paragraph_3_en; ?></textarea></td>
						</tr>
						<tr>
							<td valign="top" align="right" class="standart" width="200"><b><?php echo $titulpage[4]; ?></b></td>
							<td valign="middle"><textarea name="text_en" style="width:500px; height:50px;" class="input"><?php echo $text_en; ?></textarea></td>
						</tr>                 
					</table>
					
					<table cellpadding="5" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd; border-top:none; border-bottom:none;" id="ee-content">
               			<tr>
                     		<td class="standart" bgcolor="#f2f3f7" colspan="8"><b><?php echo $titulpage[0]; ?></b></td>
                  		</tr>						
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>1.<?php echo $titulpage[1]; ?></b></td>
							<td valign="middle"><input type="text" name="name_1_ee" class="input" style="width: 270px" value="<?php echo $name_1_ee; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>1.<?php echo $titulpage[3]; ?></b></td>
							<td valign="middle"><input type="text" name="url_1_ee" class="input" style="width: 270px" value="<?php echo $url_1_ee; ?>"></td>
						</tr>
						<tr>
							<td valign="top" align="right" class="standart" width="200"><b>1.<?php echo $titulpage[2]; ?></b></td>
							<td valign="middle"><textarea name="paragraph_1_ee" style="width:500px; height:50px;" class="input"><?php echo $paragraph_1_ee; ?></textarea></td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>2.<?php echo $titulpage[1]; ?></b></td>
							<td valign="middle"><input type="text" name="name_2_ee" class="input" style="width: 270px" value="<?php echo $name_2_ee; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>2.<?php echo $titulpage[3]; ?></b></td>
							<td valign="middle"><input type="text" name="url_2_ee" class="input" style="width: 270px" value="<?php echo $url_2_ee; ?>"></td>
						</tr>
						<tr>
							<td valign="top" align="right" class="standart" width="200"><b>2.<?php echo $titulpage[2]; ?></b></td>
							<td valign="middle"><textarea name="paragraph_2_ee" style="width:500px; height:50px;" class="input"><?php echo $paragraph_2_ee; ?></textarea></td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>3.<?php echo $titulpage[1]; ?></b></td>
							<td valign="middle"><input type="text" name="name_3_ee" class="input" style="width: 270px" value="<?php echo $name_3_ee; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>3.<?php echo $titulpage[3]; ?></b></td>
							<td valign="middle"><input type="text" name="url_3_ee" class="input" style="width: 270px" value="<?php echo $url_3_ee; ?>"></td>
						</tr>
						<tr>
							<td valign="top" align="right" class="standart" width="200"><b>3.<?php echo $titulpage[2]; ?></b></td>
							<td valign="middle"><textarea name="paragraph_3_ee" style="width:500px; height:50px;" class="input"><?php echo $paragraph_3_ee; ?></textarea></td>
						</tr>
						<tr>
							<td valign="top" align="right" class="standart" width="200"><b><?php echo $titulpage[4]; ?></b></td>
							<td valign="middle"><textarea name="text_ee" style="width:500px; height:50px;" class="input"><?php echo $text_ee; ?></textarea></td>
						</tr>                 
					</table>
					
					<table cellpadding="5" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd; border-top:none; border-bottom:none;" id="lt-content">
               			<tr>
                     		<td class="standart" bgcolor="#f2f3f7" colspan="8"><b><?php echo $titulpage[0]; ?></b></td>
                  		</tr>						
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>1.<?php echo $titulpage[1]; ?></b></td>
							<td valign="middle"><input type="text" name="name_1_lt" class="input" style="width: 270px" value="<?php echo $name_1_lt; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>1.<?php echo $titulpage[3]; ?></b></td>
							<td valign="middle"><input type="text" name="url_1_lt" class="input" style="width: 270px" value="<?php echo $url_1_lt; ?>"></td>
						</tr>
						<tr>
							<td valign="top" align="right" class="standart" width="200"><b>1.<?php echo $titulpage[2]; ?></b></td>
							<td valign="middle"><textarea name="paragraph_1_lt" style="width:500px; height:50px;" class="input"><?php echo $paragraph_1_lt; ?></textarea></td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>2.<?php echo $titulpage[1]; ?></b></td>
							<td valign="middle"><input type="text" name="name_2_lt" class="input" style="width: 270px" value="<?php echo $name_2_lt; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>2.<?php echo $titulpage[3]; ?></b></td>
							<td valign="middle"><input type="text" name="url_2_lt" class="input" style="width: 270px" value="<?php echo $url_2_lt; ?>"></td>
						</tr>
						<tr>
							<td valign="top" align="right" class="standart" width="200"><b>2.<?php echo $titulpage[2]; ?></b></td>
							<td valign="middle"><textarea name="paragraph_2_lt" style="width:500px; height:50px;" class="input"><?php echo $paragraph_2_lt; ?></textarea></td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>3.<?php echo $titulpage[1]; ?></b></td>
							<td valign="middle"><input type="text" name="name_3_lt" class="input" style="width: 270px" value="<?php echo $name_3_lt; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>3.<?php echo $titulpage[3]; ?></b></td>
							<td valign="middle"><input type="text" name="url_3_lt" class="input" style="width: 270px" value="<?php echo $url_3_lt; ?>"></td>
						</tr>
						<tr>
							<td valign="top" align="right" class="standart" width="200"><b>3.<?php echo $titulpage[2]; ?></b></td>
							<td valign="middle"><textarea name="paragraph_3_lt" style="width:500px; height:50px;" class="input"><?php echo $paragraph_3_lt; ?></textarea></td>
						</tr>
						<tr>
							<td valign="top" align="right" class="standart" width="200"><b><?php echo $titulpage[4]; ?></b></td>
							<td valign="middle"><textarea name="text_lt" style="width:500px; height:50px;" class="input"><?php echo $text_lt; ?></textarea></td>
						</tr>                
					</table>
               
               
               		<table cellpadding="5" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd; border-top:none;" >  
               			<tr>
                     		<td class="standart" bgcolor="#f2f3f7" colspan="8"><b><?php echo $item[66]; ?></b></td>
                  		</tr>	  
                  		<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>1.<?php echo $titulpage[6]; ?></b></td>
							<td valign="middle"><img src="../pictures/titul/<?php echo $picture_1; ?>"></td>
						</tr>      	
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>1.<?php echo $titulpage[5]; ?></b></td>
							<td valign="middle"><input type="file" name="picture_1" class="input"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>2.<?php echo $titulpage[6]; ?></b></td>
							<td valign="middle"><img src="../pictures/titul/<?php echo $picture_2; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>2.<?php echo $titulpage[5]; ?></b></td>
							<td valign="middle"><input type="file" name="picture_2" class="input"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>3.<?php echo $titulpage[6]; ?></b></td>
							<td valign="middle"><img src="../pictures/titul/<?php echo $picture_3; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b>3.<?php echo $titulpage[5]; ?></b></td>
							<td valign="middle"><input type="file" name="picture_3" class="input"></td>
						</tr>     
					</table>
               		<table cellpadding="0" cellspacing="0" border="0"> 
              			<tr>
                  			<td valign="middle" height="30"><INPUT TYPE=Button VALUE="<?php echo $text[5];?>" class=button onclick='go("index.php<?php echo $li."&limit=$limit"; ?>")' style="margin:0px;"> <input type="submit" name="submit" class="button" value="<?php echo $item[28]; ?>"></td>
						</tr>						
					</table>
					</form>
					
				</td>
			</tr>
		</table>
	</body>
</html>


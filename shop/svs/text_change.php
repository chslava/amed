<?php
//iel�d�jam funkcijas
require_once("config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once("check.php");

if(isset($_POST["submit1"]))
{
	$ren=mysqli_query($result_db,"Select * from $tabula where id='$id'");
	$row=mysqli_fetch_array($ren);
	mysqli_free_result($ren);
	$text=stripslashes ($_POST["content"]);
	$text=str_replace("'","`",$text);
	$text = preg_replace('#<\?xml[^(/>)]*/>#m','',$text);

	$laiks = time();
	$backup = mysqli_query($result_db,"insert into content_backup values (
	null,
	'$id',
	'$laiks',	
	'$row[name]',
	'$row[text]'
	)");
	
	$rakstam=mysqli_query($result_db,"update $tabula set text='$text',accept='on' where id='$id'");
	if (!$rakstam)
	{
		echo "<font color='#CC0000'>$teksti[36]</font>";
		exit;
	}
	else
	{
		$result=mysqli_query($result_db,"update $tabula set cahce = '' where id='$id'"); 
		
	header("Location: member.php$li");
	exit;
	}
}

if(isset($_POST["submit2"]))
{

	$ren=mysqli_query($result_db,"Select * from $tabula where id='$id'");
	$row=mysqli_fetch_array($ren);
	mysqli_free_result($ren);
	$text=stripslashes ($_POST["content"]);
	$text=str_replace("'","`",$text);
	$text = preg_replace('#<\?xml[^(/>)]*/>#m','',$text);
	
	$rens=mysqli_query($result_db,"update $tabula set cache='$text', accept='off' where id='$id'");
	header("Location: member.php$li");
		
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
		<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
		<script type="text/javascript" src="tinymce/jscripts/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>
		<script type="text/javascript">
		tinyMCE.init({
		        // General options
		        mode : "textareas",
		        theme : "advanced",
		        content_css : 'editor_style.css',		            
   				relative_urls : false, 
        		remove_script_host : false,
		        theme_advanced_blockformats : 'partners-border, hidetext, showbullet, showbullet0',
				theme_advanced_styles : "<?php echo $teksti[153]; ?>=partners-border; <?php echo $teksti[155]; ?>=hidetext; <?php echo $teksti[156]; ?>=showbullet; <?php echo $teksti[157]; ?>=showbullet0", 
				entity_encoding : "raw",
		        file_browser_callback : "tinyBrowser",
		        plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
		        
		
		        // Theme options
		       theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",	        theme_advanced_toolbar_location : "top",
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
				<td colspan="2" height="20" bgcolor="d0d2dd">
				<?php require_once($wolf_path."izveleta.php"); ?>
				</td>
			</tr>
			<tr>
				<td width="250" valign="top" bgcolor="#f2f3f7">
				<?php require_once($wolf_path."page_menu.php"); ?>
				</td>
				<td bgcolor="#ffffff" width="100%" valign="top" class="text">
											<?php
				$file=explode("*",$fer["user"]);
				$ar=0;
				for ($s=0; $s<count($file); $s++){
				$line=each ($file);
				if($line["value"]==$_SESSION['valid_user']){$ar++;}
				}
				
				if($us=="no" && $ar > 0){
				echo $teksti[40];
				}
				else{?>
            <form action="" name="test" method="post">
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
					
						<tr>
   						<td valign="top"><INPUT TYPE="Submit" VALUE="<?php echo $teksti[33]; ?>" class="button" name="submit1">&nbsp;</td>
							<td valign="top"><INPUT TYPE="Submit" VALUE="<?php echo $teksti[34]; ?>" class="button" name="submit2">&nbsp;</td>
							<td valign="top"><INPUT TYPE="Button" VALUE="<?php echo $teksti[35]; ?>" class="button" onclick='go("<?php echo $wolf_path; ?>member.php<?php echo $li; ?>")'>&nbsp;</td>
							<td width="100%"></td>
  					</tr>
						<tr><td height="5"></td></tr>
					</table>
					<table cellpadding="0"  cellspacing="0" border="0" width="100%">
						<tr>
							<td>
							<?php

							if($fer["accept"] == "off")
							{
								$html_saturs = $fer["cache"];;
							}
							else
							{
								$html_saturs = $fer["text"];
							}
							
							echo "<textarea name=\"content\" style=\"width:100%;\" rows=\"30\">$html_saturs</textarea>";
							
							?>
							</td>
						</tr>
						
					</table>
               </form>
					<?php
					}
?>
				</td>
			</tr>
		</table>
	</body>
</html>


<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");
$error="";
if(isset($_POST["submit"]))
{
	$change_from=array("\"","\'","'","\\");
	$change_to=array("&quot;","","","");
		
	$sablons=str_replace($change_from,$change_to,$_POST["sablons"]);
	$sablons=trim($sablons);
	if(empty($sablons))
	{
		$error=$error. "<tr><td colspan=\"2\" class=\"sarkanst\">$sabloni[6]</tr></td>";
	}

	$rep=mysqli_query($result_db,"Select * from anketas where name = '$sablons'");
	$cik = mysqli_num_rows($rep);
	if($cik>0)
	{
		$error=$error. "<tr><td colspan=\"2\" class=\"sarkanst\">$sabloni[4]</tr></td>";
	}
	
	$ren=mysqli_query($result_db,"Select * from anketas where value='1' order by place desc Limit 0, 1");
	$row=mysqli_fetch_array($ren);
	$place=$row["place"];
	if(empty($place))
	{
		$place=1;
	}
	else
	{
		$place++;
	}
	
	$type=str_replace($change_from,$change_to,$_POST["type"]);
	$type=trim($type);

	$email=str_replace("\n","<br>",$_POST["email"]);
	$sent_teksts=stripslashes ($_POST["content"]);
	$sent_teksts=str_replace("'","`",$sent_teksts);
	$sent_teksts = preg_replace('#<\?xml[^(/>)]*/>#m','',$sent_teksts);
	
	$before_teksts=stripslashes ($_POST["before_teksts"]);
	$before_teksts=str_replace("'","`",$before_teksts);
	$before_teksts = preg_replace('#<\?xml[^(/>)]*/>#m','',$before_teksts);
	
	if($error == "")
	{
		$result = mysqli_query($result_db,"insert into anketas values (
		null,
		'0',
		'$place',
		'1',
		'$ver',
		'$sablons',
		'$email',
		'$sent_teksts',
		'',
		'',
		'',
		'',
		'',
		'',
		'',
		'$before_teksts',
		'$type'
		)"); 
		
		$links = "index.php";
		header("Location: $links");
		exit;
	}
}
else
{
	$sablons = "";
	$email="";
	$sent_teksts="";
	$before_teksts = "";
	$te="";
	$type = 1;
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
        
		<script type="text/javascript" src="../tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
		<script type="text/javascript" src="../tinymce/jscripts/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>
		<script type="text/javascript">
		tinyMCE.init({
		        // General options
		        mode : "exact",
		theme : "advanced",
		elements : "content, before_teksts",
		        file_browser_callback : "tinyBrowser",
		        content_css : '../editor_style.css',   
   				relative_urls : false, 
        		remove_script_host : false,
		        theme_advanced_blockformats : 'partners-border',
				theme_advanced_styles : "<?php echo $teksti[153]; ?>=partners-border",
				entity_encoding : "raw",
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
		        content_css : "../editor_style.css",
		
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
				
					<table cellpadding="3" cellspacing="0" border="0" style="border: 1px solid #d0d2dd" width="100%">
	  				<tr>
	   					<td bgcolor="#f2f3f7" colspan="3" class="standart"><b><?php echo $sabloni[3]; ?></b></td>
	  				</tr>
						<?php echo $error; ?>
						<form action="pievienot.php<?php echo $li1; ?>" method="post" name="pievienot">
	  				<tr>
	   					<td class="standart" width="200"><?php echo $sabloni[22]; ?></td>
	   					<td><input type="text" name="sablons" class="input" style="width: 300px" value="<?php echo $sablons; ?>"></td>
		  			</tr>
	 					<tr>
	   					<td valign="top" class="standart" width="200"><?php echo $sabloni[45]; ?></td>
	   					<td valign="top"><textarea name="email" class="input" style="width: 300px" rows="6"><?php echo $email; ?></textarea></td>
						</tr>
						<tr>
							<td valign="middle" align="left" class="standart" width="200"><?php echo $sabloni[86]; ?></td>
							<td valign="middle" class="standart">
								<input type="radio" name="type" value="1" <?php if($type == 1) { echo "checked";} ?>> <?php echo $sabloni[84]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
								<input type="radio" name="type" value="2" <?php if($type == 2) { echo "checked";} ?>> <?php echo $sabloni[85]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
							</td>
						</tr>
	  					<tr>
							<td valign="top" colspan="2" class="standart"><?php echo $sabloni[82]; ?></td>
						</tr>
						<tr>
							<td colspan="2">
							<?php
								echo "<textarea name=\"before_teksts\" style=\"width:100%;\" rows=\"10\">$sent_teksts</textarea>";
								?>
							</td>
						</tr>
						<tr>
							<td valign="top" colspan="2" class="standart"><?php echo $sabloni[71]; ?></td>
						</tr>
						<tr>
							<td colspan="2">
							<?php
								echo "<textarea name=\"content\" style=\"width:100%;\" rows=\"10\">$sent_teksts</textarea>";
								?>
							</td>
						</tr>
	   				
	 				  <tr>
	  			  	<td colspan="2"><input type="Submit" value="<?php echo $sabloni[73]; ?>" class="button" name="submit"></td>
	  				</tr>
					</form>
     			</table>
					
				</td>
			</tr>
		</table>
	</body>
</html>


<?php
//iel�d�jam funkcijas
require_once("config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");
	
?>

<html>
	<head>
		<title><?php echo $head[0]; ?></title>
		<meta http-equiv="Content-Type" content="text/html; <?php echo $head[1]; ?>">
		<link rel="stylesheet" href="<?php echo $wolf_path; ?>style.css" type="text/css">
		<style>
			.thumb {
				float: left;
				margin: 0 5px 5px 0;
				border: 1px solid #d0d2dd;
				padding: 5px;
				text-align: center;
			}
		</style>
		<script language="JavaScript">
			function go( url){
			window.location.href = url;
			}
			
						
			var xmlhttp

			function ChangeComment(item_id, button_id, comment_lv, comment_ru, comment_en)
			{	
				xmlhttp=GetXmlHttpObject();
				if (xmlhttp==null)
				{
					alert ("Your browser does not support AJAX!");
					return;
				}
				
				document.getElementById(button_id).disabled=true;
				document.getElementById(button_id).value="Uzgaidiet...";
							
				var url= "comment.php";
				url=url+"?k="+item_id;
				url=url+"&r="+Math.random();
							
				var params = "comment_lv=" + document.getElementById(comment_lv).value + "&comment_ru=" + document.getElementById(comment_ru).value + "&comment_en=" + document.getElementById(comment_en).value;				
				xmlhttp.onreadystatechange=stateChanged;
				xmlhttp.open("POST",url,true);
				xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xmlhttp.send(params);
	
			
				function stateChanged()
				{
					if (xmlhttp.readyState==4)
					{
						document.getElementById(button_id).disabled=false;
						document.getElementById(button_id).value="<?php echo $foto[56]; ?>";
						
					}
				}
			
			}
			
			function GetXmlHttpObject()
			{
				if (window.XMLHttpRequest)
				{
					// code for IE7+, Firefox, Chrome, Opera, Safari
					return new XMLHttpRequest();
				}
				if (window.ActiveXObject)
				{
					// code for IE6, IE5
					return new ActiveXObject("Microsoft.XMLHTTP");
				}
				return null;
			}

		</script>
		<SCRIPT LANGUAGE="JavaScript">
function NewWindow(mypage, myname, scroll) {
var iw, ih, gal; // Set inner width and height


iw = screen.width;
ih = screen.height;



if(iw < 800 ){ w = 540; h = 405; gal = '640x'}
if(iw >= 800 && iw <1024 ){ w = 700; h = 525; gal = '800x'}
if(iw >= 1024 && iw <1280 ){ w = 924; h = 693; gal = '1024x'}
if(iw >= 1280 ){ w = 1180; h = 885; gal = '1280x'}

var winl = (screen.width - w) / 2;
var wint = (screen.height - h) / 2;

winprops = 'height='+h+',width='+w+',top='+5+',left='+winl+',scrollbars='+scroll+',resizable'
href= mypage + '&gal='+gal;
win = window.open(href, myname, winprops)
if (parseInt(navigator.appVersion) >= 4) { win.window.focus(); }

}
</script>
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<script type="text/javascript" src="js/swfupload/swfupload.js"></script>
<script type="text/javascript" src="js/jquery.swfupload.js"></script>
<script type="text/javascript">

$(function(){

	var redirect = 0;
	var total = 0;
	var current = 0;
	$('#swfupload-control').swfupload({
		upload_url: "upload-file.php?<?php echo "name=$name"; ?>",
		file_post_name: 'uploadfile',
		file_size_limit : "1048576",
		file_types : "*.jpg;*.png;*.gif;*.JPG",
		file_types_description : "Image files",
		file_upload_limit : 1000,
		flash_url : "js/swfupload/swfupload.swf",
		button_image_url : 'js/swfupload/wdp_buttons_upload_114x29.png',
		button_width : 114,
		button_height : 29,
		button_placeholder : $('#button')[0],
		debug: false
	})
		.bind('fileQueued', function(event, file){
			
			var listitem='<li id="'+file.id+'" >'+
				'File: <em>'+file.name+'</em> ('+Math.round(file.size/1024)+' KB) <span class="progressvalue" ></span>'+
				'<div class="progressbar" ><div class="progress" ></div></div>'+
				'<p class="status" >Pending</p>'+
				'<span class="cancel" >&nbsp;</span>'+
				'</li>';
			$('#log').append(listitem);
			$('li#'+file.id+' .cancel').bind('click', function(){
				var swfu = $.swfupload.getInstance('#swfupload-control');
				swfu.cancelUpload(file.id);
				$('li#'+file.id).slideUp('fast');
			});
			// start the upload since it's queued
			$(this).swfupload('startUpload');
		})
		.bind('fileQueueError', function(event, file, errorCode, message){
			alert('Size of the file '+file.name+' is greater than limit');
		})
		.bind('fileDialogComplete', function(event, numFilesSelected, numFilesQueued){
			$('#queuestatus').text('Files Selected: '+numFilesSelected+' / Queued Files: '+numFilesQueued);
			
			var rr = numFilesQueued - 1;
			total = "SWFUpload_0_" + rr;
		})
		.bind('uploadStart', function(event, file){
			$('#log li#'+file.id).find('p.status').text('Uploading...');
			$('#log li#'+file.id).find('span.progressvalue').text('0%');
			$('#log li#'+file.id).find('span.cancel').hide();
		})
		.bind('uploadProgress', function(event, file, bytesLoaded){
			//Show Progress
			var percentage=Math.round((bytesLoaded/file.size)*100);
			$('#log li#'+file.id).find('div.progress').css('width', percentage+'%');
			$('#log li#'+file.id).find('span.progressvalue').text(percentage+'%');
		})
		.bind('uploadSuccess', function(event, file, serverData){
			var item=$('#log li#'+file.id);
			item.find('div.progress').css('width', '100%');
			item.find('span.progressvalue').text('100%');
			var pathtofile='';
			item.addClass('success').find('p.status').html('Done!!!'+pathtofile);
			
			if(file.id == total)
			{
				redirect = 1;
			}
			
		})
		.bind('uploadComplete', function(event, file){
			// upload has completed, try the next one in the queue
			$(this).swfupload('startUpload');
			
			
			if(redirect == 1)
			{
				window.location.href = 'p_atteli.php<?php echo $li."&name=$name"; ?>';
			}
		})
	
});	

</script>
<style type="text/css" >
#swfupload-control { margin:10px 0px 0px 5px; }
#swfupload-control p{ margin:10px 5px; font-size:0.9em; }
#log{ margin:0; padding:0; width:500px;}
#log li{ list-style-position:inside; margin:2px; border:1px solid #ccc; padding:10px; font-size:12px; 
	font-family:Arial, Helvetica, sans-serif; color:#333; background:#fff; position:relative;}
#log li .progressbar{ border:1px solid #333; height:5px; background:#fff; }
#log li .progress{ background:#999; width:0%; height:5px; }
#log li p{ margin:0; line-height:18px; }
#log li.success{ border:1px solid #000000; background:#d0d2dd; }
#log li span.cancel{ position:absolute; top:5px; right:5px; width:20px; height:20px; 
	background:url('js/swfupload/cancel.png') no-repeat; cursor:pointer; }
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
				<td colspan="2" height="20" bgcolor="d0d2dd">
				<?php require_once("izveleta.php"); ?>
				</td>
			</tr>
			<tr>
				<td width="250" valign="top" bgcolor="#f2f3f7">
				<?php require_once("page_menu.php"); ?>
				</td>
				<td bgcolor="#ffffff" width="100%" valign="top" class="text">
				<?php
					$ren=mysqli_query($result_db,"Select * from items where id='$name'");
					$row=mysqli_fetch_array($ren);
					mysqli_free_result($ren);
				?>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                  <tr>
                     <td valign="top" class="sad"><a href="index.php<?php echo $li1; ?>" class="sad_link"><?php echo $item[0]; ?></a> <img src="<?php echo $wolf_path; ?>img/next.gif" align="absmiddle"> <a href="p_atteli.php<?php echo $li."&name=$name"; ?>" class="sad_link"><?php echo $item[63]; ?></a></td>
                  </tr>
                  <tr>
                     <td height="10" ></td>
                  </tr>
               </table>
                <table cellpadding="3" cellspacing="1" border="0" width="100%" style="border: 1px solid #d0d2dd">
	  <tr>
	   <td bgcolor="#f2f3f7" class="standart"><b><?php echo "$item[48] \"$row[name_lv]\""; ?></b></td>
	  </tr>
     
    
               
	  <tr>
	   <td ><div id="swfupload-control">
                  <input type="button" id="button" />
                  <p id="queuestatus" ></p>
                  <ol id="log"></ol>
               </div></td>
	  </tr>
     </table>
                <table><tr><td></td></tr></table>
		
               
               <table cellpadding="3" cellspacing="2" width="100%" style="border: 1px solid #d0d2dd">
	 					<tr>
	  						<td class="standart" bgcolor="#f2f3f7" colspan="8"><b><?php echo $foto[58]; ?></b></td>
	  					</tr>
	  					
	  				<?php
	  				$rep=mysqli_query($result_db,"Select * from images where parent_id = '$name' order by place asc");
	  				$count = mysqli_num_rows($rep);
	  				if($count > 0)
	  				{
	  					echo '<tr>						
							<td class="st1" valign="top" align="left">';
	  					$a=1;
	 					while($rop=mysqli_fetch_array($rep))
						{
	 					
	  						echo "
							<div class=\"thumb\">
								<form method=\"post\" action=\"abidit.php$li&name=$name&k=$rop[id]\" name=\"a$a\" style=\"margin:0px;\">
								<p><a href=\"../../pictures/items/pic-big/$rop[file].jpg\" class=\"standart_link\" target=\"_blank\"><img src=\"../../pictures/items/pic-small/$rop[file].jpg\" align=\"absmiddle\" border=\"0\"></a>	</p>									
								<p><input type=\"text\" name=\"vieta\" style=\"width: 30px\" value=\"$rop[place]\" class=\"input2\">&nbsp;<INPUT TYPE=\"submit\" VALUE=\"$item[56]\" class=\"button2\">&nbsp; <INPUT TYPE=Button VALUE=\"$teksti[23]\" class=button2 onclick='go(\"a_dzest_ok.php$li&name=$name&k=$rop[id]\")'></p>
								</form> 
							</div>";
							$a++;
						}
						
						echo '</td></tr>';
					}
					else
					{
						echo "<tr><td class=\"st1\">$foto[59]</td></tr>";
					}
	  				mysqli_free_result($rep);
	  				?>
						
	 				</table>
					
				</td>
			</tr>
		</table>
	</body>
</html>




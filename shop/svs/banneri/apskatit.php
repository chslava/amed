<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");
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
						$ren=mysqli_query($result_db,"Select * from banners where id='$k'");
						$rop=mysqli_fetch_array($ren);
						mysqli_free_result($ren);
					?>
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
						<tr>
							
                     <td valign="top" class="sad"><a href="index.php<?php echo $li1; ?>" class="sad_link"><?php echo $banneri[77]; ?></a></td>
                  </tr>
               </table>
								
							
					<table><tr><td></td></tr></table>
					<table width="100%" cellpadding="0" cellspacing="0" border="0" style="border: 1px solid #d0d2dd">
      			<tr>
       				<td class="text">
							 <table width="100%" cellpadding="0" cellspacing="0" border="0">
                      	<tr>
                        	<td>
									<?php 
                            if($rop["novietojums"] == 1){$ww = "1000"; $hh = "150";} else{$ww = "1000"; $hh = "130";}
                        	 if($rop["formats"]=="2")
                            {
                               echo "<OBJECT classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\"
                   codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0\"
                   ID=\"$rop[id]\" WIDTH=\"$ww\" HEIGHT=\"$hh\" ALIGN=\"\">
                   <PARAM NAME=movie VALUE=\"".$wolf_path."../banners/$rop[datne]\"> <PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE=#> <EMBED src=\"".$wolf_path."../banners/$rop[datne]\" quality=high bgcolor=#  WIDTH=\"$ww\" HEIGHT=\"$hh\" swLiveConnect=true ID=\"$rop[id]\" NAME=\"$rop[id]\" ALIGN=\"\"
                   TYPE=\"application/x-shockwave-flash\" PLUGINSPAGE=\"http://www.macromedia.com/go/getflashplayer\"></EMBED>
                  </OBJECT>";
                            }
                            else
									 {
									 	echo "<img src=\"".$wolf_path."../banners/$rop[datne]\" width=\"$ww\" height=\"$hh\">";
                            }
                        ?>
                        </td>
                        </tr>
                       </table>
                       
							</td>
      			</tr>
    			</table>
            <table>
            	<tr>
               	<td></td>
               </tr>
            </table>
					<INPUT TYPE=Button VALUE="<?php echo $lapas[14];?>" class=button onclick='go("<?php echo $wolf_path; ?>banneri/index.php<?php echo $li; ?>")'>&nbsp;
				</td>
			</tr>
		</table>
	</body>
</html>


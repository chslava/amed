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
				
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                  <tr>
                     <td height="30" valign="top" class="sad"><a href="index.php<?php echo $li; ?>" class="sad_link"><?php echo $banneri[77]; ?></a></td>
                  </tr>
               </table>
               
					<table cellpadding="0" cellspacing="0" border="0" width="550">
	  	    	<tr>
		 				  <td valign="middle" height="22" width="140"><INPUT TYPE="Button" VALUE="<?php echo "$jaunumi[21]"; ?>" class="button" onclick='go("<?php echo $wolf_path; ?>banneri/pievienot.php<?php echo $li1; ?>")'></td>
	   				</tr>
						<tr>
		 				  <td>&nbsp;</td>
	   				</tr>
			    </table>
	 				<table cellpadding="3" cellspacing="2" width="100%" style="border: 1px solid #d0d2dd">
					 
	 					<tr>
	  					<td class="standart" bgcolor="#f2f3f7" colspan="7"><b><?php echo $banneri[39]; ?></b></td>
	  				</tr><tr>
	   <td class="standart"><?php echo "$banneri[48]"; ?></td>
	  </tr>
	  				<?php
	  				$ok=$limit;
					$rep=mysqli_query($result_db,"Select * from banners order by place desc");
	  				$a=1;
	 				while($rop=mysqli_fetch_array($rep))
					{
						$lang_1 = "";
						$lang_2 = "";
						$lang_3 = "";
						$langs = explode("**",$rop["lang"]);
						
						for($c=0;$c<count($langs);$c++)
						{
							$val = trim(str_replace("*","",$langs[$c]));
							if($val == "lv")
							{
								$lang_1 = "&nbsp;".$banneri[74];
							}
							if($val == "ru")
							{
								$lang_2 = "&nbsp;".$banneri[75];
							}
							if($val == "en")
							{
								$lang_3 = "&nbsp;".$banneri[76];
							}
						}	

	 					if($rop["novietojums"] == 1)
						{
							$novietojums = $banneri[68];
						}	
						if($rop["novietojums"] == 2)
						{
							$novietojums = $banneri[69];
						}	
						if($rop["novietojums"] == 3)
						{
							$novietojums = $banneri[70];
						}	
						if($rop["novietojums"] == 4)
						{
							$novietojums = $banneri[72];
						}	
						if($rop["novietojums"] == 5)
						{
							$novietojums = $banneri[83];
						}
						if($rop["novietojums"] == 6)
						{
							$novietojums = $banneri[85];
						}	
						
	  					
	  					$limit++;
	  					
	  					if($rop["novietojums"] == 1){$ww = "300"; $hh = "45";} else{$ww = "300"; $hh = "39";}
                       if($rop["formats"]=="2")
                            {
                               $pic = "<OBJECT classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\"
                   codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0\"
                   ID=\"$rop[id]\" WIDTH=\"$ww\" HEIGHT=\"$hh\" ALIGN=\"\">
                   <PARAM NAME=movie VALUE=\"".$wolf_path."../banners/$rop[datne]\"> <PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE=#> <EMBED src=\"".$wolf_path."../banners/$rop[datne]\" quality=high bgcolor=#  WIDTH=\"$ww\" HEIGHT=\"$hh\" swLiveConnect=true ID=\"$rop[id]\" NAME=\"$rop[id]\" ALIGN=\"\"
                   TYPE=\"application/x-shockwave-flash\" PLUGINSPAGE=\"http://www.macromedia.com/go/getflashplayer\"></EMBED>
                  </OBJECT>";
                            }
                            else
									 {
									 	$pic = "<img src=\"".$wolf_path."../banners/$rop[datne]\" width=\"$ww\" height=\"$hh\">";
                            }
                            
	  					echo "
						<tr>
							<td class=st1 valign=top width=\"100%\"><a href=\"apskatit.php$li1&k=$rop[id]\" class=\"standart_link\"><b>$novietojums</b></a></td>
							<td class=st1 valign=top class=\"standart\">$pic</td>
							<td class=st1 valign=top class=\"standart\">$lang_1$lang_2$lang_3</td>	
														
							<td class=st1 valign=top><INPUT TYPE=Button VALUE=\"$jaunumi[28]\" class=button1 onclick='go(\"".$wolf_path."banneri/mainit.php$li1&name=$rop[id]\")'></td>
							<td class=st1 valign=top><INPUT TYPE=Button VALUE=\"$jaunumi[29]\" class=button1 onclick='go(\"".$wolf_path."banneri/dzest.php$li1&name=$rop[id]\")'></td>
							<td class=st1 valign=top align=center><a href=\"".$wolf_path."banneri/up.php$li1&k=$rop[id]&iz=$rop[place]\"><img src=\"".$wolf_path."img/up.gif\" vspace=1 border=0></a></td>
							<td class=st1 valign=top><a href=\"".$wolf_path."banneri/down.php$li1&k=$rop[id]&iz=$rop[place]\"><img src=\"".$wolf_path."img/down.gif\" vspace=1 border=0></a></td></tr>";
							$a++;
					}
	  				mysqli_free_result($rep);
	 				if($a==1)
					{
	  					echo "<tr><td class=\"st1\">$banneri[40]</td></tr>";
	  				}
	   			?>
						
	 				</table>
					
				</td>
			</tr>
		</table>
	</body>
</html>


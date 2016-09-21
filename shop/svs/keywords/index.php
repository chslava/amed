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
				<td colspan="2" height="20" bgcolor="d0d2dd">&nbsp;</td>
			</tr>
			<tr>
				<td bgcolor="#ffffff" width="100%" valign="top" class="text">
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
                  <tr>
                     <td height="30" valign="top" class="sad"><a href="index.php<?php echo $li1; ?>" class="sad_link"><?php echo $menu_it[41]; ?></a></td>
                  </tr>
               </table>
					<table cellpadding="0" cellspacing="0" border="0" width="550">
	  	    			<tr>
		 				  <td class="text1"><INPUT TYPE="Button" VALUE="<?php echo "$jaunumi[21]"; ?>" class="button" onclick='go("pievienot.php<?php echo $li1; ?>")'></td>
	   				</tr>
						<tr>
		 				  <td class="text1">&nbsp;</td>
	   				</tr>
			    	</table>
	 				<table cellpadding="3" cellspacing="2" width="100%" style="border: 1px solid #d0d2dd">
	 					<tr>
	  					<td class="standart" bgcolor="#f2f3f7" colspan="8"><b><?php echo $text[7]; ?></b></td>
	  				</tr>
	  				<?php
					$rep=mysqli_query($result_db,"Select * from keywords order by id asc");
	  				while($rop=mysqli_fetch_array($rep))
					{		
						
	  					echo "
							<tr>
								<td class=\"st1\" valign=top width=\"15\">$rop[id]</td>
								<td class=st1 valign=top width=\"100%\">$rop[name]</td>								
								<td class=st1 valign=top><INPUT TYPE=Button VALUE=\"$jaunumi[28]\" class=button1 onclick='go(\"mainit.php$li1&name=$rop[id]\")'></td>
								<td class=st1 valign=top><INPUT TYPE=Button VALUE=\"$jaunumi[34]\" class=button1 onclick='go(\"dzest.php$li1&k=$rop[id]\")'></td>
							</tr>";
						
					}
	  				mysqli_free_result($rep);
	 					
	  				?>
	 				</table>
					
				</td>
			</tr>
		</table>
	</body>
</html>


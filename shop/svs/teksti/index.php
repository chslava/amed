<?php
//ielādējam funkcijas
require_once("../config.php");
//pārbaudam, vai lietotājs ir reģistrējies
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
                     <td height="30" valign="top" class="sad"><a href="index.php<?php echo $li1; ?>" class="sad_link"><?php echo $text[3]; ?></a></td>
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
	  				$text_lang = "text_".$ver;
					$rep=mysql_query("Select * from texts order by id asc");
	  				while($rop=mysql_fetch_array($rep))
					{
	 					
						$apraksts = str_replace("\n","<br />",$rop["description"]);
	  					echo "
							<tr>
								<td class=\"st1\" valign=top width=\"15\">$rop[id]</td>
								<td class=st1 valign=top>$rop[$text_lang]</td>
								<td class=st1 valign=top>$apraksts</td>
								<td class=st1 valign=top width=\"130\">$rop[category]</td>
								
								<td class=st1 valign=top width=\"40\"><INPUT TYPE=Button VALUE=\"$jaunumi[28]\" class=button1 onclick='go(\"mainit.php$li1&name=$rop[id]\")'></td>
							</tr>";
						$a++;
					}
	  				mysql_free_result($rep);
	 					
	  				?>
	 				</table>
					
				</td>
			</tr>
		</table>
	</body>
</html>


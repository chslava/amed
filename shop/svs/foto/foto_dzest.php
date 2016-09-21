<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
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
                     <td valign="top" class="sad"><a href="index.php<?php echo $li1; ?>" class="sad_link"><?php echo $menu_it[13]; ?></a> <img src="<?php echo $wolf_path; ?>img/next.gif" align="absmiddle"> <a href="foto_dzest.php<?php echo $li1."&name=$name&k=$k"; ?>" class="sad_link"><?php echo $foto[57]; ?></a></td>
                  </tr>
                  <tr>
                     <td height="10" ></td>
                  </tr>
               </table>
               
						<?php 
$ren=mysql_query("Select * from albums where id='$name'");
					$row=mysql_fetch_array($ren);
					mysql_free_result($ren);
					
$rep=mysql_query("Select * from pictures where id='$k' group by id desc");
$rop=mysql_fetch_array($rep);
mysql_free_result($rep);
	?>
					<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd">
						<tr>
							<td class="text">
								<table cellpadding="3" cellspacing="0" border="0" width="100%">
	  							<tr>
	 									<td class="standart"><b><?php echo $foto[21]; ?></b></td>
	 								</tr>
									<form action="foto_dzest_ok.php<?php echo "$li1&name=$name&k=$k"; ?>" method="post" name="pievienot">
	  							<tr>
	 									<td class="standart"><?php echo "$foto[22] <b>";?></td>
	 								</tr>
	 								<tr>
	 								  <td><INPUT TYPE=Button VALUE="<?php echo $jaunumi[36];?>" class=button onclick='go("foto_p.php<?php echo $li1."&name=$name"; ?>")'>&nbsp;<INPUT TYPE="Submit" VALUE="<?php echo $sabloni[8]; ?>" class="button" name="submit"></td>
									</tr>
									</form>
    						</table>
							</td>
						</tr>
						<tr>
							<td align="center"><?php echo "<img src=\"".$wolf_path."../pictures/albums/big/$rop[file_name].jpg\" vspace=\"5\" hspace=\"5\">"; ?></td>
						</tr>
					</table>
					
					
				</td>
			</tr>
		</table>
	</body>
</html>


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
					$rez=mysqli_query($result_db,"Select * from albums where id='$name'");
					$roz=mysqli_fetch_array($rez);
					mysqli_free_result($rez);
					?>
   				<table cellpadding="0" cellspacing="0" border="0" width="100%">
                  <tr>
                     <td valign="top" class="sad"><a href="index.php<?php echo $li1; ?>" class="sad_link"><?php echo $menu_it[13]; ?></a> <img src="<?php echo $wolf_path; ?>img/next.gif" align="absmiddle"> <a href="dzest.php<?php echo $li1."&name=$name"; ?>" class="sad_link"><?php echo $foto[12]; ?></a></td>
                  </tr>
                  <tr>
                     <td height="10" ></td>
                  </tr>
               </table>
					<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd">
						<tr>
							<td class="text">
								<table cellpadding="3" cellspacing="0" border="0" width="100%">
	  							<tr>
	 									<td class="standart"><b><?php echo $foto[12]; ?></b></td>
	 								</tr>
									<form action="dzest_ok.php<?php echo "$li1&name=$name"; ?>" method="post" name="pievienot">
	  							<tr>
	 									<td class="standart"><?php echo "$foto[14] <b>\"$roz[name_lv]\"</b> $foto[15]";?></td>
	 								</tr>
	 								<tr>
	 								  <td><INPUT TYPE=Button VALUE="<?php echo $foto[41];?>" class=button onclick='go("index.php<?php echo $li1; ?>")'>&nbsp;<INPUT TYPE="Submit" VALUE="<?php echo $foto[40]; ?>" class="button" name="submit"></td>
									</tr>
									</form>
    						</table>
							</td>
						</tr>
					</table>
					
					
				</td>
			</tr>
		</table>
	</body>
</html>


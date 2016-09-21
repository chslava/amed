<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");
require_once("user_auth.php");
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
					<table cellpadding="0" cellspacing="0" border="0" width="550">
						<tr>
		 				  <td height="30" valign="top" class="sad"><a href="index.php<?php echo $li1."&limit=$limit"; ?>" class="sad_link"><?php echo $ziedi[0]; ?></a></td>
	   				</tr>
					</table>
					<?php 
						$ren=mysql_query("Select * from flowers where id='$k'");
						$rop=mysql_fetch_array($ren);
						mysql_free_result($ren);
					?>
					<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd">
						<tr>
							<td class="text">
								<table cellpadding="0" cellspacing="0" border="0" width="100%">
	  							<tr>
	   								<td class="standart"><b><?php echo $ziedi[60]; ?></b></td>
	  							</tr>
									<form action="dzest_ok.php<?php echo "$li1&k=$k&limit=$limit"; ?>" method="post" name="pievienot">
	  							<tr>
	   								<td height="25" class="standart"><?php echo $ziedi[61];?></td>
	 								</tr>
	 								<tr>
	   								<td height="25"><INPUT TYPE=Button VALUE="<?php echo $ziedi[21];?>" class=button onclick='go("index.php<?php echo $li1."&limit=$limit"; ?>")'>&nbsp;<input type="Submit" value="<?php echo $jaunumi[34]; ?>" class="button"></td>
									</form>
									</tr>
     						</table>
							</td>
						</tr>
					</table>
					<table><tr><td></td></tr></table>
					<table width="100%" cellpadding="0" cellspacing="0" border="0" style="border: 1px solid #d0d2dd">
      			<tr>
       				<td class="text">
							<?php
							echo "<img src=\"../../flowers/flowers_small/$rop[picture]\"><div class=\"standart\"><b>$rop[name_en]</b></div><div class=\"standart\">$rop[text_en]</div>";
	  					?>
							</td>
      			</tr>
    			</table>
					
				</td>
			</tr>
		</table>
	</body>
</html>


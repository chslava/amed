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
				<?php require_once("izveleta.php"); ?>
				</td>
			</tr>
			<tr>
				<td width="250" valign="top" bgcolor="#f2f3f7">
				<?php require_once("page_menu.php"); ?>
				</td>
				<td bgcolor="#ffffff" width="100%" valign="top" class="text">
					<table cellpadding="0" cellspacing="0" border="0">
						<tr>
		 				  <td height="30" valign="top" class="sad"><a href="index.php<?php echo $li1; ?>" class="sad_link"><?php echo $pr[0]; ?></a> <img src="<?php echo $wolf_path; ?>img/next.gif" align="absmiddle"><a href="speciality.php<?php echo $li1; ?>" class="sad_link"><?php echo $pr[85]; ?></a> <img src="<?php echo $wolf_path; ?>img/next.gif" align="absmiddle"><a href="speciality_dzest.php<?php echo $li1; ?>" class="sad_link"><?php echo $pr[91]; ?></a></td>
	   				</tr>
					</table>
					<?php 
					$nos = "specialities";
					$ren=mysqli_query($result_db,"Select * from $nos where id='$k'");
					$rop=mysqli_fetch_array($ren);
					mysqli_free_result($ren);
					?>
					<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd">
					
						<tr>
							<td class="text">
								<table cellpadding="0" cellspacing="0" border="0" width="100%">
	  							<tr>
	   								<td class="standart"><b><?php echo $pr[91].": <u>".$rop["name_lv"]."</u>"; ?></b></td>
	  							</tr>
									<form action="speciality_dzest_ok.php<?php echo "$li1&k=$k"; ?>" method="post" name="pievienot">
	  							<tr>
	   								<td height="25" class="standart"><?php echo $pr[92];?></td>
	 								</tr>
	 								<tr>
	   								<td height="25"><INPUT TYPE=Button VALUE="<?php echo $pr[42];?>" class=button onclick='go("speciality.php<?php echo $li1; ?>")'>&nbsp;<input type="Submit" value="<?php echo $pr[43]; ?>" class="button"></td>
									</form>
									</tr>
     						</table>
							</td>
						</tr>
					</table>
					
					
				</td>
			</tr>
		</table>
	</body>
</html>


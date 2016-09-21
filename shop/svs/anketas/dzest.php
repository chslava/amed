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
						<?php 

$rez=mysql_query("Select * from anketas where id='$name'");
$roz=mysql_fetch_array($rez);
mysql_free_result($rez);
	?>
					<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd">
						<tr>
							<td class="text">
								<table cellpadding="3" cellspacing="0" border="0" width="100%">
	  							<tr>
	 									<td class="standart"><b><?php echo $sabloni[13]; ?></b></td>
	 								</tr>
									<form action="dzest_ok.php<?php echo "$li1&name=$name"; ?>" method="post" name="pievienot">
	  							<tr>
	 									<td class="standart"><?php echo "$sabloni[11] <b>\"$roz[name]\"</b> $sabloni[12]";?></td>
	 								</tr>
	 								<tr>
	 								  <td><INPUT TYPE=Button VALUE="<?php echo $sabloni[77];?>" class=button onclick='go("index.php<?php echo $li1; ?>")'>&nbsp;<INPUT TYPE="Submit" VALUE="<?php echo $sabloni[8]; ?>" class="button" name="submit"></td>
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


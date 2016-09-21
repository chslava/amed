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
$ren=mysql_query("Select * from albums where id='$name'");
					$row=mysql_fetch_array($ren);
					mysql_free_result($ren);
					
$rep=mysql_query("Select * from pictures where id='$k' group by id desc");
$rop=mysql_fetch_array($rep);
mysql_free_result($rep);
	?>
					<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd">
						<tr>
							<td>
								<INPUT TYPE=Button VALUE="<?php echo $foto[33];?>" class=button onclick='go("foto_p.php<?php echo $li1."&name=$name"; ?>")'></td>
									
						</tr>
						<tr>
							<td align="left"><?php echo "<img src=\"".$wolf_path."../pictures/middle/$rop[file_name]\" vspace=\"5\">"; ?></td>
						</tr>
                  <tr>
							<td align="left"><?php echo "$rop[descr]"; ?></td>
						</tr>
					</table>
					
					
				</td>
			</tr>
		</table>
	</body>
</html>


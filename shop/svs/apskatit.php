<?php
//ielâdçjam funkcijas
require_once("config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once("check.php");

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
				
				if($us=="no" && $ar > 0){
				echo $teksti[40];
				}
				else{
				
				?>
					<table cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td>
								<input type="Button" value="<?php echo $teksti[165]; ?>" class="button" onclick='go("<?php echo $wolf_path; ?>member.php<?php echo $li; ?>")'>
								<input type="Button" value="<?php echo $teksti[164]; ?>" class="button" onclick='go("<?php echo $wolf_path; ?>renew.php<?php echo $li."&name=$name"; ?>")'>
							</td>					
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table>
					<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd">
						<tr>
							<td class="text">
							<?php
							$query = mysql_query("select * from content_backup where id = '$name'");
							$mysql = mysql_fetch_array($query);
							mysql_free_result($query);
							echo $mysql["text"];
							
							?></td>
						</tr>
					</table>
					<table>
               			<tr>
							<td style="padding: 20px 0 20px 0;" class="standart"><?php echo "$teksti[150]<br /><a href=\"$root_dir$ver/$izveleta\" class=\"menu2\" target=\"_blank\">$root_dir$ver/$izveleta</a>"; ?></td>
						</tr>
						
               		</table>

					<?php
					}
					?>
				</td>
			</tr>
		</table>
	</body>
</html>


<?php
//iel�d�jam funkcijas
require_once("config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
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
							<td><input type="Button" value="<?php echo $teksti[32]; ?>" class="button" onclick='go("<?php echo $wolf_path; ?>text_change.php<?php echo $li; ?>")'></td>
							
							
					<?php
					if(empty($fer["accept"])){$fer_ok="";}else{$fer_ok=$fer["accept"];}
					if($fer_ok=="off")
					{
					?>
						<td class="izveleta"><input type="Button" value="<?php echo $teksti[37]; ?>" class="button" onclick='go("<?php echo $wolf_path; ?>sadalas/accept1.php<?php echo $li; ?>")'></td>
						<td class="izveleta"><input type="Button" value="<?php echo $teksti[38]; ?>" class="button" onclick='go("<?php echo $wolf_path; ?>sadalas/accept2.php<?php echo $li; ?>")'></td>
					<?php
					}
					?>
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
							if($fer_ok == "off")
							{
								$ren=mysqli_query($result_db,"Select * from $tabula where id='$id'");
								$row=mysqli_fetch_array($ren);
								mysqli_free_result($ren);
								echo $row["cache"];
							}
							else
							{
								echo $teksts;
							}
							?></td>
						</tr>
					</table>
					<table>
               			<tr>
							<td style="padding: 20px 0 20px 0;" class="standart"><?php echo "$teksti[150]<br /><a href=\"$root_dir$ver/$izveleta\" class=\"menu2\" target=\"_blank\">$root_dir$ver/$izveleta</a>"; ?></td>
						</tr>
						<tr>
							<td class="standart">
							<?php 
							echo "<p>$teksti[163]:</p>";
							$a = 1;
							$query = mysqli_query($result_db,"select * from content_backup where parent_id = '$id' order by time desc limit 0,10");
							while($mysql = mysqli_fetch_array($query))
							{
								echo "<p class=\"standart\" style=\"padding: 0px; margin: 0px;\">$a. <a href=\"apskatit.php$li"."&name=$mysql[id]\" class=\"standart_link\">".date("d.m.Y H:i:s",$mysql["time"])."</a></p>";
								$a++;
							} 
							mysqli_free_result($query);
							?></td>
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


<?php
//ielâdçjam funkcijas
require_once("../config.php");
if($ar > 0){header("Location: ".$wolf_path."member.php$li");	exit;}
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

$ren=mysql_query("Select * from user where id='$_GET[name]'");
$row=mysql_fetch_array($ren);
mysql_free_result($ren);
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
				
					<table cellpadding="5" cellspacing="0" border="0">
						<tr>
							<td valign="middle" class="standart"><?php
							$ren=mysql_query("Select * from user where id='$_GET[name]'");
$row=mysql_fetch_array($ren);
mysql_free_result($ren); 
echo $lietotaji[16]."<b>".$row["username"]."</b>";?></td>
						</tr>
						<tr>
							<td valign="middle" class="standart"><?php echo $lietotaji[15]; ?></td>
						</tr>
						<tr>
							<td valign="middle"><INPUT TYPE=Button VALUE="<?php echo $lietotaji[13];?>" class=button onclick='go("<?php echo $wolf_path; ?>users/index.php<?php echo $li1; ?>")'>&nbsp;<input type="Button" value="<?php echo $lietotaji[17]; ?>" class="button" onclick='go("<?php echo $wolf_path; ?>users/dzest_ok.php<?php echo $li."&name=".$_GET["name"]; ?>")'></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>


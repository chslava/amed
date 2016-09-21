<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");
$ren=mysqli_query($result_db,"Select * from discounts where id='$name'");
$row=mysqli_fetch_array($ren);
mysqli_free_result($ren);
	
$name_lang = "name";

$nosaukums = $row[$name_lang];
	

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
				<td colspan="2" height="20" bgcolor="d0d2dd"></td>
			</tr>
			<tr>
				<td bgcolor="#ffffff" width="100%" valign="top" class="text">
				
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
                  <tr>
                     <td height="30" valign="top" class="sad"><a href="p_dzest.php<?php echo $li."&name=$name"; ?>" class="sad_link"><?php echo $menu_it[21]; ?></a></td>
                  </tr>                  
                </table>
					<table cellpadding="5" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd" width="100%">
						<tr>
							<td valign="middle" class="standart"><?php echo $discounts[29]; ?></td>
						</tr>
						<tr>
							<td valign="middle"><INPUT TYPE=Button VALUE="<?php echo $teksti[35];?>" class=button onclick='go("index.php<?php echo $li."&limit=$limit"; ?>")' style="margin:0px;"> <input type="Button" value="<?php echo $teksti[31]; ?>" class="button" onclick='go("dzest_ok.php<?php echo $li."&name=$name"; ?>")'></td>
						</tr>
                  <tr>
							<td valign="middle">
                     	<table cellpadding="3" cellspacing="2">
									<tr>
										<td class="standart"><b><?php echo $nosaukums; ?></b></td>
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


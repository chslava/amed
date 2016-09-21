<?php
//ielâdçjam funkcijas
$wolf_path="";
require_once($wolf_path."config.php");
?>
<html>
	<head>
		<title><?php echo $head[0]; ?></title>
		<meta http-equiv="Content-Type" content="text/html; <?php echo $head[1]; ?>">
		<link rel="stylesheet" href="style.css" type="text/css">
	</head>
	<body leftmargin="0" topmargin="0" background="<?php echo $wolf_path; ?>img/fons.gif" marginheight="0" marginwidth="0">
		
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
			<tr>
				<td>
  				<table cellpadding="5" cellspacing="0" width="400" height="92" align="center" bgcolor="#f2f3f7" style="border: 1px solid #555b79">
					<form method="post" action="login.php">
						<tr>
     					<td colspan="2" align="center"><img src="<?php echo $wolf_path; ?>img/logo1.gif"></td>
						</tr>
   					<tr>
     					<td class="t_11_w" align="right" width="40%"><b><?php echo "$login[0]"; ?>:</b></td>
     					<td width="60%"><input type="text" name="username" style="width: 120px" class="input"></td>
						</tr>
   					<tr>
     					<td class="t_11_w" align="right" width="40%"><b><?php echo "$login[1]"; ?>:</b></td>
     					<td width="60%"><input type="password" name="password" style="width: 120px" class="input"></td>
						</tr>
 						<tr>
     					<td width="40%">&nbsp;</td>
     					<td width="60%"><input type="submit" value="<?php echo "$login[2]"; ?>" class="button" style="width: 120px"></td>
						</tr>
						<tr>
     					<td colspan="2" align="center">&nbsp;</td>
						</tr>
					</form>
   				</table>
				</td>
			</tr>
		</table>
	</body>
</html>

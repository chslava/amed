<?php
//ielâdçjam funkcijas
require_once("../config.php");
if($ar > 0){header("Location: ".$wolf_path."member.php$li");	exit;}
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
				
					<table cellpadding="0" cellspacing="0" border="0" width="550">
	  	    	<tr>
		 				  <td><INPUT TYPE="Button" VALUE="<?php echo "$lietotaji[0]"; ?>" class="button" onclick='go("<?php echo $wolf_path; ?>users/pievienot.php<?php echo $li1; ?>")'></td>
	   				</tr>
						<tr>
		 				  <td>&nbsp;</td>
	   				</tr>
			    </table>
	 				<table cellpadding="3" cellspacing="2" width="100%" style="border: 1px solid #d0d2dd">
	 					<tr>
	  					<td bgcolor="#f2f3f7" colspan="7" class="standart"><b><?php echo $lietotaji[1]; ?></b></td>
	  				</tr>
	  				<?php
					  $rep=mysql_query("Select * from user where value='no' order by username");
	  				$a=1;
	 					while($rop=mysql_fetch_array($rep))
						{
	 						echo "<tr>
									<td class=st1 valign=top width=100%><a href=\"".$wolf_path."users/apskatit.php$li1&name=$rop[id]\" class=\"standart_link_11\"><b>$rop[username]</b></a></td>
							<td class=st1 valign=top><INPUT TYPE=Button VALUE=\"$lietotaji[23]\" class=button1 onclick='go(\"".$wolf_path."users/mainit.php$li1&name=$rop[id]\")'></td>
							<td class=st1 valign=top><INPUT TYPE=Button VALUE=\"$lietotaji[24]\" class=button1 onclick='go(\"".$wolf_path."users/dzest.php$li1&name=$rop[id]\")'></td>
							</tr>";
							$a++;
						}
	  				mysql_free_result($rep);
	 					if($a==1)
						{
	  					echo "<tr><td class=\"st1\">$lietotaji[2]</td></tr>";
	  				}
	   				?>
						
	 				</table>
					
				</td>
			</tr>
		</table>
	</body>
</html>


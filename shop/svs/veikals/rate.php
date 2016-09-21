<?php
//ielādējam funkcijas
require_once("config.php");
//pārbaudam, vai lietotājs ir reģistrējies
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
				
					<table cellpadding="0" cellspacing="0" border="0" width="550">
					<tr>
		 				  <td height="30" valign="top" class="sad"><a href="index.php<?php echo $li1; ?>" class="sad_link"><?php echo $pr[0]; ?></a> <img src="<?php echo $wolf_path; ?>img/next.gif" align="absmiddle"><a href="rate.php<?php echo $li1; ?>" class="sad_link"><?php echo $pr[120]; ?></a></td>
	   				</tr>
	  	    	<tr>
		 				  <td valign="middle" height="20">
							<INPUT TYPE="Button" VALUE="<?php echo $pr[26]; ?>" class="button" onclick='go("rate_pievienot.php<?php echo $li1; ?>")'></td>
	   				</tr>
						<tr>
		 				  <td class="text1">&nbsp;</td>
	   				</tr>
			    </table>
	 				<table cellpadding="3" cellspacing="2" width="100%" style="border: 1px solid #d0d2dd">
	 					<tr>
	  					<td class="standart" bgcolor="#f2f3f7" colspan="7"><b><?php echo $pr[121]; ?></b></td>
	  				</tr>
	  				<?php
						$nos = "rates";
						$rep=mysqli_query($result_db,"Select * from $nos order by name asc");
	  					$a=1;
	 					while($rop=mysqli_fetch_array($rep))
						{
	 						
	  					echo "<tr>
							<td class=st1 valign=top width=100%><b>$rop[name]</b></td>
							<td class=st1 valign=top><INPUT TYPE=Button VALUE=\"$pr[35]\" class=button1 onclick='go(\"rate_mainit.php$li1&name=$rop[id]\")'></td>
							<td class=st1 valign=top><INPUT TYPE=Button VALUE=\"$pr[36]\" class=button1 onclick='go(\"rate_dzest.php$li1&k=$rop[id]\")'></td>
							</tr>";
							$a++;
						}
	  					mysqli_free_result($rep);
	 					if($a==1)
						{
							echo "<tr><td class=\"st1\">$pr[74]</td></tr>";
						}
	   				?>
						
	 				</table>
					
				</td>
			</tr>
		</table>
	</body>
</html>


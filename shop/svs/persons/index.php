<?php
//ielādējam funkcijas
require_once("../config.php");
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
				<td colspan="2" height="20" bgcolor="d0d2dd">&nbsp;</td>
			</tr>
			<tr>
				<td bgcolor="#ffffff" width="100%" valign="top" class="text">
				
					<table cellpadding="0" cellspacing="0" border="0" width="550">
						<tr>
		 				  	<td height="30" valign="top" class="sad"><a href="index.php<?php echo $li1; ?>" class="sad_link"><?php echo $menu_it[8]; ?></a> </td>
	   					</tr>
	  	    			<tr>
		 				 	<td valign="middle" height="20">
							<INPUT TYPE="Button" VALUE="<?php echo $food[1]; ?>" class="button" onclick='go("pievienot.php<?php echo $li1; ?>")' style="margin:0px;"></td>
	   					</tr>
	   					<tr>
		 					<td height="10"></td>
	   					</tr>
			    	</table>
	 				<table cellpadding="3" cellspacing="2" width="100%" style="border: 1px solid #d0d2dd">
	 					<tr>
	  					<td class="standart" bgcolor="#f2f3f7" colspan="7"><b><?php echo $org[5]; ?></b></td>
	  				</tr>
	  				<?php
						$nos = "persons";
						$rep=mysql_query("Select * from $nos order by name_lv asc ");
	  					$a=1;
	 					while($rop=mysql_fetch_array($rep))
						{
	 						
	  					echo "<tr>
								<td class=st1 valign=top width=100%><div><b>$rop[name_lv]</b></div></td>
								<td class=st1 valign=top><INPUT TYPE=Button VALUE=\"$food[15]\" class=button1 onclick='go(\"mainit.php$li1&k=$rop[id]\")'></td>
								<td class=st1 valign=top><INPUT TYPE=Button VALUE=\"$food[16]\" class=button1 onclick='go(\"dzest.php$li1&k=$rop[id]\")'></td>
							</tr>";
							$a++;
						}
	  					mysql_free_result($rep);
	 					if($a==1)
						{
	  						echo "<tr><td class=\"st1\">$org[2]</td></tr>";
	  					}
	   					?>						
	 				</table>
					
				</td>
			</tr>
		</table>
	</body>
</html>


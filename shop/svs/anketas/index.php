<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
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
		 				  <td class="text1"><INPUT TYPE="Button" VALUE="<?php echo $sabloni[0]; ?>" class="button" onclick='go("pievienot.php<?php echo $li1; ?>")'></td>
	   				</tr>
						<tr>
		 				  <td class="text1">&nbsp;</td>
	   				</tr>
			    </table>
	 				<table cellpadding="3" cellspacing="2" width="100%" style="border: 1px solid #d0d2dd">
	 					<tr>
	  					<td bgcolor="#f2f3f7" colspan="6" class="standart"><b><?php echo $sabloni[1]; ?></b></td>
	  				</tr>
	  				<?php
					  $rep=mysqli_query($result_db,"Select * from anketas where value='1' order by place desc");
	  				$a=1;
	 					while($rop=mysqli_fetch_array($rep))
						{
                               	  					echo "<tr>
							<td class=st1 valign=top width=100%><b><a href=\"lauki.php$li1&name=$rop[id]\" class=\"standart_link\">$rop[name]</a></b></td>
							<td class=st1 valign=top><INPUT TYPE=Button VALUE=\"$sabloni[83]\" class=button1 onclick='go(\"kopet.php$li1&name=$rop[id]\")'></td>
							<td class=st1 valign=top><INPUT TYPE=Button VALUE=\"$sabloni[75]\" class=button1 onclick='go(\"mainit.php$li1&name=$rop[id]\")'></td>
							<td class=st1 valign=top><INPUT TYPE=Button VALUE=\"$sabloni[76]\" class=button1 onclick='go(\"dzest.php$li1&name=$rop[id]\")'></td></tr>
							";
							$a++;
						}
	  				mysqli_free_result($rep);
	 					if($a==1)
						{
	  					echo "<tr><td class=\"st1\">$sabloni[2]</td></tr>";
	  				}
	   				?>
						
	 				</table>
					
				</td>
			</tr>
		</table>
	</body>
</html>


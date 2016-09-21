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
				
					<table cellpadding="0" cellspacing="0" border="0" width="550">
	  	    	<tr>
		 				  <td valign="middle" height="30" width="140"><INPUT TYPE=Button VALUE="<?php echo $banneri[65];?>" class=button onclick='javascript:history.go(-1)'></td>
	   				</tr>
			    </table>
	<?php 
$result_b=mysql_query("select * from banners where id='$name'");
$row_b=mysql_fetch_array($result_b);

	$results_b=mysql_query("select * from banners_$name where id='$_GET[kat]'");
	$ron=mysql_fetch_array($results_b);
	$bsum=$ron["b0"]+$ron["b1"]+$ron["b2"]+$ron["b3"]+$ron["b4"]+$ron["b5"]+$ron["b6"]+$ron["b7"]+$ron["b8"]+$ron["b9"]+$ron["b10"]+$ron["b11"]+$ron["b12"]+$ron["b13"]+$ron["b14"]+$ron["b15"]+$ron["b16"]+$ron["b17"]+$ron["b18"]+$ron["b19"]+$ron["b20"]+$ron["b21"]+$ron["b22"]+$ron["b23"];
	$asum=$ron["a0"]+$ron["a1"]+$ron["a2"]+$ron["a3"]+$ron["a4"]+$ron["a5"]+$ron["a6"]+$ron["a7"]+$ron["a8"]+$ron["a9"]+$ron["a10"]+$ron["a11"]+$ron["a12"]+$ron["a13"]+$ron["a14"]+$ron["a15"]+$ron["a16"]+$ron["a17"]+$ron["a18"]+$ron["a19"]+$ron["a20"]+$ron["a21"]+$ron["a22"]+$ron["a23"];
	echo "<table cellpadding=2 cellspacing=1 border=0 width=100%>
		<tr><td class=st1 bgcolor=\"#f2f3f7\"><b>$banneri[47]</b></td><td class=st1 bgcolor=\"#f2f3f7\"><b>$banneri[43]</b></td><td class=st1 bgcolor=\"#f2f3f7\"><b>$banneri[44]</b></td></tr>
		<tr><td class=st1><b>00:00</b></td><td class=st1>$ron[b0]</td><td class=st1>$ron[a0]</td></tr>
		<tr><td class=st1><b>01:00</b></td><td class=st1>$ron[b1]</td><td class=st1>$ron[a1]</td></tr>
		<tr><td class=st1><b>02:00</b></td><td class=st1>$ron[b2]</td><td class=st1>$ron[a2]</td></tr>
		<tr><td class=st1><b>03:00</b></td><td class=st1>$ron[b3]</td><td class=st1>$ron[a3]</td></tr>
		<tr><td class=st1><b>04:00</b></td><td class=st1>$ron[b4]</td><td class=st1>$ron[a4]</td></tr>
		<tr><td class=st1><b>05:00</b></td><td class=st1>$ron[b5]</td><td class=st1>$ron[a5]</td></tr>
		<tr><td class=st1><b>06:00</b></td><td class=st1>$ron[b6]</td><td class=st1>$ron[a6]</td></tr>
		<tr><td class=st1><b>07:00</b></td><td class=st1>$ron[b7]</td><td class=st1>$ron[a7]</td></tr>
		<tr><td class=st1><b>08:00</b></td><td class=st1>$ron[b8]</td><td class=st1>$ron[a8]</td></tr>
		<tr><td class=st1><b>09:00</b></td><td class=st1>$ron[b9]</td><td class=st1>$ron[a9]</td></tr>
		<tr><td class=st1><b>10:00</b></td><td class=st1>$ron[b10]</td><td class=st1>$ron[a10]</td></tr>
		<tr><td class=st1><b>11:00</b></td><td class=st1>$ron[b11]</td><td class=st1>$ron[a11]</td></tr>
		<tr><td class=st1><b>12:00</b></td><td class=st1>$ron[b12]</td><td class=st1>$ron[a12]</td></tr>
		<tr><td class=st1><b>13:00</b></td><td class=st1>$ron[b13]</td><td class=st1>$ron[a13]</td></tr>
		<tr><td class=st1><b>14:00</b></td><td class=st1>$ron[b14]</td><td class=st1>$ron[a14]</td></tr>
		<tr><td class=st1><b>15:00</b></td><td class=st1>$ron[b15]</td><td class=st1>$ron[a15]</td></tr>
		<tr><td class=st1><b>16:00</b></td><td class=st1>$ron[b16]</td><td class=st1>$ron[a16]</td></tr>
		<tr><td class=st1><b>17:00</b></td><td class=st1>$ron[b17]</td><td class=st1>$ron[a17]</td></tr>
		<tr><td class=st1><b>18:00</b></td><td class=st1>$ron[b18]</td><td class=st1>$ron[a18]</td></tr>
		<tr><td class=st1><b>19:00</b></td><td class=st1>$ron[b19]</td><td class=st1>$ron[a19]</td></tr>
		<tr><td class=st1><b>20:00</b></td><td class=st1>$ron[b20]</td><td class=st1>$ron[a20]</td></tr>
		<tr><td class=st1><b>21:00</b></td><td class=st1>$ron[b21]</td><td class=st1>$ron[a21]</td></tr>
		<tr><td class=st1><b>22:00</b></td><td class=st1>$ron[b22]</td><td class=st1>$ron[a22]</td></tr>
		<tr><td class=st1><b>23:00</b></td><td class=st1>$ron[b23]</td><td class=st1>$ron[a23]</td></tr>
		
		<tr><td class=st1 bgcolor=\"#f2f3f7\"><b>$banneri[46]</b></td><td class=st1 bgcolor=\"#f2f3f7\"><b>$bsum</b></td><td class=st1 bgcolor=\"#f2f3f7\"><b>$asum</b></td></tr></table>";


	?>
					<table cellpadding="0" cellspacing="0" border="0" width="550">
	  	    	<tr>
		 				  <td valign="middle" height="30" width="140"><INPUT TYPE=Button VALUE="<?php echo $banneri[65];?>" class=button onclick='javascript:history.go(-1)'></td>
	   				</tr>
			    </table>
				</td>
			</tr>
		</table>
	</body>
</html>


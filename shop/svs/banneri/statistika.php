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
	$k1=0;
	$k2=0;
$result_b=mysql_query("select * from banners where id='$name'");
$row_b=mysql_fetch_array($result_b);

	$i=1;
	$results_b=mysql_query("select * from banners_$name order by id desc");
	echo "<table cellpadding=2 cellspacing=1 border=0 width=100% style=\"border: 1px solid #d0d2dd\"><tr><td class=st1 bgcolor=\"#f2f3f7\"><b>$banneri[42]</b></td><td class=st1 bgcolor=\"#f2f3f7\"><b>$banneri[43]</b></td><td class=st1 bgcolor=\"#f2f3f7\"><b>$banneri[44]</b></td><td class=st1 bgcolor=\"#f2f3f7\"><b>$banneri[45]</b></td></tr>";
	while($ron=mysql_fetch_array($results_b)){
	$bsum=$ron["b0"]+$ron["b1"]+$ron["b2"]+$ron["b3"]+$ron["b4"]+$ron["b5"]+$ron["b6"]+$ron["b7"]+$ron["b8"]+$ron["b9"]+$ron["b10"]+$ron["b11"]+$ron["b12"]+$ron["b13"]+$ron["b14"]+$ron["b15"]+$ron["b16"]+$ron["b17"]+$ron["b18"]+$ron["b19"]+$ron["b20"]+$ron["b21"]+$ron["b22"]+$ron["b23"];
	$asum=$ron["a0"]+$ron["a1"]+$ron["a2"]+$ron["a3"]+$ron["a4"]+$ron["a5"]+$ron["a6"]+$ron["a7"]+$ron["a8"]+$ron["a9"]+$ron["a10"]+$ron["a11"]+$ron["a12"]+$ron["a13"]+$ron["a14"]+$ron["a15"]+$ron["a16"]+$ron["a17"]+$ron["a18"]+$ron["a19"]+$ron["a20"]+$ron["a21"]+$ron["a22"]+$ron["a23"];
if($bsum==0){
$bsum=1;
}
$proc=$asum/$bsum*100;
$proc=round($proc,2);
$proc=number_format($proc, 2);

$cik1=strlen($ron["diena"]);
$cik2=strlen($ron["menesis"]);
if($cik1<2){$diena="0".$ron["diena"];}else{$diena=$ron["diena"];}
if($cik2<2){$menesis="0".$ron["menesis"];}else{$menesis=$ron["menesis"];}
	echo "<tr><td class=standart><a href=\"statistika1.php$li1&name=$name&kat=$ron[id]\" class=\"standart_link\"><b>$diena.$menesis.$ron[gads]</b></td><td class=st1>$bsum &nbsp;</td><td class=st1>$asum &nbsp;</td><td class=st1>$proc% &nbsp;</td></tr>";
	$k1=$k1+$asum;
	$k2=$k2+$bsum;
	$i++;
	}
if($k2==0){
$k2=1;
}
$k3=$k1/$k2*100;
$k3=round($k3,2);
$k3=number_format($k3, 2);
echo "<tr><td class=st1 bgcolor=\"#f2f3f7\"><b>$banneri[46]</b></td><td class=st1 bgcolor=\"#f2f3f7\"><b>$k2&nbsp;</b></td><td class=st1 bgcolor=\"#f2f3f7\"><b>$k1&nbsp;</b></td><td class=st1 bgcolor=\"#f2f3f7\"><b>$k3%&nbsp;</b></td></tr></table>";

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


<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");
require_once("user_auth.php");

$error="";

$ord=mysql_query("Select * from pasutijumi where id='$name'");
$pas=mysql_fetch_array($ord);
mysql_free_result($ord);

$domain     = 'https://secureshop.firstdata.lv';
$cert_url   = '../../certs/2851921_imakstore.pem';
$cert_pass  = '6zqBNUg5a';
$trans_id=urlencode($pas["trans_id"]);
$client_ip = $pas["client_ip_addr"];

require("../../Merchant.php");
$ecomm_url = $domain.':8443/ecomm/MerchantHandler';

$merchant = new Merchant($ecomm_url, $cert_url, $cert_pass, 1);

$trans_status = $merchant -> getTransResult($trans_id, $client_ip);


							
$result_code = explode(':', $trans_status);
$result_code = substr($result_code[2], 1, 3);
     
              			

?>

<html>
	<head>
		<title><?php echo $head[0]; ?></title>
		<meta http-equiv="Content-Type" content="text/html; <?php echo $head[1]; ?>">
		<link rel="stylesheet" href="<?php echo $wolf_path; ?>style.css" type="text/css">
		<script language="JavaScript">
			function go( url)
			{
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
				
				
				
				
					<table cellpadding="0" cellspacing="0" width="100%">
						<tr>
		 				  <td height="30" valign="top" class="sad"><a href="delet_session.php<?php echo $li1."&name=$name&limit=$limit"; ?>" class="sad_link"><?php echo $menu_it[3]; ?></a><img src="<?php echo $wolf_path; ?>img/next.gif" align="absmiddle"><a href="apskatit.php<?php echo $li1."&name=$name&limit=$limit"; ?>" class="sad_link"><?php echo $orders[92]; ?></a></td>
	   				</tr>
						<tr>
							<td>
								<table cellpadding="3" cellspacing="2" style="border: 1px solid #d0d2dd" width="100%">
								<form name="jaunumi" enctype="multipart/form-data" action="apskatit.php<?php echo "$li1&name=$name&limit=$limit"; ?>" method="post">
									<tr>
		 							  <td bgcolor="#f2f3f7" class="standart" width="50%" colspan="2"><b><?php echo $orders[21].$pas["id"]; ?></b></td>
										
	   							</tr>
									<tr><td height="10" colspan="2" width="100%"></td></tr>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[23]; ?></td>
										<td class="standart" valign="top" width="75%"><b>
											<?php if($pas["statuss"]=="1") echo $orders[6]; ?>
											<?php if($pas["statuss"]=="2") echo $orders[82]; ?>
											<?php if($pas["statuss"]=="3") echo $orders[9]; ?>
											<?php if($pas["statuss"]=="4") echo $orders[10]; ?>
											<?php if($pas["statuss"]=="5") echo $orders[12]; ?>
                                 <?php if($pas["statuss"]=="6") echo $orders[106]; ?>
                                 <?php if($pas["statuss"]=="7") echo $orders[107]; ?></b>
										</td>
									</tr>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[88]; ?></td>
										<td class="standart" width="75%"><b><?php echo $pas["trans_id"]; ?></b></td>
									</tr>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[22]; ?></td>
										<td class="standart" width="75%"><b><?php echo date("d.m.Y H:i:s",$pas["time"]); ?></b></td>
									</tr>
									<tr>
										<td valign="top" align="right" width="25%" class="standart"><?php echo $orders[93]; ?></td>
										<td class="standart" width="75%"><b><?php $trans_status=str_replace("\n","<br>",$trans_status); echo $trans_status; ?></b></td>
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


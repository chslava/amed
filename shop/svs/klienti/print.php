<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");
require_once("user_auth.php");

$ord=mysql_query("Select * from orders where id='$name'");
$pas=mysql_fetch_array($ord);
mysql_free_result($ord);

$print = mysql_query("update orders set print='2' where id='$name'");

$ord_valsts=mysql_query("Select * from country where id='$pas[country]'");
$pas_valsts=mysql_fetch_array($ord_valsts);
mysql_free_result($ord_valsts);

$ord_zieds=mysql_query("Select * from flowers where id='$pas[parent_id]'");
$pas_zieds=mysql_fetch_array($ord_zieds);
mysql_free_result($ord_zieds);
	
?>
<html>
	<head>
		<title><?php echo $head[0]." ".$orders[21].$pas["id"]; ?></title>
		<meta http-equiv="Content-Type" content="text/html; <?php echo $head[1]; ?>">
		<link rel="stylesheet" href="<?php echo $wolf_path; ?>style.css" type="text/css">
		
	</head>
	<body leftmargin="0" topmargin="0" bgcolor="#ffffff" marginheight="0" marginwidth="0" onload=print()>
	
				
								<table cellpadding="3" cellspacing="2" style="border: 1px solid #d0d2dd" width="100%">
									<tr>
		 							  <td bgcolor="#f2f3f7" class="standart" width="100%" colspan="4"><b><?php echo $orders[21].$pas["id"]; ?></b></td>
	   							</tr>
									<tr><td height="10" colspan="4" width="100%"></td></tr>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[23]; ?></td>
										<td class="standart" valign="top" width="25%">

										<?php if($pas["process"] == "off"){echo $orders[6];} ?>
										<?php if($pas["process"] == "rev"){echo $orders[82];} ?>
										<?php if($pas["process"] == "on"){echo $orders[9];} ?>
										<?php if($pas["process"] == "del"){echo $orders[10];} ?>
										<?php if($pas["process"] == "ok"){echo $orders[12];} ?>
										</td>
										<td valign="top" align="right" width="25%" class="standart" rowspan="7"><?php echo $orders[49]; ?></td>
										<td class="standart" width="25%" valign="top" rowspan="6">
                              <?php 
											list($width,$height)=getimagesize("../../flowers/flowers_small/$pas_zieds[picture]");
											$i_w = $width/2;
											$i_h = $height/2;
										?>
                              <img src="../../flowers/flowers_small/<?php echo $pas_zieds["picture"]; ?>" width="<?php echo $i_w; ?>" height="<?php echo $i_h; ?>"></td>
									</tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[22]; ?></td>
										<td class="standart" width="25%"><b><?php echo date("d.m.Y H:i:s",$pas["time"]); ?></b></td>
									</tr>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[47]; ?></td>
										<td class="standart" width="25%"><b><?php echo $pas["parent_id"]; ?></b></td>
									</tr>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[57]; ?></td>
										<td class="standart" width="25%"><b><?php if($pas["big_small"] == 1){ echo $orders[58];} else{ echo $orders[59];} ?></b></td>
									</tr>
									<tr>
										<td valign="top" align="right" width="25%" class="standart"><?php echo $orders[48]; ?></td>
										<td class="standart" width="25%" valign="top"><b><?php echo $pas["flower_name"]; ?></b></td>
										
									</tr>
									<?php
									$diena=date("w",$pas["del_time"]);
									?>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[25]; ?></td>
										<td class="standart" colspan="3" width="75%"><font size="+1"><b><?php echo date("d.m.Y",$pas["del_time"]).", ".$dienas[$diena]; ?></b></font></td>
									</tr>
                           <?php 
									if($pas["p_laiks"]>0)
									{
									$piegade_m = array("","9.00-10.00","10.00-11.00","11.00-12.00","12.00-13.00","13.00-14.00","14.00-15.00","15.00-16.00","16.00-17.00","17.00-18.00","18.00-19.00");
									?>
                           
                           <tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[96]; ?></td>
										<td class="standart" colspan="3" width="75%"><font size="+1"><b><?php echo $piegade_m[$pas["p_laiks"]]; ?></b></font></td>
									</tr>
                           <?php 
									}
									?>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[78]; ?></td>
										<td class="standart" colspan="3" width="75%"><b><?php if($pas["payment"] == 1) { echo $orders[79];} elseif($pas["payment"] == 2) {echo $orders[80];} else{echo $orders[81];} ?></b></td>
									</tr>
									<tr><td height="10" colspan="4" width="100%"></td></tr>
									<tr>
		 							  <td bgcolor="#f2f3f7" colspan="4" class="standart" width="100%"><b><?php echo $orders[26]; ?></b></td>
	   							</tr>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[27]; ?></td>
										<td class="standart" width="25%"><b><?php echo $pas["first_name"]." ".$pas["last_name"]; ?></b></td>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[35]; ?></td>
										<td class="standart" width="25%"><b><?php echo $pas["phone"]; ?></b></td>
									</tr>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[36]; ?></td>
										<td class="standart" width="25%"><b><?php echo $pas["email"]; ?></b></td>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[37]; ?></td>
										<td class="standart" width="25%"><b><?php $vieta = $pas["delivery"]; echo $pieg_vieta["$vieta"]; ?></b></td>
									</tr>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[33]; ?></td>
										<td class="standart" width="25%"><b><?php echo $pas["address1"]; ?></b></td>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[34]; ?></td>
										<td class="standart" width="25%"><b><?php echo $pas["address2"]; ?></b></td>
									</tr>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[30]; ?></td>
										<td class="standart" width="25%"><b><?php if($pas["country"] ==  1){echo $pas_valsts["name_lv"];} else { echo "<font color=\"#ff0000\">".$pas_valsts["name_lv"]."</font>"; } ?></b></td>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[38]; ?></td>
										<td class="standart" width="25%"><b><?php echo $pas["company"]; ?></b></td>
									</tr>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[29]; ?></td>
										<td class="standart" width="25%"><b><?php echo $pas["del_state"]; ?></b></td>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[28]; ?></td>
										<td class="standart" width="25%"><b><?php echo $pas["del_zip"]; ?></b></td>
									</tr>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[90]; ?></td>
										<td class="standart" width="25%"><b><?php echo $pas["address3"]; ?></b></td>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[31]; ?></td>
										<td class="standart" width="75%" colspan="3"><b><?php echo $orders[77]; ?></b></td>
									</tr>
									<tr><td height="10" colspan="4" width="100%"></td></tr>
									<tr>
		 							  <td bgcolor="#f2f3f7" colspan="4" class="standart" width="100%"><b><?php echo $orders[39]; ?></b></td>
	   							</tr>
									<tr><td height="10" colspan="4" width="100%"></td></tr>
									
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[40]; ?></td>
										<td class="standart" width="25%"><b><?php echo $pas["client_name"]; ?></b></td>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[42]; ?></td>
										<td class="standart" width="25%"><b><?php echo $pas["alternative_email"]; ?></b></td>
										
									</tr>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[41]; ?></td>
										<td class="standart" width="25%"><b><?php echo $pas["client_email"]; ?></b></td>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[50]; ?></td>
										<td class="standart" width="25%"><b><?php echo $pas["ip"]; ?></b></td>
									</tr>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[76]; ?></td>
										<td class="standart" width="25%"><b><?php echo $pas["phone_address"]; ?></b></td>
									</tr>
									<tr><td height="10" colspan="4" width="100%"></td></tr>
									<tr>
		 							  <td bgcolor="#f2f3f7" colspan="4" class="standart" width="100%"><b><?php echo $orders[43]; ?></b></td>
	   							</tr>
									<tr><td height="10" colspan="4" width="100%"></td></tr>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[45]; ?></td>
										<td class="standart" colspan="3" width="75%"><b><?php echo $pas["card_text"]; ?></b></td>
									</tr>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[44]; ?></td>
										<td class="standart" colspan="3" width="75%"><b><?php echo $pas["card_name"]; ?></b></td>
									</tr>
									
									<tr><td height="10" colspan="4" width="100%"></td></tr>
									<tr>
		 							  <td bgcolor="#f2f3f7" colspan="4" class="standart" width="100%"><b><?php echo $orders[46]; ?></b></td>
	   							</tr>
									<tr><td height="10" colspan="4" width="100%"></td></tr>
									<?php if($pas["gift1_id"]>0){
									$gi=mysql_query("Select * from gifts where id='$pas[gift1_id]'");
									$gif=mysql_fetch_array($gi);
									mysql_free_result($gi);
									?>
									<tr>
										<td valign="top" align="right" width="25%" class="standart"><?php echo $orders[51]; ?></td>
										<td class="standart" colspan="3" width="75%"><b><?php echo $gif["name_lv"];?></b></td>
									</tr>
								
									<?php } ?>
									<?php if($pas["gift2_id"]>0){
									$gi=mysql_query("Select * from gifts where id='$pas[gift2_id]'");
									$gif=mysql_fetch_array($gi);
									mysql_free_result($gi);
									?>
									<tr>
										<td valign="top" align="right" width="25%" class="standart"><?php echo $orders[51]; ?></td>
										<td class="standart" colspan="3" width="75%"><b><?php echo $gif["name_lv"];?></b></td>
									</tr>
								
									<?php } ?>
									<?php if($pas["gift3_id"]>0){
									$gi=mysql_query("Select * from gifts where id='$pas[gift3_id]'");
									$gif=mysql_fetch_array($gi);
									mysql_free_result($gi);
									?>
									<tr>
										<td valign="top" align="right" width="25%" class="standart"><?php echo $orders[51]; ?></td>
										<td class="standart" colspan="3" width="75%"><b><?php echo $gif["name_lv"];?></b></td>
									</tr>
									<?php } ?>
									<tr><td height="10" colspan="4" width="100%"></td></tr>
									<tr>
		 							  <td bgcolor="#f2f3f7" colspan="4" class="standart" width="100%"><b><?php echo $orders[53]; ?></b></td>
	   							</tr>
									<tr><td height="10" colspan="4" width="100%"></td></tr>
									<tr>
										<td valign="top" align="right" width="25%" class="standart"><?php echo $orders[54]; ?></td>
										<td class="standart" ><b><?php echo $pas["flower_price"];?> €</b></td>
                              <td valign="top" align="right" width="25%" class="standart"><?php echo $orders[55]; ?></td>
										<td class="standart"><b><?php if($pas["gift_price"]== "0.00") {echo $pas["gift_price"]." €"; } else { ?><font color="#ff0000"><?php echo $pas["gift_price"];?> €</b></font><?php } ?></td>
									</tr>
									
									<tr>
										<td valign="top" align="right" width="25%" class="standart"><?php echo $orders[67]; ?></td>
										<td class="standart"  ><b><?php echo $pas["taxes"];?> €</b></td>
                              <td valign="top" align="right" width="25%" class="standart"><?php echo $orders[97]; ?></td>
										<td class="standart" ><b><?php if($pas["p_laiks"]>0){ echo "10.00";} else{ echo "0.00";}?> €</b></td>
									</tr>
                          
                           <tr>
										<td valign="top" align="right" width="25%" class="standart"><?php echo $orders[100]; ?></td>
										<td class="standart"><b><?php if($pas["pap_1"]>0){ echo "$pas[pap_1]";} else{ echo "0.00";}?> €</b></td>
                              <td valign="top" align="right" width="25%" class="standart"><?php echo $orders[101]; ?></td>
										<td class="standart" ><b><?php if($pas["pap_2"]>0){ echo "$pas[pap_2]";} else{ echo "0.00";}?> €</b></td>
									</tr>
                           
                           <tr>
										<td valign="top" align="right" width="25%" class="standart"><?php echo $orders[102]; ?></td>
										<td class="standart"  ><b><?php if($pas["pap_3"]>0){ echo "$pas[pap_3]";} else{ echo "0.00";}?> €</b></td>
                              <td valign="top" align="right" width="25%" class="standart"><?php echo $orders[103]; ?></td>
										<td class="standart" ><b><?php if($pas["pap_4"]>0){ echo "$pas[pap_4]";} else{ echo "0.00";}?> €</b></td>
									</tr>
                          
									<tr>
										<td valign="top" align="right" width="25%" class="standart"><font size="+1"><b><?php echo $orders[56]; ?></b></font></td>
										<td class="standart" colspan="3" width="75%"><font size="+1"><b><?php echo $pas["total_price"];?> €</b></font></td>
									</tr>
									<tr><td height="10" colspan="4" width="100%"></td></tr>
								</table>

					

		
	</body>
</html>
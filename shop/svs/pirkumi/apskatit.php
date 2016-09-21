<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

$error="";

$ord=mysqli_query($result_db,"Select * from orders where id='$name'");
$pas=mysqli_fetch_array($ord);
mysqli_free_result($ord);

$cli = mysqli_query($result_db,"select * from clients where id = '$pas[user_id]'");
$client = mysqli_fetch_array($cli);
mysqli_free_result($cli);

$msg = '-';
if($client["person"] == 1)
{
	if($client["company_contract"] == 2)
	{
		$msg = $e[149];
	}
}
else
{
	if($client["person_contract"] == 2)
	{
		$msg = $e[149];
	}
}



$person = $pas["person"];
$deliver_array = array("-",$e[140],$e[141],$e[142],$e[143]);
$deliver_id = $pas["deliver"];
	
if(isset($_POST["submit"]))
{
	$change_from=array("\"","\'","'","/n");
	$change_to=array("&quot;","","","<br>");
	
	if(!empty($_POST["statuss"])){
	$statuss=str_replace($change_from,$change_to,$_POST["statuss"]);
	$statuss=trim($statuss);
	}
	
	
	$result = mysqli_query($result_db,"update orders set statuss='$statuss' where id='$name'");
	$add_statuss = mysqli_query($result_db,"insert into statuses values (
		'',
		'$name',
		'".time()."',		
		'$statuss'	
		)");
	
	$links = "index.php".$li1."&limit=$limit";
	header("Location: $links");
}

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
				<td colspan="2" height="20" bgcolor="d0d2dd">&nbsp;</td>
			</tr>
			<tr>
				<td bgcolor="#ffffff" width="100%" valign="top" class="text">
				
				
				
				
					<table cellpadding="0" cellspacing="0" width="100%">
						<tr>
		 				  <td height="30" valign="top" class="sad"><a href="delet_session.php<?php echo $li1."&name=$name&limit=$limit"; ?>" class="sad_link"><?php echo $menu_it[24]; ?></a><img src="<?php echo $wolf_path; ?>img/next.gif" align="absmiddle"><a href="apskatit.php<?php echo $li1."&name=$name&limit=$limit"; ?>" class="sad_link"><?php echo $orders[19]; ?></a></td>
	   				</tr>
						<tr>
							<td align="left">
                     
                     
                     
                    	 	
                        
                        
								<table cellpadding="3" cellspacing="2" style="border: 1px solid #d0d2dd" width="100%">
								<form name="jaunumi" enctype="multipart/form-data" action="apskatit.php<?php echo "$li1&name=$name&limit=$limit"; ?>" method="post">
									<tr>
		 							  <td bgcolor="#f2f3f7" class="standart" width="50%" colspan="2"><b><?php echo $orders[21].$pas["id"]; ?></b></td>
										<?php $ses_id = session_id(); ?>
										
	   							</tr>
									<tr><td height="10" colspan="2" width="100%"></td></tr>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[23]; ?></td>
										<td class="standart" valign="top" colspan="3" width="75%">
										<select name="statuss" class="input">
											<option value="0" <?php if($pas["statuss"]=="0")echo " selected"; ?>><?php echo $statuses[0]; ?></option>
											<option value="1" <?php if($pas["statuss"]=="1")echo " selected"; ?>><?php echo $statuses[1]; ?></option>
											<option value="2" <?php if($pas["statuss"]=="2")echo " selected"; ?>><?php echo $statuses[2]; ?></option>
											<option value="3" <?php if($pas["statuss"]=="3")echo " selected"; ?>><?php echo $statuses[3]; ?></option>
											<option value="4" <?php if($pas["statuss"]=="4")echo " selected"; ?>><?php echo $statuses[4]; ?></option>
											<option value="5" <?php if($pas["statuss"]=="5")echo " selected"; ?>><?php echo $statuses[5]; ?></option>
											<option value="6" <?php if($pas["statuss"]=="6")echo " selected"; ?>><?php echo $statuses[6]; ?></option>
										</select>&nbsp;
										<input type="Submit" name="submit" class="button" value="<?php echo $orders[24]; ?>">
										</td>
									</tr>                           
									
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $orders[22]; ?></td>
										<td class="standart" width="75%"><b><?php echo date("d.m.Y H:i:s",$pas["time"]); ?></b></td>
									</tr>
									<?php
									$gifts = array("",$e[191],$e[192],$e[193]);
									$query = mysqli_query($result_db,"select * from gifts where order_id = '$pas[id]'");
									if($mysql = mysqli_fetch_array($query))
									{					
										$gift_id = $mysql["type"];			
									?>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart" style="color: red;"><b><?php echo $orders[159]; ?>:</b></td>
										<td class="standart" width="75%" style="color: white;"><span style="background: red; padding: 3px 5px;"><b><?php echo $gifts[$gift_id]; ?></b></span></td>
									</tr>
									<?php
									}
									mysqli_free_result($query)
									?>
									<?php
									
									$query = mysqli_query($result_db,"select * from coupons where order_id = '$pas[id]'");
									if($mysql = mysqli_fetch_array($query))
									{							
									?>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart" style="color: red;"><b><?php echo $orders[160]; ?>:</b></td>
										<td class="standart" width="75%" style="color: white;"><span style="background: red; padding: 3px 5px;"><b><?php echo $mysql["value"]."%"; ?></b></span></td>
									</tr>
									<?php
									}
									mysqli_free_result($query)
									?>
									
                                    <tr>
										<td valign="middle" align="right" width="25%" class="standart"><br /><font style="font-size:14px; font-weight:bold;"><?php echo $e[77]; ?></font></td>
                                        <td></td>
									</tr>
									<?php
									if($person == 2)
									{
										
									?>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $e[91]; ?>:</td>
										<td class="standart" width="75%"><b><?php echo $pas["person_name"]; ?></b></td>
									</tr>
                                    <tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $e[92]; ?>:</td>
										<td class="standart" width="75%"><b><?php echo $pas["person_code"]; ?></b></td>
									</tr>   
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $e[123]; ?>:</td>
										<td class="standart" width="75%"><b><?php echo $msg; ?></b></td>
									</tr>                                  
                                    <tr>
										<td valign="middle" align="right" width="25%" class="standart"><br /><font style="font-size:14px; font-weight:bold;"><?php echo $e[86]; ?></font></td>
                                        <td></td>
									</tr>
                          			<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $e[87]; ?>:</td>
										<td class="standart" width="75%"><b><?php echo $pas["person_phone"]; ?></b></td>
									</tr>
                                    <tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $e[88]; ?>:</td>
										<td class="standart" width="75%"><b><?php echo $pas["person_email"]; ?></b></td>
									</tr>
                                    <tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $e[89]; ?>:</td>
										<td class="standart" width="75%"><b><?php echo $pas["person_deliver"]; ?></b></td>
									</tr>    
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $e[139]; ?>:</td>
										<td class="standart" width="75%"><b><?php echo $deliver_array[$deliver_id]; ?></b></td>
									</tr>                                
                                    <tr>
										<td valign="middle" align="right" width="25%" class="standart"><br /><font style="font-size:14px; font-weight:bold;"><?php echo $e[90]; ?></font></td>
                                        <td></td>
									</tr>
                          			<tr>
										<td valign="middle" align="right" width="25%" class="standart"></td>
										<td class="standart" width="75%"><b><?php echo $pas["person_comments"]; ?></b></td>
									</tr>
									<?php
									}
									else
									{
									?>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $e[80]; ?>:</td>
										<td class="standart" width="75%"><b><?php echo $pas["company_name"]; ?></b></td>
									</tr>
                                    <tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $e[81]; ?>:</td>
										<td class="standart" width="75%"><b><?php echo $pas["company_code"]; ?></b></td>
									</tr>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $e[82]; ?>:</td>
										<td class="standart" width="75%"><b><?php echo $pas["company_address"]; ?></b></td>
									</tr>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $e[83]; ?>:</td>
										<td class="standart" width="75%"><b><?php echo $pas["company_bank"]; ?></b></td>
									</tr>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $e[85]; ?>:</td>
										<td class="standart" width="75%"><b><?php echo $pas["company_account"]; ?></b></td>
									</tr> 
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $e[123]; ?>:</td>
										<td class="standart" width="75%"><b><?php echo $msg; ?></b></td>
									</tr>                                   
                                    <tr>
										<td valign="middle" align="right" width="25%" class="standart"><br /><font style="font-size:14px; font-weight:bold;"><?php echo $e[86]; ?></font></td>
                                        <td></td>
									</tr>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $e[91]; ?>:</td>
										<td class="standart" width="75%"><b><?php echo $pas["company_person"]; ?></b></td>
									</tr>
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $e[138]; ?>:</td>
										<td class="standart" width="75%"><b><?php echo $pas["company_position"]; ?></b></td>
									</tr>
                          			<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $e[87]; ?>:</td>
										<td class="standart" width="75%"><b><?php echo $pas["company_phone"]; ?></b></td>
									</tr>
                                    <tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $e[88]; ?>:</td>
										<td class="standart" width="75%"><b><?php echo $pas["company_email"]; ?></b></td>
									</tr>
                                    <tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $e[89]; ?>:</td>
										<td class="standart" width="75%"><b><?php echo $pas["company_deliver"]; ?></b></td>
									</tr>   
									<tr>
										<td valign="middle" align="right" width="25%" class="standart"><?php echo $e[139]; ?>:</td>
										<td class="standart" width="75%"><b><?php echo $deliver_array[$deliver_id]; ?></b></td>
									</tr>                                    
                                    <tr>
										<td valign="middle" align="right" width="25%" class="standart"><br /><font style="font-size:14px; font-weight:bold;"><?php echo $e[90]; ?></font></td>
                                        <td></td>
									</tr>
                          			<tr>
										<td valign="middle" align="right" width="25%" class="standart"></td>
										<td class="standart" width="75%"><b><?php echo $pas["company_comments"]; ?></b></td>
									</tr>
									<?php
									}
									?>
                          			
                           			
                           
									
									<tr><td height="10" colspan="2" width="100%"></td></tr>
						
								
									
								</table>
                        <table cellpadding="0" cellspacing="0" border="0">
                        	<tr>
                           	<td height="20"></td>
                           </tr>
                        </table>
									
                              
                        <?php 
							 $rates = array(); $all_pvn = ""; $all_rates = array();
				$query = mysqli_query($result_db,"select * from rates order by name asc");
				while($mysql = mysqli_fetch_array($query))
				{
					$value_id = $mysql["id"];
					$value = $mysql["name"];
					$rates[$value] = 0;
					$all_rates[$value] = $value;
				}
				mysqli_free_result($query);
				
								$data=time();								
								$rep=mysqli_query($result_db,"Select * from ordered_items where parent_id='$pas[id]' order by id asc");
								$z=mysqli_num_rows($rep);
								if($z>0)
								{									
									$kopsumma=0;
									$pvn_kopsumma=0;
									$cena_bez_pvn_kopa=0;
								?>
                        	<table cellpadding="3" cellspacing="1" border="0" width="100%" style="border: 1px solid #d0d2dd">
                        		
                              <tr>
                              	<td class="standart" bgcolor="#f2f3f7" valign="top" align="left"><b><?php echo $t[63]; ?></b></td>
                                 <td class="standart" bgcolor="#f2f3f7" valign="top" align="left"><b><?php echo $t[64]; ?></b></td>
                                 <td class="standart" bgcolor="#f2f3f7" valign="top" align="left"><b><?php echo $t[55]; ?></b></td>
                                 <td class="standart" bgcolor="#f2f3f7" valign="top" align="left"><b><?php echo $t[160]; ?></b></td>
                                 <td class="standart" bgcolor="#f2f3f7" valign="top" align="left"><b><?php echo $t[65]; ?></b></td>
                                 <td class="standart" bgcolor="#f2f3f7" valign="top" align="left"><b><?php echo $t[67]; ?></b></td>                                
                                 
                              </tr>
                        	<?php 
                        	$total_count = 0;
									while($prece=mysqli_fetch_array($rep))
									{
										$total_count = $total_count + $prece["count"];
										$rat = $prece["rate"];
										
										$p=mysqli_query($result_db,"Select * from items where id='$prece[item_id]'");
										$pr=mysqli_fetch_array($p);
										mysqli_free_result($p);
										
										$pe=mysqli_query($result_db,"Select * from categories where id='$pr[parent_id]'");
										$kategorija=mysqli_fetch_array($pe);
										mysqli_free_result($pe);
										
										$rate = $prece["rate"];	
										$cena_ar_pvn = $prece["price"];			
											
										$cena_bez_pvn = round($prece["price"] / 1/(1 + $prece["rate"]/100), 3);
										$cena_bez_pvn = number_format(round($cena_bez_pvn,2), 2, '.','');
										
										$summa_bez_pvn = round($prece["price"] / 1/(1 + $prece["rate"]/100) * $prece["count"], 3);
										$summa_bez_pvn = number_format(round($summa_bez_pvn,2), 2, '.','');
										
										$summa_bez_pvn = number_format(round($cena_bez_pvn * $prece["count"],2), 2, '.','');
										
										$cena_bez_pvn_kopa = $cena_bez_pvn_kopa + ($prece["price"] / 1/(1 + $prece["rate"]/100)) * $prece["count"];		
										$pvn_kopsumma = $pvn_kopsumma + ($prece["price"] / 1/(1 + $prece["rate"]/100)) * $prece["rate"]/100 * $prece["count"]; 
										$kopsumma = $kopsumma + $prece["price"] * $prece["count"];
										
										$rates[$rate] = $rates[$rate] + $prece["price"]/(1 + $rate/100) * $rate/100 * $prece["count"];
									?>
                      			<tr>
	                           	<td valign="top" class="st1"><img src="<?php echo "../../pictures/items/small/$pr[picture]";?>" border="0"></td>
                             		<td valign="top" class="st1"><b><?php echo $pr["name_lv"]; ?></b></div></td>
                                 <td valign="top" class="st1"><?php echo $pr["code"]; ?></div></td>
                                
                                 <td valign="top" class="st1"><?php echo $cena_bez_pvn."  $t[68]"; ?></td>
                                 <td valign="top" class="st1"><?php echo $prece["count"]." $t[66]"; ?></td>
                                 <td valign="top" class="st1"><?php echo $summa_bez_pvn." $t[68]"; ?></td>
                              </tr>
                        		
                           <?php 
									}
									  
									$kk=$pas["amount"]/100;									 
									
									$cena_bez_pvn_kopa = number_format($cena_bez_pvn_kopa, 2, '.','');
									  
									
				
									$pvn = number_format(round($pvn_kopsumma,2), 2, '.','');  
									$kopa = number_format($kopsumma , 2, '.','');
									echo "
										<tr>
											<td colspan=\"7\" class=\"tabula\" valign=\"top\" align=\"right\">
												<table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" align=\"right\">
													<tr>
														<td class=\"standart\" align=\"right\">$t[123] </td>
														<td width=\"5\"></td>
														<td class=\"standart\">$cena_bez_pvn_kopa $t[68]</td>
													</tr>";
													
													
													$query = mysqli_query($result_db,"select * from rates order by name asc");
										while($mysql = mysqli_fetch_array($query))
										{
											$value = $mysql["name"];
											$value_id = $mysql["id"];
										
											
											echo "
													<tr>
														<td class=\"standart\" align=\"right\">$t[126] $value%</td>
														<td width=\"5\"></td>
														<td class=\"standart\">".number_format($rates[$value],2,".","")." $e[13]</td>
													</tr>";
											$rates[$value] = 0;
										}
										mysqli_free_result($query);
													
														if($pas["deliver"] > 2)
														{
															$kopa = $kopa + $pas["deliver_total"];
															echo "
													
													<tr>
														<td class=\"standart\" align=\"right\">$e[146]</td>
														<td width=\"5\"></td>
														<td class=\"standart\">$pas[deliver_total] $t[68]</td>
													</tr>";
														}												
													
													
													
													echo "
													
													<tr>
														<td class=\"standart\" align=\"right\"><b>$t[127]</b></td>
														<td width=\"5\"></td>
														<td class=\"standart\"><b>".number_format($kopa,2,".","")." $t[68]</b></td>
													</tr>";
													
													$discount = 0;
													$query = mysqli_query($result_db,"select * from points where type = '2' and order_id = '$pas[id]'");
													if($mysql = mysqli_fetch_array($query))
													{
														
														$discount = $discount - $mysql["value"];
													}
													mysqli_free_result($query);
													
													
													
													$query = mysqli_query($result_db,"select * from coupons where order_id = '$pas[id]'");
													if($mysql = mysqli_fetch_array($query))
													{
														$discount = $discount + $mysql["value"] / 100 * $kopa;
													}
													mysqli_free_result($query);
													
													if($pas["d5"] == 1)
													{
														$discount = $discount + $pas["dv5"] / 100;
													}
																										
													$kopa = $kopa - $discount;
													
													$discount_info = array();
													$discount_info_text = '';
													if($discount > 0)
													{
														if($pas["d1"] > 0){$discount_info[] = $e[195];}
														if($pas["d2"] == 2){$discount_info[] = $e[198];}
														if($pas["d3"] > 0){$discount_info[] = $e[196];}
														if($pas["d4"] > 0){$discount_info[] = $e[197];}
														
														if(count($discount_info) > 0)
														{
														    $discount_info_text = ' ('.implode(", ",$discount_info).')';
														}

														echo "
													<tr>
														<td class=\"standart\" align=\"right\"><b>$e[155]$discount_info_text</b></td>
														<td width=\"5\"></td>
														<td class=\"standart\"><b>-".number_format($discount,2,".","")." $t[68]</b></td>
													</tr>
													<tr>
														<td class=\"standart\" align=\"right\"><b>$e[156]</b></td>
														<td width=\"5\"></td>
														<td class=\"standart\"><b>".number_format($kopa,2,".","")." $t[68]</b></td>
													</tr>";
													}
													
													
													
													
													echo "
													
												</table>
											</td>
										</tr>";
								}
								mysqli_free_result($rep); 
								?>
                        
                        	</table>
                              
                           <table cellpadding="0" cellspacing="0" border="0">
									
									<tr>
                           	<td height="10" colspan="4" width="100%"></td>
                           </tr>
									
                           </table>

                           
                           	<?php
                           	$statuss_text = array(0 => $statuses[0], 1 => $statuses[1], 2 => $statuses[2], 3 => $statuses[3], 4 => $statuses[4], 5 => $statuses[5], 6 => $statuses[6]);
                           	$query = mysqli_query($result_db,"select * from statuses where order_id = '$name' order by time asc");
                           	$count = mysqli_num_rows($query);
                           	if($count > 0)
                           	{
                           		echo '
                           			<table cellpadding="3" cellspacing="1" border="0" width="100%" style="border: 1px solid #d0d2dd">
                        				<tr>
                            	  			<td class="standart" bgcolor="#f2f3f7" valign="top" align="left"><b>'.$orders[145].'</b></td>
                            	  			<td class="standart" bgcolor="#f2f3f7" valign="top" align="left"><b>'.$orders[146].'</b></td>
                            	  		</tr>
                            	  	';
                           		while($mysql = mysqli_fetch_array($query))
                           		{
                           			$st_id = $mysql["statuss"];
                           			echo '
                           			
                        				<tr>
                            	  			<td class="st1" valign="top" align="left">'.$statuss_text[$st_id].'</td>
                            	  			<td class="st1" valign="top" align="left">'.date("d.m.Y H:i:s",$mysql["time"]).'</td>
                            	  		</tr>
                            	  	';
                           		}
                           		echo '
                           			
                            	  	</table>
                            	  	';
                           	}
                           	mysqli_free_result($query);
                           	?>   
                              
                              
                              
                           <table cellpadding="0" cellspacing="0" border="0">
									
									<tr>
                           	<td height="10" colspan="4" width="100%"></td>
                           </tr>
									<tr>
										<td align="left"><INPUT TYPE="Button" VALUE="<?php echo $orders[20];?>" class="button" onclick='go("index.php<?php echo $li1."&limit=$limit"; ?>")'></td>
									</tr>
                           </table>
									</form>
									
								
							</td>
						</tr>
					</table>
					
					
				</td>
			</tr>
		</table>
	</body>
</html>


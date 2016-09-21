<?php 
if(isset($_POST["order-confirm"]))
{	
	$discount_info = array();
	$discount_info_text = '';
	$gifts_client_txt = "";
	$gifts_client_html = "";
	$gifts_admin_txt = "";
	$gifts_admin_html = "";
	
	$deliver = 0;
	$order_error = array();
	$deliver_array = array("-",$e[140],$e[141],$e[142],$e[143]);
	
	$all_emails = array();
	
	$error_msg = '';
	
	
	if(isset($_POST["points"]))
	{
		if($_POST["points"] == "on")
		{
			$_POST["points"] = 2;
		}
		else
		{
			$_POST["points"] = 1;
		}
	}
	else
	{
		$_POST["points"] = 1;
	}
	$coupon_accept = 0;
	
	if(!isset($_POST["coupon"]))
	{
		$_POST["coupon"] = "";
	}
	
	if(!empty($_POST["coupon"]))
	{
		if($_POST["coupon"] == $coupon_text)
		{
			$coupon_accept = 1;
			$d3 = 2;
			$d3_value = $coupon_discount;
		}
		elseif($_POST["coupon"] == $coupon_text1)
		{
			$coupon_accept = 1;
			$coupon_discount = $coupon_discount1;
			$d3 = 1;
			$d3_value = $coupon_discount;
		}
		else
		{
			$error[2] = 1;
			$error_msg .= 'Kupona kods ir ierakstīts nepareizi<br />';
		}
	}
		
	if($_POST["person"] == 2)
	{
		if(empty($_POST["person_name"])){$error[1] = 1;}
		if(empty($_POST["person_code"])){$error[1] = 1;}
		if(empty($_POST["person_phone"])){$error[1] = 1;}
		if(empty($_POST["person_email"])){$error[1] = 1;}
		if(empty($_POST["person_deliver"])){$error[1] = 1;}
		
		if(isset($error[1]))
		{
			$error_msg .= 'Nav aizpildīti visi lauciņi<br />';
		}
		
		$client_email = $_POST["person_email"];
		$client_name = $_POST["person_name"];
		
		if($_POST["p_deliver"] > 0)
		{
			if($_POST["p_deliver"] == 3)
			{
				$deliver = $e[144];
			}
			if($_POST["p_deliver"] == 4)
			{
				$deliver = $e[145];
			}
		}
		else
		{
			$error[1] = 1;
			$error_msg .= 'Nav izvēlēta piegādes maksa<br />';
		}
		$delivery = $_POST["p_deliver"];
	}
	else
	{
		if(empty($_POST["company_name"])){$error[1] = 1;}
		if(empty($_POST["company_code"])){$error[1] = 1;}
		if(empty($_POST["company_address"])){$error[1] = 1;}
		if(empty($_POST["company_bank"])){$error[1] = 1;}
		if(empty($_POST["company_account"])){$error[1] = 1;}
		if(empty($_POST["company_phone"])){$error[1] = 1;}
		if(empty($_POST["company_email"])){$error[1] = 1;}
		if(empty($_POST["company_deliver"])){$error[1] = 1;}
		if(empty($_POST["company_person"])){$error[1] = 1;}
		if(empty($_POST["company_position"])){$error[1] = 1;}
		
		if(isset($error[1]))
		{
			$error_msg .= 'Nav aizpildīti visi lauciņi<br />';
		}
		
		$client_email = $_POST["company_email"];
		$client_name = $_POST["company_name"];
		if($_POST["c_deliver"] > 0)
		{
			if($_POST["c_deliver"] == 3)
			{
				$deliver = $e[144];
			}
			if($_POST["c_deliver"] == 4)
			{
				$deliver = $e[145];
			}
		}
		else
		{
			$error[1] = 1;
			$error_msg .= 'Nav izvēlēta piegādes maksa<br />';
		}
		$delivery = $_POST["c_deliver"];
	}	
	
	if(!filter_var($client_email, FILTER_VALIDATE_EMAIL)) 
	{
		$error[3] = 1;
		$error_msg .= 'Nepareizi ierakstīta e-pasta adrese<br />';
	}
	
	if(count($error) == 0)
	{
		$person_id = $_POST["person"];
		$persons = array("",$e[78],$e[79]);
		
		$contract_msg = '-';
		if($user_id > 0)
		{
			if($uses["person"] == 1)
			{
				//Uzņēmums
				if($uses["company_contract"] == 2)
				{
					$contract_msg = $e[149];
				}
			}
			else
			{
				//Privātpersona
				if($uses["person_contract"] == 2)
				{
					$contract_msg = $e[149];
				}	
			}
		}
		
		$gr = mysql_query("Select * from basket where ip = '$ip' and session_id = '$ses_id' and user_id='$user_id' order by id asc");		
		$gr_cik = mysql_num_rows($gr);
		if($gr_cik > 0)
		{
			$laiks = time();			
			$result = mysql_query("insert into orders values
			(
			'',
			'$user_id',
			'$ses_id',
			'$laiks',
			'0',
			'$ip',
			
			'$_POST[person]',
			'$_POST[company_name]',
			'$_POST[company_code]',
			'$_POST[company_address]',
			'$_POST[company_bank]',
			'',
			'$_POST[company_account]',	
			'$_POST[company_phone]',
			'$_POST[company_email]',
			'$_POST[company_deliver]',
			'$_POST[company_comments]',
			
			'$_POST[person_name]',
			'$_POST[person_code]',	
			'$_POST[person_phone]',
			'$_POST[person_email]',
			'$_POST[person_deliver]',
			'$_POST[person_comments]',
			'0',
			
			'$_POST[company_person]',
			'$_POST[company_position]',
			'$delivery',
			'$deliver',
			'$_POST[coupon]',
			
			'0',
			'0',
			'0',
			'0',
			'0',
			'0',
			'0',
			'0',
			'0',
			'0',
			'0',
			'0',
			'0',
			'0'				
			)"); 
					
			$parent_id=mysql_insert_id();	
			
			$add_statuss = mysql_query("insert into statuses values (
			'',
			'$parent_id',
			'$laiks',		
			'0'	
			)");		
				
			
			$summa_bez_pvn_kopa = 0;
			$pvn_kopa = 0;
			$summa_ar_pvn_kopa = 0;
			
			$summa_bez_pvn = 0;
			$summa_ar_pvn = 0;
			$pvn_summa = 0;
			$kopa = 0;
						
					
			if (strtoupper(substr(PHP_OS,0,3)=='WIN'))
			{ 
				$eol="\r\n"; 
			}
			elseif (strtoupper(substr(PHP_OS,0,3)=='MAC'))
			{ 
				$eol="\r"; 
			} 
			else
			{ 
				$eol="\n"; 
			}
			
				
			$saturs_client_txt = ""; $saturs_admin_txt = ""; $saturs_client_html = ""; $saturs_admin_html = "";
			$saturs_client_txt .= "$e[135]$eol$eol";
			$saturs_admin_txt .= "";
			
			$saturs_client_html0 ="
			<table cellpadding=\"0\" cellspacing=\"2\" border=\"0\" width=\"100%\">
				<tr>
					<td valign=\"top\" align=\"left\"><img src=\"".$root_dir."images/a-medical-large.png\" alt=\"A Medical\" width=\"142\" height=\"150\" /></td>
				</tr>
				<tr>
					<td valign=\"top\" align=\"left\"><br />$e[135]<br /><br /></td>
				</tr>
			</table>
			<table cellpadding=\"5\" cellspacing=\"2\" border=\"0\" width=\"100%\">
				<tr>
					<td width=\"45%\" style=\"background: #ff6b00;text-align: left;height: 25px;color: white;font-weight: bold;\"><b>$e[50]</b></td>
					<td style=\"background: #ff6b00;text-align: left;height: 25px;color: white;font-weight: bold;\"><b>$e[55]</b></td>
					<td style=\"background: #ff6b00;text-align: left;height: 25px;color: white;font-weight: bold;\"><b>$e[57]</b></td>
					<td style=\"background: #ff6b00;text-align: left;height: 25px;color: white;font-weight: bold;\"><b>$e[52]</b></td>
					<td style=\"background: #ff6b00;text-align: left;height: 25px;color: white;font-weight: bold;\" width=\"170\"><b>$e[58]</b></td>
			</tr>";
			
			$saturs_admin_html0 ="
			<table cellpadding=\"0\" cellspacing=\"2\" border=\"0\" width=\"100%\">
				<tr>
					<td valign=\"top\" align=\"left\"><img src=\"".$root_dir."images/a-medical-large.png\" alt=\"A Medical\" width=\"142\" height=\"150\" /></td>
				</tr>
			</table>
			<table cellpadding=\"5\" cellspacing=\"2\" border=\"0\" width=\"100%\">
				<tr>
					<td width=\"45%\" style=\"background: #ff6b00;text-align: left;height: 25px;color: white;font-weight: bold;\"><b>$e[50]</b></td>
					<td style=\"background: #ff6b00;text-align: left;height: 25px;color: white;font-weight: bold;\"><b>$e[55]</b></td>
					<td style=\"background: #ff6b00;text-align: left;height: 25px;color: white;font-weight: bold;\"><b>$e[57]</b></td>
					<td style=\"background: #ff6b00;text-align: left;height: 25px;color: white;font-weight: bold;\"><b>$e[52]</b></td>
					<td style=\"background: #ff6b00;text-align: left;height: 25px;color: white;font-weight: bold;\" width=\"170\"><b>$e[58]</b></td>
			</tr>";
			$a=1;
			
			$rates = array(); $all_pvn = ""; $all_rates = array();
			$query = mysql_query("select * from rates order by name asc");
			while($mysql = mysql_fetch_array($query))
			{
				$value_id = $mysql["id"];
				$value = $mysql["name"];
				$rates[$value_id] = 0;
				$all_rates[$value_id] = $value;
			}
					
			//Pārbaudam lietotāja pirkumu skaitu
			$count_orders = 0;
			if($parbaudits == "ok")
			{
				$query = mysql_query("select * from orders where statuss = '5' and user_id = '$user_id'");
				$count_orders = mysql_num_rows($query);
			}
					
			while($grozs = mysql_fetch_array($gr))
			{
				$ite = mysql_query("select * from items where id='$grozs[parent_id]'");
				$item = mysql_fetch_array($ite);
				
				$ite1 = mysql_query("select * from persons where id='$item[person]'");
				$item1 = mysql_fetch_array($ite1);
				
				$ee = $item1["email"];
				$all_emails[$ee] =  $item1[$name_lang];
				
				$time_discount = 0;
				$add_filter = "and cats like '%*$item[parent_id]*%' and type < '3'";
				if($coupon_accept == 1)
				{
					if($coupon_type == 1)
					{
						$add_filter = "and type < '5' and type <> '3' and type <> '4'";
					}
				}				
				
				$tagad = time();
				$di = mysql_query("select * from discounts where '$tagad' >= start_time and '$tagad' <= end_time $add_filter order by value desc limit 0,1");
								
				if($disc = mysql_fetch_array($di))
				{
					if($disc["value"] > $time_discount)
					{
						
						$time_discount = $disc["value"];
						$d1 = 1;
						$d1_value = $disc["value"];
						
						if($disc["type"] == 6)
						{
							$d5 = 1;
							$d5_value = $disc["value"];
						}
					}					
				}
				
				
							
				if($item["discount"] == 2)
				{
					if($item["discount_price"] > 0)
					{
						$cena = $item["price"] - $item["discount_price"];									
					}
					else
					{
						$cena = $item["price"] - $item["price"] * $item["discount_percent"] / 100;
					}
				}
				else
				{
					$cena = $item["price"];
				
					// Ja ir piešķirta atlaide
					if($time_discount > 0 )
					{
						$cena = $cena - $cena * $time_discount / 100;
					}
				}
				
							
							
				// Ja ir lietotāja atlaide
				$cena = $cena - $cena * $user_discount / 100;							
				$cena = number_format(round($cena,2),2,".","");
							
				$item_rate = $item["rate"];
				$rate = $all_rates[$item_rate];	
				
				$cena_bez_pvn = number_format($cena/(1+$rate/100), 2, '.','');
				$summa_bez_pvn = number_format($cena * $grozs["count"]/(1+$rate/100), 2, '.','');
				$cena_ar_pvn = $cena;
				$pvn = number_format($cena/(1+$rate/100) * $rate/100, 2, '.','');
				
				
				$add_item = mysql_query("insert into ordered_items values (
				'',
				'$parent_id',
				'$item[id]',
				'$item[name_ee]',
				'$item[name_lv]',
				'$item[name_lt]',
				'$item[name_ru]',
				'$item[name_en]',
				'$item[code]',
				'$cena',
				'$grozs[count]',
				'$rate'
				)");
								
				$saturs_client_txt .= "$a. $e[50] $item[$name_lang] ($item[code])$eol";
				$saturs_client_txt .= "$e[57] $cena_bez_pvn $e[13]$eol";
				$saturs_client_txt .= "$e[52] $grozs[count] $e[14]$eol";
				$saturs_client_txt .= "$e[58] $summa_bez_pvn $e[13]$eol$eol";
				
				
				
				
				$saturs_client_html .= "
				<tr>
					<td style=\"background: #efefef;text-align: left;\" valign=\"top\"><b>$item[$name_lang]</b></div>
					<td style=\"background: #efefef;text-align: left;\" valign=\"top\">$item[code]</td>
					<td style=\"background: #efefef;text-align: left;\" valign=\"top\">$cena_bez_pvn $e[13]</td>
					<td style=\"background: #efefef;text-align: left;\" valign=\"top\">$grozs[count] $e[14]</td>
					<td style=\"background: #efefef;text-align: left;\" valign=\"top\" align=\"right\" width=\"170\">$summa_bez_pvn $e[13]</td>
				</tr>";				
				
				$summa_bez_pvn_kopa = $summa_bez_pvn_kopa + $grozs["count"] * $cena/(1 + $rate/100);
				$summa_ar_pvn = $summa_ar_pvn + $cena * $grozs["count"];
				$rates[$item_rate] = $rates[$item_rate] + $cena/(1 + $rate/100) * $rate/100 * $grozs["count"];
				$kopa = $kopa + $cena_ar_pvn * $grozs["count"];
				
				$a++;
			}	
			
			$kopa = number_format($kopa, 2, '.','');
			$pvn_summa = number_format($pvn_summa , 2, '.','');
			$summa_bez_pvn_kopa = number_format($summa_bez_pvn_kopa, 2, '.','');
			
			$pvn_html = ""; $pvn_txt = "";
			$query = mysql_query("select * from rates order by name asc");
			while($mysql = mysql_fetch_array($query))
			{
			    $value = $mysql["name"];
			    $value_id = $mysql["id"];	
			    $pvn_txt .= str_replace("*","",$e[60])." $value% ".number_format($rates[$value_id],2,".","")." ".$e[13]."$eol";	
			    $pvn_html .= "			
			    <tr>
			    	<td colspan=\"4\" style=\"background: #efefef;text-align: right;\" align=\"right\">$e[60] $value%</td>
			    	<td style=\"background: #efefef;text-align: left;\" align=\"right\" width=\"170\">".number_format($rates[$value_id],2,".","")." ".$e[13]."</td>
			    </tr>
			    ";				
			    $rates[$value] = 0;
			}
				
			$saturs_client_txt .= "***********************************$eol$eol";											
			$saturs_client_txt .= str_replace("*","",$e[59])." $summa_bez_pvn_kopa $e[13]$eol";
			$saturs_client_txt .= $pvn_txt;
			if($deliver > 0)	
			{
				$saturs_client_txt .= str_replace("*","",$e[146])." ".number_format($deliver,2,".","")." $e[13]$eol";
				$kopa = $kopa + $deliver;
			}					
			$saturs_client_txt .= str_replace("*","",$e[61])." $kopa $e[13]$eol$eol";
			
	
			
			$saturs_client_html .= "	
				<tr>
					<td colspan=\"4\" style=\"background: #efefef;text-align: right;\" align=\"right\">$e[59]</td>
					<td style=\"background: #efefef;text-align: left;\" align=\"right\" width=\"170\">$summa_bez_pvn_kopa&nbsp;$e[13]</td>
				</tr>
				$pvn_html";
				
				if($deliver > 0)
				{
					$saturs_client_html .= "
				<tr>
					<td colspan=\"4\" style=\"background: #efefef;text-align: right;\" align=\"right\">$e[146]</td>
					<td style=\"background: #efefef;text-align: left;\" width=\"170\" align=\"right\">".number_format($deliver,2,".","")."&nbsp;$e[13]</td>
				</tr>";
				
				}	
				$saturs_client_html .= "
				<tr>
					<td colspan=\"4\" style=\"background: #efefef;text-align: right;\" align=\"right\"><b>$e[61]</b></td>
					<td style=\"background: #efefef;text-align: left;\" width=\"170\" align=\"right\"><b>".number_format($kopa,2,".","")."&nbsp;$e[13]</b></td>
				</tr>";
				
				$atlaide = 0; $summa_ar_atlaidi = $kopa; $u_p = 0;
				if($_POST["points"] == 2 || $coupon_accept == 1)
				{				
					if($coupon_accept == 1)
					{
						$atlaide = round($coupon_discount / 100 * $kopa,2);
						$summa_ar_atlaidi = number_format($kopa - $atlaide,2,".","");
					}
					
					if($_POST["points"] == 2)
					{
						if($user_points < $summa_ar_atlaidi)
						{
							$summa_ar_atlaidi = number_format($summa_ar_atlaidi - $user_points,2,".","");
							$atlaide = $atlaide + $user_points;
							$u_p = $user_points;
						}
						else
						{
							
							$atlaide = $atlaide + $summa_ar_atlaidi;
							$u_p = $summa_ar_atlaidi;
							$summa_ar_atlaidi = 0.00;
						}
					}
					
					$kopa = number_format($summa_ar_atlaidi,2,".","");
					$atlaide = number_format($atlaide,2,".","");
				
				}
				
				if($atlaide == 0 && $time_discount == 0 && $user_id > 0 && $count_orders > 0)
				{
					
					$di = mysql_query("select * from discounts where id > '0' and '$tagad' >= start_time and '$tagad' <= end_time and type = '6'");
					if($disc = mysql_fetch_array($di))
					{
						$atlaide = round($disc["value"] / 100 * $summa_ar_atlaidi,2);
						$summa_ar_atlaidi = number_format($summa_ar_atlaidi - $atlaide,2,".","");
						$kopa = number_format($summa_ar_atlaidi,2,".","");
						$d5 = 1;
						$d5_value = $atlaide * 100;
					}
				}
				
				
				if($atlaide > 0)
				{					
					$saturs_client_txt .= str_replace("*","",$e[155].'|ddd|')." -$atlaide $e[13]$eol";
					$saturs_client_txt .= str_replace("*","",$e[156])." $summa_ar_atlaidi $e[13]$eol$eol";
					$saturs_client_html .= "
					<tr>
						<td colspan=\"4\" style=\"background: #efefef;text-align: right;\" align=\"right\"><b>$e[155]|ddd|</b></td>
						<td style=\"background: #efefef;text-align: left;\" width=\"170\" align=\"right\"><b>-$atlaide&nbsp;$e[13]</b></td>
					</tr>
					<tr>
						<td colspan=\"4\" style=\"background: #efefef;text-align: right;\" align=\"right\"><b>$e[156]</b></td>
						<td style=\"background: #efefef;text-align: left;\" width=\"170\" align=\"right\"><b>$summa_ar_atlaidi&nbsp;$e[13]</b></td>
					</tr>";				
				}
				$saturs_client_html .= "
			</table>
			
			<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">
				<tr>
					<td height=\"20\">&nbsp;</td>
				</tr>
			</table>
			<table cellpadding=\"5\" cellspacing=\"1\" border=\"0\" width=\"100%\">
				";
	
			$result = mysql_query("update orders set amount = '$kopa' where id='$parent_id'");
			
			//Pievienojam balvas
			$gift = 0;
			$di = mysql_query("select * from discounts where '$tagad' >= start_time and '$tagad' <= end_time and type = '5' order by value desc limit 0,1");
			if($disc = mysql_fetch_array($di))
			{				
				$start_time = mktime(0,0,0,date("n"),1,date("Y"));
				$end_time = mktime(0,0,0,date("t"),1,date("Y"));
				$query = mysql_query("select * from gifts where client_id = '$user_id' and time >= '$start_time' and time <= '$end_time'");
				if($mysql = mysql_fetch_array($query))
				{			
				}
				else
				{					
					if ($kopa > 71.14 && $kopa < 142.29)
					{
						$result = mysql_query("insert into gifts values (
						'',
						'$parent_id',
						'1',
						'$laiks',
						'$ip',
						'$user_id'
						)");
						$gift = 1;
						$gift_msg = $e[158].' - '.$e[191];
						$gift_msg_admin = $e[191];
						
						$d4 = 1;
						$d4_value = 1;
					}
					else if ($kopa >= 142.29 && $kopa < 426.86)
					{
						$result = mysql_query("insert into gifts values (
						'',
						'$parent_id',
						'2',
						'$laiks',
						'$ip',
						'$user_id'
						)");
						$gift = 2;
						$gift_msg = $e[159].' - '.$e[192];
						$gift_msg_admin = $e[192];
						
						$d4 = 1;
						$d4_value = 2;
					}
					else if ($kopa >= 426.86)
					{
						$result = mysql_query("insert into gifts values (
						'',
						'$parent_id',
						'3',
						'$laiks',
						'$ip',
						'$user_id'
						)");
						$gift = 3;
						$gift_msg = $e[160].' - '.$e[193];
						$gift_msg_admin = $e[193];
						
						$d4 = 1;
						$d4_value = 3;
					}
				}
			}
		
			//Pievienojam punktus
			if($user_id > 0)
			{
				if($_POST["points"] == 1)
				{
					
					$di = mysql_query("select * from discounts where '$tagad' >= start_time and '$tagad' <= end_time and type = '3'");
					if($disc = mysql_fetch_array($di))
					{
						$points = round($summa_bez_pvn_kopa * $disc["value"] / 100,2);
						$result = mysql_query("insert into points values (
						'',
						'$parent_id',
						'1',
						'$laiks',
						'$ip',
						'$points',
						'$user_id'
						)");
						
						$d2 = 1;
						$d2_value = $disc["value"]*100;
					}
				}
				else
				{
					$result = mysql_query("insert into points values (
					'',
					'$parent_id',
					'2',
					'$laiks',
					'$ip',
					'-$u_p',
					'$user_id'
					)");
					$d2 = 2;
					$d2_value = $atlaide*100;
				}
			}

			if($coupon_accept == 1)
			{
				$result = mysql_query("insert into coupons values (
				'',
				'$parent_id',
				'1',
				'$laiks',
				'$ip',
				'$coupon_discount',
				'$user_id'
				)");
				
			}
			
			
			
			
			$user_types = array(1=>$e[78],2=>$e[79]);
			$user_type = $_POST["person"];
			if($_POST["person"] == 2)
			{
				if($gift > 0)
				{
					
					$gifts_client_txt = "$gift_msg$eol";
					$gifts_client_html = "
				<tr>
					<td style=\"background: #efefef;text-align: left;height: 25px;color: black;	font-weight: bold;	border-bottom: 1px solid #dbbdbd;\" colspan=\"2\"><b>$e[157]</b></td>
				</tr>
				<tr>
					<td style=\"background: #ffffff;text-align: left;width: 200px;\" colspan=\"2\">$gift_msg</td>
				</tr>";
				
					$gifts_admin_txt = "Balva: $gift_msg_admin$eol";
					$gifts_admin_html = "
				<tr>
					<td style=\"background: #efefef;text-align: left;height: 25px;color: black;	font-weight: bold;	border-bottom: 1px solid #dbbdbd;\" colspan=\"2\"><b>Balva</b></td>
				</tr>
				<tr>
					<td style=\"background: #ffffff;text-align: left;width: 200px;\" colspan=\"2\"><span class=\"rrr\">$gift_msg_admin</span></td>
				</tr>";
				
					$saturs_client_txt .= "|ggg|";
					$saturs_client_html .= "|ggg|";
				}
				
				$saturs_client_txt .= "$e[77]$eol";
				$saturs_client_txt .= "$e[128]: $user_types[$user_type]$eol";
				$saturs_client_txt .= "$e[91]: $_POST[person_name]$eol";
				$saturs_client_txt .= "$e[92]: $_POST[person_code]$eol";
				$saturs_client_txt .= "$e[123]: $contract_msg$eol$eol$eol";
				
				$saturs_client_txt .= "$e[86]$eol";
				$saturs_client_txt .= "$e[87]: $_POST[person_phone]$eol";
				$saturs_client_txt .= "$e[88]: $_POST[person_email]$eol";
				$saturs_client_txt .= "$e[89]: $_POST[person_deliver]$eol$eol";	
				
				$saturs_client_txt .= "$e[90]$eol";
				$saturs_client_txt .= "$_POST[person_comments]$eol$eol";	
				
				
				$saturs_client_html .= "
				
				<tr>
					<td style=\"background: #efefef;text-align: left;height: 25px;color: black;	font-weight: bold;	border-bottom: 1px solid #dbbdbd;\" colspan=\"2\"><b>$e[77]</b></td>
				</tr>
				<tr>
					<td style=\"background: #ffffff;text-align: left;width: 200px;\">$e[128]</td>
					<td style=\"background: #ffffff;text-align: left;\">$user_types[$user_type]</td>
				</tr>
				<tr>
					<td style=\"background: #ffffff;text-align: left;width: 200px;\">$e[91]</td>
					<td style=\"background: #ffffff;text-align: left;\">$_POST[person_name]</td>
				</tr>
				<tr>
					<td style=\"background: #ffffff;text-align: left;width: 200px;\">$e[92]</td>
					<td style=\"background: #ffffff;text-align: left;\">$_POST[person_code]</td>
				</tr>
				<tr>
					<td style=\"background: #ffffff;text-align: left;width: 200px;\">$e[123]</td>
					<td style=\"background: #ffffff;text-align: left;\"><b>$contract_msg</b></td>
				</tr>
				<tr>
					<td style=\"background: #efefef;text-align: left;height: 25px;color: black;	font-weight: bold;	border-bottom: 1px solid #dbbdbd;\" colspan=\"2\"><b>$e[86]</b></td>
				</tr>
				<tr>
					<td style=\"background: #ffffff;text-align: left;width: 200px;\">$e[87]</td>
					<td style=\"background: #ffffff;text-align: left;\">$_POST[person_phone]</td>
				</tr>
				<tr>
					<td width=\"150\" style=\"background: #ffffff;text-align: left;width: 200px;\">$e[88]</td>
					<td style=\"background: #ffffff;text-align: left;\">$_POST[person_email]</td>
				</tr>
				<tr>
					<td style=\"background: #ffffff;text-align: left;width: 200px;\">$e[89]</td>
					<td style=\"background: #ffffff;text-align: left;\">$_POST[person_deliver]</td>
				</tr>
				<tr>
					<td style=\"background: #ffffff;text-align: left;width: 200px;\">$e[139]</td>
					<td style=\"background: #ffffff;text-align: left;\">$deliver_array[$delivery]</td>
				</tr>
				<tr>
					<td style=\"background: #efefef;text-align: left;height: 25px;color: black;	font-weight: bold;	border-bottom: 1px solid #dbbdbd;\" colspan=\"2\"><b>$e[90]</b></td>
				</tr>
				<tr>
					<td colspan=\"2\" style=\"background: #ffffff;text-align: left;\">$_POST[person_comments]</td>
				</tr>		
				";				
			}
			else
			{
				$saturs_client_txt .= "$e[77]$eol";
				$saturs_client_txt .= "$e[128]: $user_types[$user_type]$eol";
				$saturs_client_txt .= "$e[80]: $_POST[company_name]$eol";
				$saturs_client_txt .= "$e[81]: $_POST[company_code]$eol";
				$saturs_client_txt .= "$e[82]: $_POST[company_address]$eol";
				$saturs_client_txt .= "$e[83]: $_POST[company_bank]$eol";
				$saturs_client_txt .= "$e[85]: $_POST[company_account]$eol";
				$saturs_client_txt .= "$e[123]: $contract_msg$eol$eol";
				
				$saturs_client_txt .= "$e[86]$eol";
				$saturs_client_txt .= "$e[91]: $_POST[company_person]$eol";
				$saturs_client_txt .= "$e[138]: $_POST[company_position]$eol";
				$saturs_client_txt .= "$e[87]: $_POST[company_phone]$eol";
				$saturs_client_txt .= "$e[88]: $_POST[company_email]$eol";
				$saturs_client_txt .= "$e[89]: $_POST[company_deliver]$eol$eol";	
				
				$saturs_client_txt .= "$e[90]$eol";
				$saturs_client_txt .= "$_POST[company_comments]$eol$eol";	
				
				if($gift > 0)
				{
					$gifts_client_txt = "$gift_msg$eol";
					$gifts_client_html = "
				<tr>
					<td style=\"background: #efefef;text-align: left;height: 25px;color: black;	font-weight: bold;	border-bottom: 1px solid #dbbdbd;\" colspan=\"2\"><b>$e[157]</b></td>
				</tr>
				<tr>
					<td style=\"background: #ffffff;text-align: left;width: 200px;\" colspan=\"2\">$gift_msg</td>
				</tr>";
				
					$gifts_admin_txt = "Balva: $gift_msg_admin$eol";
					$gifts_admin_html = "
				<tr>
					<td style=\"background: #efefef;text-align: left;height: 25px;color: black;	font-weight: bold;	border-bottom: 1px solid #dbbdbd;\" colspan=\"2\"><b>Balva</b></td>
				</tr>
				<tr>
					<td style=\"background: #ffffff;text-align: left;width: 200px;\" colspan=\"2\"><span class=\"rrr\">$gift_msg_admin</span></td>
				</tr>";
				
					$saturs_client_txt .= "|ggg|";
					$saturs_client_html .= "|ggg|";
				}
				
				$saturs_client_html .= "
				<tr>
					<td style=\"background: #efefef;text-align: left;height: 25px;color: black;	font-weight: bold;	border-bottom: 1px solid #dbbdbd;\" colspan=\"2\"><b>$e[77]</b></td>
				</tr>
				<tr>
					<td style=\"background: #ffffff;text-align: left;width: 200px;\">$e[128]</td>
					<td style=\"background: #ffffff;text-align: left;\">$user_types[$user_type]</td>
				</tr>
				<tr>
					<td style=\"background: #ffffff;text-align: left;width: 200px;\">$e[80]</td>
					<td style=\"background: #ffffff;text-align: left;\">$_POST[company_name]</td>
				</tr>
				<tr>
					<td style=\"background: #ffffff;text-align: left;width: 200px;\">$e[81]</td>
					<td style=\"background: #ffffff;text-align: left;\">$_POST[company_code]</td>
				</tr>
				<tr>
					<td style=\"background: #ffffff;text-align: left;width: 200px;\">$e[82]</td>
					<td style=\"background: #ffffff;text-align: left;\">$_POST[company_address]</td>
				</tr>
				<tr>
					<td style=\"background: #ffffff;text-align: left;width: 200px;\">$e[83]</td>
					<td style=\"background: #ffffff;text-align: left;\">$_POST[company_bank]</td>
				</tr>
				<tr>
					<td style=\"background: #ffffff;text-align: left;width: 200px;\">$e[85]</td>
					<td style=\"background: #ffffff;text-align: left;\">$_POST[company_account]</td>
				</tr>
				<tr>
					<td style=\"background: #ffffff;text-align: left;width: 200px;\">$e[123]</td>
					<td style=\"background: #ffffff;text-align: left;\"><b>$contract_msg</b></td>
				</tr>
				<tr>
					<td style=\"background: #efefef;text-align: left;height: 25px;color: black;	font-weight: bold;	border-bottom: 1px solid #dbbdbd;\" colspan=\"2\"><b>$e[86]</b></td>
				</tr>
				<tr>
					<td style=\"background: #ffffff;text-align: left;width: 200px;\">$e[91]</td>
					<td style=\"background: #ffffff;text-align: left;\">$_POST[company_person]</td>
				</tr>
				<tr>
					<td style=\"background: #ffffff;text-align: left;width: 200px;\">$e[138]</td>
					<td style=\"background: #ffffff;text-align: left;\">$_POST[company_position]</td>
				</tr>
				<tr>
					<td style=\"background: #ffffff;text-align: left;width: 200px;\">$e[87]</td>
					<td style=\"background: #ffffff;text-align: left;\">$_POST[company_phone]</td>
				</tr>
				<tr>
					<td style=\"background: #ffffff;text-align: left;width: 200px;\">$e[88]</td>
					<td style=\"background: #ffffff;text-align: left;\">$_POST[company_email]</td>
				</tr>
				<tr>
					<td style=\"background: #ffffff;text-align: left;width: 200px;\">$e[89]</td>
					<td style=\"background: #ffffff;text-align: left;\">$_POST[company_deliver]</td>
				</tr>
				<tr>
					<td style=\"background: #ffffff;text-align: left;width: 200px;\">$e[139]</td>
					<td style=\"background: #ffffff;text-align: left;\">$deliver_array[$delivery]</td>
				</tr>
				<tr>
					<td style=\"background: #efefef;text-align: left;height: 25px;color: black;	font-weight: bold;	border-bottom: 1px solid #dbbdbd;\" colspan=\"2\"><b>$e[90]</b></td>
				</tr>
				<tr>
					<td colspan=\"2\" style=\"background: #ffffff;text-align: left;\">$_POST[company_comments]</td>
				</tr>		
				";	
			}
					
			$saturs_client_html .="				
			</table>";
			
			if($d1 > 0){$discount_info[] = $e[195];}
			if($d2 == 2){$discount_info[] = $e[198];}
			if($d3 > 0){$discount_info[] = $e[196];}
			if($d4 > 0){$discount_info[] = $e[197];}
			
			if(count($discount_info) > 0)
			{
			    $discount_info_text = ' ('.implode(", ",$discount_info).')';
			}
			
			$saturs_admin_html = $saturs_admin_html0.$saturs_client_html;
			$saturs_client_html = $saturs_client_html0.$saturs_client_html;
						
			$saturs_client_html = str_replace("|ggg|",$gifts_client_html,$saturs_client_html);
			$saturs_client_txt = str_replace("|ggg|",$gifts_client_txt,$saturs_client_txt);
			
			$saturs_admin_html = str_replace("|ggg|",$gifts_admin_html,$saturs_admin_html);
			$saturs_admin_txt = str_replace("|ggg|",$gifts_admin_txt,$saturs_admin_txt);
			
			$saturs_client_html = str_replace("|ddd|","",$saturs_client_html);
			$saturs_client_txt = str_replace("|ddd|","",$saturs_client_txt);
			
			$saturs_admin_html = str_replace("|ddd|",$discount_info_text,$saturs_admin_html);
			$saturs_admin_txt = str_replace("|ddd|",$discount_info_text,$saturs_admin_txt);
						
			require_once 'swift/swift_required.php';

			//Create the Transport			
			$transport = Swift_MailTransport::newInstance();		
			
			/*
			$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
			->setUsername('seesamlv@gmail.com')
			->setPassword('seesam11')
			;
			*/
	  		
			//Create the Mailer using your created Transport
			$mailer = Swift_Mailer::newInstance($transport);			
			
			
			//Create a message for admin
			//$all_emails = array();
			$admin_email = $e[34];
			$all_emails[$admin_email] = $e[35];
			//Papildus e-pasta adreses
			$add_admin_emails = explode(";",$e[199]);
			for($c = 0; $c < count($add_admin_emails); $c++)
			{
				$new_email = trim($add_admin_emails[$c]);
				if(!empty($new_email))
				{
					$all_emails[$new_email] = $new_email;
				}
			}
			$message_admin = Swift_Message::newInstance($e[137].' '.$parent_id)
			  ->setFrom(array($e[34] => $e[35]))
			  ->setTo($all_emails)
			  ->setBody($saturs_admin_txt)
			  ->addPart($saturs_admin_html, 'text/html')
			  ;			 
			$message_admin->setPriority(1);
			$message_admin->setSender($e[34]);
			$message_admin->setReturnPath($e[34]);						  		  
			//Send the message to admin
			$numSent = $mailer->send($message_admin);
				
			
			//Create a message for client
			$message_client = Swift_Message::newInstance($e[194])
			  ->setFrom(array($e[34] => $e[35]))
			  ->setTo(array($client_email => $client_name))
			  ->setBody($saturs_client_txt)
			  ->addPart($saturs_client_html, 'text/html')
			  ;			 
			$message_client->setPriority(1);
			$message_client->setSender($e[34]);
			$message_client->setReturnPath($e[34]);			
			//Send the message to client
			$numSent = $mailer->send($message_client);	
			
			/* 
			PIEVIENOJAM INFORMĀCIJU PAR ATLAIDĒM
			0 - Nav atlaides
			1 - Apjoma atlaide
			2 - Punktu uzkrāšana 1 - piešķirti punkti, 2 - izmantoti punkti
			3 - Kupona tlaide
			4 - Balvas par pirkumiem
			5 - Pirkumu skaita atlaide
			*/
			
			$update_discounts = mysql_query("update orders set 
			d1 = '$d1',	dv1 = '$d1_value',
			d2 = '$d2',	dv2 = '$d2_value',
			d3 = '$d3',	dv3 = '$d3_value',
			d4 = '$d4',	dv4 = '$d4_value',
			d5 = '$d5',	dv5 = '$d5_value',
			d6 = '$d6',	dv6 = '$d6_value',
			d7 = '$d7',	dv7 = '$d7_value'
			where id='$parent_id'");
			
			$result = mysql_query("delete from basket where session_id='$ses_id' and ip='$ip'");	
			$links = $root_dir.$_GET["lang"]."/order-ok?gift=$gift";
			
			//Lietotājs pieslēdzies
			AddStatistic($ip,$user_id,$ses_id,$url,'',8);
			$result = mysql_query("delete from user_statistic where session_id='$ses_id' and ip='$ip'");
			
			header("Location: $links");
			exit;
		}
	}
	
	//Lietotājs pieslēdzies
	AddStatistic($ip,$user_id,$ses_id,$url,$error_msg,7);
}
else
{
	//Lietotājs pieslēdzies
	AddStatistic($ip,$user_id,$ses_id,$url,'',6);
	if($parbaudits == "ok")
	{
		$_POST["person"] = $uses["person"];
		$_POST["company_name"] =  $uses["company_name"];
		$_POST["company_code"] =  $uses["company_code"];
		$_POST["company_address"] =  $uses["company_address"];
		$_POST["company_bank"] =  $uses["company_bank"];
		$_POST["company_account"] =  $uses["company_account"];
		$_POST["company_phone"] =  $uses["company_phone"];
		$_POST["company_email"] =  $uses["email"];
		$_POST["company_deliver"] =  $uses["company_deliver"];
		$_POST["company_comments"] =  "";
		
		$_POST["company_position"] =  $uses["company_position"];
		$_POST["company_person"] =  $uses["company_person"];
		
		$_POST["person_name"] =  $uses["person_name"];
		$_POST["person_code"] =  $uses["person_code"];
		$_POST["person_phone"] =  $uses["person_phone"];
		$_POST["person_email"] =  $uses["email"];
		$_POST["person_deliver"] =  $uses["person_deliver"];
		$_POST["person_comments"] =  "";
		$_POST["c_deliver"] =  0;
		$_POST["p_deliver"] =  0;
	}
	else
	{
		$_POST["company_position"] =  "";
		$_POST["company_person"] =  "";
		$_POST["person"] = 1;
		$_POST["company_name"] = "";
		$_POST["company_code"] = "";
		$_POST["company_address"] = "";
		$_POST["company_bank"] = "";
		$_POST["company_account"] = "";
		$_POST["company_phone"] = "";
		$_POST["company_email"] = "";
		$_POST["company_deliver"] = "";
		$_POST["company_comments"] = "";
		
		$_POST["person_name"] = "";
		$_POST["person_code"] = "";
		$_POST["person_phone"] = "";
		$_POST["person_email"] = "";
		$_POST["person_deliver"] = "";
		$_POST["person_comments"] = "";
		$_POST["c_deliver"] =  0;
		$_POST["p_deliver"] =  0;
	}
	$deliver = 0;
	$_POST["points"] = 1;
	$_POST["coupon"] = "";
}
?>
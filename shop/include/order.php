<div id="text-top"></div>
<div id="text">
		
	<div id="text-container">
		<h1><?php echo $e[65]; ?></h1>
		<div id="items">
			
			<?php
			
			if($_GET["type"] == 1 && $user_id == 0)
			{
			// Ja lietotājs nav reģistrējies un nav izvēlējies pirkuma noformēšanu bez reģistrācijas
			?>
			<div class="order-type">
				<div><?php echo $e[66]; ?></div>
				<form method="post" action="<?php echo $root_dir.$_GET["lang"].'/login'; ?>" id="login">
					<input type="hidden" value="order" name="backlink" />
					<div><label for="login"><?php echo $e[69]; ?></label><input type="text" name="email" class="login-input" /></div>
					<div><label for="password"><?php echo $e[68]; ?></label><input type="password" name="password" class="login-input" /></div>
					<div><label for="submit"></label><input type="submit" class="login-submit" name="submit" value="<?php echo $e[70]; ?>" /> <a href="<?php echo $root_dir.$_GET["lang"]."/remember"; ?>" title="<?php echo $e[71]; ?>"><?php echo $e[71]; ?></a></div>
				</form>
			</div>
			
			<div class="order-type">
				<div><?php echo $e[67]; ?></div>
				<form method="post" action="<?php echo $root_dir.$_GET["lang"].'/login'; ?>" id="without-login">
					<div style="position: relative;">
						<input type="button" class="login-submit1" name="submit" value="<?php echo $e[72]; ?>" onclick="go('<?php echo $root_dir.$_GET["lang"].'/register'; ?>');" />
						<div class="benefits"><a href="javascript:void(0);" onmouseover="ShowBenefits()" onmouseout="HideBenefits()"><?php echo $e[150]; ?></a></div>
						<input type="button" class="login-submit1" name="submit" value="<?php echo $e[73]; ?>" onclick="go('<?php echo $root_dir.$_GET["lang"].'/order?type=2'; ?>');" />
						<div id="benefits"><?php echo $e[151]; ?></div>
					</div>
				</form>
			</div>
			<?php
			}
			else if($_GET["type"] == 2 || $user_id > 0)
			{
				// Pirkuma noformēšana bez reģistrācijas - nereģistrētiem lietotājiem
				echo '<div class="text-title">'.$e[74].'</div>';
				$bb = mysqli_query($result_db,"select * from basket where ip = '$ip' and session_id = '$ses_id' and user_id = '$user_id' order by id asc");
				$c = mysqli_num_rows($bb);
				$a = 1;
				$sum = 0;
				$count = 0;
				$summa_bez_pvn = 0;
				$summa_ar_pvn = 0;
				$pvn = 0;
				
				$rates = array(); $all_pvn = ""; $all_rates = array();
				$query = mysqli_query($result_db,"select * from rates order by name asc");
				while($mysql = mysqli_fetch_array($query))
				{
					$value_id = $mysql["id"];
					$value = $mysql["name"];
					$rates[$value_id] = 0;
					$all_rates[$value_id] = $value;
				}
				
				
				if($c > 0)
				{
					echo '
					<table cellpadding="5" cellspacing="2" border="0" width="100%">
						<tr>
							<td class="basket-th" width="45%">'.$e[50].'</td>
							<td class="basket-th">'.$e[55].'</td>
							<td class="basket-th">'.$e[57].'</td>
							<td class="basket-th">'.$e[52].'</td>
							<td class="basket-th">'.$e[58].'</td>
						</tr>';
					
					while($basket = mysqli_fetch_array($bb))
					{
						$it = mysqli_query($result_db,"select * from items where id='$basket[parent_id]'");
						$ite = mysqli_fetch_array($it);
						
						$tagad = time();
						$di = mysqli_query($result_db,"select * from discounts where '$tagad' >= start_time and '$tagad' <= end_time and cats like '%*$ite[parent_id]*%' and type < '3' order by value desc limit 0,1");
						$time_discount = 0;
						if($disc = mysqli_fetch_array($di))
						{
							$time_discount = $disc["value"];
						}
								
						if($ite["discount"] == 2)
						{
							if($ite["discount_price"] > 0)
							{
							    $price = $ite["price"] - $ite["discount_price"];									
							}
							else
							{
							    $price = $ite["price"] - $ite["price"] * $ite["discount_percent"] / 100;
							}
						}
						else
						{
							$price = $ite["price"];
							// Ja ir piešķirta atlaide
							if($time_discount > 0 && $time_discount > $ite["discount_percent"])
							{
								$price = $price - $price * $time_discount / 100;
							}
						}
						
						// Ja ir lietotāja atlaide
						$price = $price - $price * $user_discount / 100;							
						$price = number_format(round($price,2),2,".","");
							
						$count = $count + $basket["count"];	
						
						echo '
						<tr>
							<td class="basket-td" width="45%">
								<a href="'.$root_dir.$_GET["lang"].'/'.$ite[$url_lang].'" title="'.$ite[$name_lang].'" class="basket-name">'.$ite[$name_lang].'</a>						
							</td>';
									
						$item_rate = $ite["rate"];
						$rate = $all_rates[$item_rate];				
						$cena_bez_pvn = number_format($price/(1 + $rate/100),2,".","");
						$summa_bez_pvn = $summa_bez_pvn + $basket["count"] * $price/(1 + $rate/100);
						$summa_ar_pvn = $summa_ar_pvn + $price * $basket["count"];
						$sum = number_format($price/(1 + $rate/100) *  $basket["count"],2,".","");
						$rates[$item_rate] = $rates[$item_rate] + $price/(1 + $rate/100) * $rate/100 * $basket["count"];
						
						
							
						echo '
							<td class="basket-td">'.$ite["code"].'</td>
							<td class="basket-td">'.$cena_bez_pvn.' '.$e[13].'</td>
							<td class="basket-td">'.$basket["count"].' '.$e[14].'</td>
							<td class="basket-td">'.$sum.' '.$e[13].'</td>
						</tr>';					
						$a++;				
					}
					
					$summa_ar_pvn = number_format($summa_ar_pvn,2,".","");
					$summa_bez_pvn = number_format($summa_bez_pvn,2,".","");
					
					echo '
						<tr>
							<td colspan="4" class="basket-td-right">'.$e[59].'</td>
							<td class="basket-total">'.$summa_bez_pvn.' '.$e[13].'</td>
						</tr>
						';
						
					$query = mysqli_query($result_db,"select * from rates order by name asc");
					while($mysql = mysqli_fetch_array($query))
					{
						$value = $mysql["name"];
						$value_id = $mysql["id"];
						echo  '
						<tr>
							<td colspan="4" class="basket-td-right">'.$e[60].' '.$value.'%</td>
							<td class="basket-total">'.number_format($rates[$value_id],2,".","").' '.$e[13].'</td>
						</tr>
						';
						$rates[$value] = 0;
					}
					
					$c_cl = '';
					if($_POST["person"] == 1)
					{	
						if($_POST["c_deliver"] < 3)
						{
							$c_cl = ' class="not-visible"';
						}
					}
					else
					{	
						if($_POST["p_deliver"] < 3)
						{
							$c_cl = ' class="not-visible"';
						}
					}
					
					$summa_ar_pvn_piegade = $summa_ar_pvn + $deliver;
					echo '
							<tr id="delivery"'.$c_cl.'>
								<td colspan="4" class="basket-td-right">'.$e[146].'</td>
								<td class="basket-total" id="delivery_value">'.number_format($deliver,2,".","").' '.$e[13].'</td>
							</tr>';
						
					echo '
						<tr>
							<td colspan="4" class="basket-td-right">'.$e[61].'</td>
							<td class="basket-total"><span id="basket-total">'.number_format($summa_ar_pvn_piegade,2,".","").'</span> '.$e[13].'</td>
						</tr>';
					
					$atlaide  = 0; $c_d = 0; $summa_ar_atlaidi = 0;
					if($coupon_type > 0 && $coupon_accept == 1)
					{
						$atlaide = round($coupon_discount/100 * $summa_ar_pvn_piegade,2); $c_d = $atlaide; 
						$summa_ar_pvn_piegade = $summa_ar_pvn_piegade - $atlaide;
						$summa_ar_atlaidi = $summa_ar_pvn_piegade;
					}
					
					if($_POST["points"] > 1)
					{
						if($user_points < $summa_ar_pvn_piegade)
						{
							$summa_ar_atlaidi = $summa_ar_pvn_piegade - $user_points;
							$atlaide = $atlaide + $user_points;
						}
						else
						{
							$atlaide = $summa_ar_pvn_piegade;
							$summa_ar_atlaidi = 0.00;
						}
					}
					
					$c_cl = '';
					if($_POST["points"] == 1 && $coupon_accept == 0)
					{
						$c_cl = ' class="not-visible"';
					}
										
					echo '
						<tr id="discount-1"'.$c_cl.'>
							<td colspan="4" class="basket-td-right">'.$e[155].'</td>
							<td class="basket-total"><span id="discount-value">-'.number_format($atlaide,2,".","").'</span> '.$e[13].'</td>
						</tr>
						<tr id="discount-2"'.$c_cl.'>
							<td colspan="4" class="basket-td-right">'.$e[156].'</td>
							<td class="basket-total"><span id="basket-total-discount">'.number_format($summa_ar_atlaidi,2,".","").'</span> '.$e[13].'</td>
						</tr>';
						
						
						
					echo '
					</table>';
					
					if($summa_ar_pvn >= $e[205])
					{
						$query = mysqli_query($result_db,"select * from content where template = '3' and lang = '$_GET[lang]'");
						$mysql = mysqli_fetch_array($query);
	
						echo '
						<form name="createorder" method="post" action="#action">
						<input type="hidden" name="total" value="'.$summa_ar_pvn_piegade.'" id="total" />
						<input type="hidden" name="default-total" value="'.$summa_ar_pvn.'" id="default-total" />
						
						<input type="hidden" name="user-points" value="'.$user_points.'" id="user-points" />
						<input type="hidden" name="user-coupon" value="0" id="user-coupon" />';
						if(count($error) > 0)
						{
							if(isset($error[2]))
							{
								echo '
								<div id="error">
									<a name="action"></a>
									'.$e[183].'
								</div>';
							}
							
							if(isset($error[3]))
							{
								echo '
								<div id="error">
									<a name="action"></a>
									'.$e[40].'
								</div>';
							}
							
							if(isset($error[1]))
							{
								echo '
								<div id="error">
									<a name="action"></a>
									'.$e[94].'
								</div>';
							}
							
						}
						
						if($user_points > 0)
						{
							echo '
							<table cellpadding="5" cellspacing="2" border="0" width="100%">
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td class="basket-th-1">'.$e[153].'</td>
								</tr>
								<tr>
									<td class="basket-td-1">'.$e[152].'</td>
								</tr>
								<tr>
									<td class="basket-td-left"><span class="user-points">'.number_format($user_points,2,".","").' '.$e[13].'</span>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="points" onclick="ChangeDiscount();"'; if($_POST["points"] == 2) {echo 'checked="checked"';} echo ' /> '.$e[154].' </td>
								</tr>
							</table>';
						}
						if($coupon_discount > 0 || $coupon_discount1 > 0)
						{
							if($coupon_accept == 1)
							{
								$cccl = 'coupon-tasks-visible';
							}
							else
							{
								$cccl = 'coupon-tasks';
							}
							echo '
							<table cellpadding="5" cellspacing="2" border="0" width="100%">
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td class="basket-th-1">'.$e[181].'</td>
								</tr>
								<tr>
									<td class="basket-td-1" style="color:red;"><b>'.$e[182].'</b></td>
								</tr>
								<tr>
									<td class="basket-td-left">
										<input type="text" name="coupon" class="order-input-4" id="coupon" value="'.$_POST["coupon"].'" /> 
										<input type="button" value="'.$e[186].'" class="coupon-button " name="coupon-confirm" onclick="ChangeCoupon();" />
										<div id="total-coupon" class="'.$cccl.'">'.$e[187].' <span id="total-coupon-value">'.number_format($c_d,2,".","").'</span> '.$e[13].'</div>
										<div id="total-coupon-error" class="coupon-tasks">'.$e[183].'</div>
									</td>
								</tr>
							</table>';
						}
						else
						{
							echo '<input type="hidden" name="coupon" class="order-input-4" id="coupon" value="'.$_POST["coupon"].'" />';
						}
						echo '
							<table cellpadding="5" cellspacing="2" border="0">
								<tr>
									<td>
										<br />
										<input type="radio" name="person" value="1" ';	if($_POST["person"] == 1) echo 'checked="checked"'; echo ' onclick="ShowElement(\'1\');" /> '.$e[78].'&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="radio" name="person" value="2" ';	if($_POST["person"] == 2) echo 'checked="checked"'; echo ' onclick="ShowElement(\'2\');" /> '.$e[79].'
									</td>
								</tr>
							</table>
							
							<div id="order-company"'; if($_POST["person"] == 2) echo ' class="not-visible"'; echo '>
								<table cellpadding="5" cellspacing="2" border="0" width="100%">
									<tr>
										<td class="basket-th-1" colspan="2">'.$e[77].'</td>
									</tr>
									<tr>
										<td class="basket-td-left">'.$e[80].'</td>
										<td class="basket-td-1"><input type="text" class="order-input-1"  name="company_name" value="'.$_POST["company_name"].'" /></td>
									</tr>
									<tr>
										<td class="basket-td-left">'.$e[81].'</td>
										<td class="basket-td-1"><input type="text" class="order-input-1"  name="company_code" value="'.$_POST["company_code"].'" /></td>
									</tr>
									<tr>
										<td class="basket-td-left">'.$e[82].'</td>
										<td class="basket-td-1"><input type="text" class="order-input-1"  name="company_address" value="'.$_POST["company_address"].'" /></td>
									</tr>
									<tr>
										<td class="basket-td-left">'.$e[83].'</td>
										<td class="basket-td-1"><input type="text" class="order-input-2"  name="company_bank" value="'.$_POST["company_bank"].'" /></td>
									</tr>
									<tr>
										<td class="basket-td-left">'.$e[85].'</td>
										<td class="basket-td-1"><input type="text" class="order-input-2"  name="company_account" value="'.$_POST["company_account"].'" /></td>
									</tr>
									<tr>
										<td class="basket-th-1" colspan="2">'.$e[86].'</td>
									</tr>
									<tr>
			    						<td class="basket-td-left">'.$e[91].'</td>
			    						<td class="basket-td-1"><input type="text" class="order-input-2"  name="company_person" value="'.$_POST["company_person"].'" /></td>
			    					</tr>
			    					<tr>			
			    						<td class="basket-td-left">'.$e[138].'</td>
			    						<td class="basket-td-1"><input type="text" class="order-input-2"  name="company_position" value="'.$_POST["company_position"].'" /></td>
			    					</tr>
									<tr>
										<td class="basket-td-left">'.$e[87].'</td>
										<td class="basket-td-1"><input type="text" class="order-input-2"  name="company_phone" value="'.$_POST["company_phone"].'" /></td>
									</tr>
									<tr>
										<td class="basket-td-left">'.$e[88].'</td>
										<td class="basket-td-1"><input type="text" class="order-input-2"  name="company_email" value="'.$_POST["company_email"].'" /></td>
									</tr>
									<tr>
										<td class="basket-td-left">'.$e[89].'</td>
										<td class="basket-td1-"><input type="text" class="order-input-1"  name="company_deliver" value="'.$_POST["company_deliver"].'" /></td>
									</tr>
									<tr>
							 			<td class="basket-td-left">'.$e[139].'</td>
							 			<td class="basket-td1-">
							 				<select name="c_deliver" onchange="ChangeDeliver(\'c_deliver\')" id="c_deliver">
							 					<option value="0"></option>';
							 					
							 					if($summa_ar_pvn < 71.14)
							 					{
							 						echo '
							 						<option value="1"'; if($_POST["c_deliver"] == 1) echo ' selected="selected"'; echo '>'.$e[140].'</option>
							 						<option value="3"'; if($_POST["c_deliver"] == 3) echo ' selected="selected"'; echo '>'.$e[142].'</option>
							 						<option value="4"'; if($_POST["c_deliver"] == 4) echo ' selected="selected"'; echo '>'.$e[143].'</option>
							 						';
							 					}
							 					else
							 					{
							 						echo '
							 						<option value="1"'; if($_POST["c_deliver"] == 1) echo ' selected="selected"'; echo '>'.$e[140].'</option>
							 						<option value="2"'; if($_POST["c_deliver"] == 2) echo ' selected="selected"'; echo '>'.$e[141].'</option>
							 						';
							 					}
							 					
							 					echo '
							 				</select>
							 			</td>
							 		</tr>
									<tr>
										<td class="basket-th-1" colspan="2">'.$e[90].'</td>
									</tr>
								</table>
								<table cellpadding="0" cellspacing="2" border="0" width="100%">
									<tr>
										<td class="basket-td-1" colspan="2"><textarea class="order-textarea"  name="company_comments" rows="5" />'.$_POST["company_comments"].'</textarea></td>
									</tr>									
								</table>
							</div>
							
							<div id="order-person"'; if($_POST["person"] == 1) echo ' class="not-visible"'; echo '>
								<table cellpadding="5" cellspacing="2" border="0" width="100%">
							 		<tr>
							 			<td class="basket-th-1" colspan="2">'.$e[77].'</td>
							 		</tr>
							 		<tr>
							 			<td class="basket-td-left">'.$e[91].'</td>
							 			<td class="basket-td-1"><input type="text" class="order-input-1"  name="person_name" value="'.$_POST["person_name"].'" /></td>
							 		</tr>
							 		<tr>
							 			<td class="basket-td-left">'.$e[92].'</td>
							 			<td class="basket-td-1"><input type="text" class="order-input-1"  name="person_code" value="'.$_POST["person_code"].'" /></td>
							 		</tr>
							 		
							 		<tr>
							 			<td class="basket-th-1" colspan="2">'.$e[86].'</td>
							 		</tr>
							 		<tr>
							 			<td class="basket-td-left">'.$e[87].'</td>
							 			<td class="basket-td-1"><input type="text" class="order-input-2"  name="person_phone" value="'.$_POST["person_phone"].'" /></td>
							 		</tr>
							 		<tr>
							 			<td class="basket-td-left">'.$e[88].'</td>
							 			<td class="basket-td-1"><input type="text" class="order-input-2"  name="person_email" value="'.$_POST["person_email"].'" /></td>
							 		</tr>
							 		<tr>
							 			<td class="basket-td-left">'.$e[89].'</td>
							 			<td class="basket-td1-"><input type="text" class="order-input-1"  name="person_deliver" value="'.$_POST["person_deliver"].'" /></td>
							 		</tr>
							 		<tr>
							 			<td class="basket-td-left">'.$e[139].'</td>
							 			<td class="basket-td1-">
							 				<select name="p_deliver" onchange="ChangeDeliver(\'p_deliver\')" id="p_deliver">
							 					<option value="0"></option>';
							 					
							 					if($summa_ar_pvn < $e[204])
							 					{
							 						echo '
							 						<option value="1"'; if($_POST["p_deliver"] == 1) echo ' selected="selected"'; echo '>'.$e[140].'</option>
							 						<option value="3"'; if($_POST["p_deliver"] == 3) echo ' selected="selected"'; echo '>'.$e[142].'</option>
							 						<option value="4"'; if($_POST["p_deliver"] == 4) echo ' selected="selected"'; echo '>'.$e[143].'</option>
							 						';
							 					}
							 					else
							 					{
							 						echo '
							 						<option value="1"'; if($_POST["p_deliver"] == 1) echo ' selected="selected"'; echo '>'.$e[140].'</option>
							 						<option value="2"'; if($_POST["p_deliver"] == 2) echo ' selected="selected"'; echo '>'.$e[141].'</option>
							 						';
							 					}
							 					
							 					echo '
							 				</select>
							 			</td>
							 		</tr>
							 		<tr>
							 			<td class="basket-th-1" colspan="2">'.$e[90].'</td>
							 		</tr>
								</table>
								<table cellpadding="0" cellspacing="2" border="0" width="100%">
							 		<tr>
							 			<td class="basket-td-1" colspan="2"><textarea class="order-textarea"  name="person_comments" rows="5" />'.$_POST["person_comments"].'</textarea></td>
							 		</tr>							 		
								</table>
							</div>
							
							<div class="order-continue-left">
								<input type="button" value="'.$e[76].'" class="order-continue" onclick="go(\''.$root_dir.$_GET["lang"].'/'.$mysql["url"].'\');"> 
								<input type="submit" value="'.$e[75].'" class="order-continue" name="order-confirm">
							</div>
						</form>';
					}
					else
					{
						echo '<div id="message-text"></div>';
						echo '<div class="order-continue-left"><input type="button" value="'.$e[75].'" class="order-confirm" onclick="ShowTextMessage(\''.$e[63].'\');"></div>';
						
					}
				}	
				else
				{
					echo $e[47];
				}
			
			}
			else
			{
				// Pirkuma noformēšana reģistrētiem lietotājiem
				
			}
			?>
			
		</div>
	</div>
	<div class="clear"></div>
	
</div>
<div id="text-bottom"></div>
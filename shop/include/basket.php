<div id="text-top"></div>
<div id="text">
		
	<div id="text-container">
		<h1><?php echo $e[46]; ?></h1>
		<div id="items">
			
			<?php
		
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
					$time_discount = 0;
					$di = mysqli_query($result_db,"select * from discounts where '$tagad' >= start_time and '$tagad' <= end_time and cats like '%*$ite[parent_id]*%' and type < '3' order by value desc limit 0,1");
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
						if($time_discount > 0)
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
							<a href="'.$root_dir.$_GET["lang"].'/d-basket?item_id='.$basket["id"].'" class="basket-delete"><img src="'.$root_dir.'include/images/trash.png" border="0" width="15" height="21" align="top" /></a>
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
						<td class="basket-td">
							<form action="'.$root_dir.$_GET["lang"].'/'.$_GET["url"].'?item_id='.$basket["id"].'" style="margin:0px;" method="post">
								<input type="text" name="quantity" value="'.$basket["count"].'" class="basket-quantity"> '.$e[14].' <input type="submit" value="'.$e[64].'" class="basket-refresh" name="change-basket" />
							</form>							
						</td>
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
					
				echo '
					<tr>
						<td colspan="4" class="basket-td-right">'.$e[61].'</td>
						<td class="basket-total">'.$summa_ar_pvn.' '.$e[13].'</td>
					</tr>
				</table>';
				
				if($summa_ar_pvn >= $e[205])
				{
					echo '<div class="order-continue"><input type="button" value="'.$e[62].'" class="order-continue" onclick="go(\''.$root_dir.$_GET["lang"].'/order\');"></div>';
				}
				else
				{
					echo '<div id="message-text"></div>';
					echo '<div class="order-continue"><input type="button" value="'.$e[62].'" class="order-continue" onclick="ShowTextMessage(\''.$e[63].'\');"></div>';
					
				}
			}	
			else
			{
				echo $e[47];
			}
			?>
			
		</div>
	</div>
	<div class="clear"></div>
	
</div>
<div id="text-bottom"></div>
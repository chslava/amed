<div id="text-top"></div>
<div id="text">
		
	<div id="text-container"><?php
			$query = mysql_query("select * from content where template = '1' and lang = '$_GET[lang]'");
			$mysql = mysql_fetch_array($query);
			mysql_free_result($query);
			$links = $root_dir.$_GET["lang"]."/$mysql[url]";
			echo '<a href="'.$links.'" title="'.$mysql["name"].'" id="to-basket">'.$e[190].'</a>';
			?>
		<?php
		if(isset($_GET["id"]))
		{
		?>
			<h1><?php echo $e[176].' '.$_GET["id"]; ?></h1>
		<?php
		}
		else
		{
		?>
			<h1><?php echo $e[161]; ?></h1>
		<?php
		}
		?>
		<div id="items">
			
		<?php	
		if(isset($_GET["id"]))
		{
			$query = mysql_query("select * from orders where user_id = '$user_id' and id= '$_GET[id]'");
			if($mysql = mysql_fetch_array($query))
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
				
				$bb = mysql_query("select * from ordered_items where parent_id = '$mysql[id]' order by id asc");
				$c = mysql_num_rows($bb);
				$a = 1;
				$sum = 0;
				$count = 0;
				$summa_bez_pvn = 0;
				$summa_ar_pvn = 0;
				$pvn = 0;
				
				$rates = array(); $all_pvn = ""; $all_rates = array();
				$query1 = mysql_query("select * from ordered_items where parent_id='$mysql[id]' group by rate order by rate asc");
				while($mysql1 = mysql_fetch_array($query1))
				{
					$value_id = $mysql1["rate"];
					$value = $mysql1["rate"];
					$rates[$value_id] = 0;
					$all_rates[$value_id] = $value;
				}
			
				while($basket = mysql_fetch_array($bb))
				{
					$it = mysql_query("select * from items where id='$basket[item_id]'");
					$ite = mysql_fetch_array($it);
											
					$price = $basket["price"];						
					$count = $count + $basket["count"];	
					
					echo '
					<tr>
						<td class="basket-td" width="45%">							
							<a href="'.$root_dir.$_GET["lang"].'/'.$ite[$url_lang].'" title="'.$basket[$name_lang].'" class="basket-name">'.$basket[$name_lang].'</a>						
						</td>';
								
					$item_rate = $basket["rate"];
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
					
				$query1 = mysql_query("select * from ordered_items where parent_id='$mysql[id]' group by rate order by rate asc");
				while($mysql1 = mysql_fetch_array($query1))
				{
					$value = $mysql1["rate"];
					$value_id = $mysql1["rate"];
					echo  '
					<tr>
						<td colspan="4" class="basket-td-right">'.$e[60].' '.$value.'%</td>
						<td class="basket-total">'.number_format($rates[$value_id],2,".","").' '.$e[13].'</td>
					</tr>
					';
					$rates[$value] = 0;
				}
				if($mysql["deliver"] > 0)
				{
					$summa_ar_pvn = $summa_ar_pvn + $mysql["deliver_total"];	
					echo '
					<tr>
						<td colspan="4" class="basket-td-right">'.$e[146].'</td>
						<td class="basket-total" id="delivery_value">'.$mysql["deliver_total"].' '.$e[13].'</td>
					</tr>
					';
				}									
				echo '
					<tr>
						<td colspan="4" class="basket-td-right">'.$e[61].'</td>
						<td class="basket-total">'.number_format($summa_ar_pvn,2,".","").' '.$e[13].'</td>
					</tr>';
					
				$discount = 0;
				$kopa = $summa_ar_pvn;
				$query2 = mysql_query("select * from points where type = '2' and order_id = '$mysql[id]'");
				if($mysql2 = mysql_fetch_array($query2))
				{
				    $discount = $discount - $mysql2["value"];
				}
				
				$query2 = mysql_query("select * from coupons where order_id = '$mysql[id]'");
				if($mysql2 = mysql_fetch_array($query2))
				{
				    $discount = $discount + $kopa * $mysql2["value"]/100;
				}
				
				if($mysql["d5"] == 1)
				{
					$discount = $discount + $mysql["dv5"] / 100;
				}
				
				$kopa = $kopa - $discount;
								
				if($discount > 0)
				{
					echo '
						<tr>
							<td colspan="4" class="basket-td-right">'.$e[155].'</td>
				   			<td class="basket-total">-'.number_format($discount,2,".","").' '.$e[13].'</td>
						</tr>
						<tr>
				    		<td colspan="4" class="basket-td-right">'.$e[156].'</td>
				  			<td class="basket-total">'.number_format($kopa,2,".","").' '.$e[13].'</td>
						</tr>';
				}
				
				echo '
				</table>
				<div class="order-continue">
					<input type="button" value="'.$e[10].'" class="order-continue" onclick="go(\''.$root_dir.$_GET["lang"].'/my-orders\');">';
					
					if($mysql["statuss"] == 5)
					{
					echo '
					<input type="button" value="'.$e[177].'" class="order-continue" onclick="go(\''.$root_dir.$_GET["lang"].'/repeat-order?id='.$mysql["id"].'\');">
					';
					}
					
					echo '
				</div>';
				
				
			}
			else
			{
				echo '<div id="error">'.$e[175].'</div>';
			}
		}
		else
		{	
			$query = mysql_query("select * from orders where user_id = '$user_id' order by time desc");
			$count = mysql_num_rows($query);
			if($count > 0)
			{
				echo '
				<table cellpadding="0" cellspacing="2" border="0" width="100%">
				    <tr>
				    	<td class="order-th">'.$e[164].'</td>
				    	<td class="order-th" width="50%">'.$e[165].'</td>
				    	<td class="order-th">'.$e[166].'</td>
				    	<td class="order-th">'.$e[180].'</td>
				    	<td class="order-th">'.$e[167].'</td>
				    </tr>';
					
				while($mysql = mysql_fetch_array($query))
				{
					$query1 = mysql_query("select * from points where order_id = '$mysql[id]' and type = '1'");
					if($mysql1 = mysql_fetch_array($query1))
					{
						$points = $mysql1["value"];
					}
					else
					{
						$points = 0.00;
					}
					$statuss_text = array(0 => $e[168], 1 => $e[169], 2 => $e[170], 3 => $e[171], 4 => $e[172], 5 => $e[173], 6 => $e[174]);
					$stat = $mysql["statuss"];
					
					echo '
					<tr onmouseover="this.style.backgroundColor=\'#ffffff\'" onmouseout="this.style.backgroundColor=\'\'" class="order-tr">
						<td class="orders-td"><a href="?id='.$mysql["id"].'" title="'.$e[163].' ID-'.$mysql["id"].'" class="order-name">'.$mysql["id"].'</a></td>
						<td class="orders-td" width="50%"><a href="?id='.$mysql["id"].'" title="'.$e[163].' ID-'.$mysql["id"].'" class="order-name">'.date("d.m.Y H:i:s",$mysql["time"]).'</a></td>
						<td class="orders-td"><a href="?id='.$mysql["id"].'" title="'.$e[163].' ID-'.$mysql["id"].'" class="order-name">'.$mysql["amount"].'&nbsp;'.$e[13].'</a></td>
						<td class="orders-td"><a href="?id='.$mysql["id"].'" title="'.$e[163].' ID-'.$mysql["id"].'" class="order-name">'.$points.'&nbsp;'.$e[13].'</a></td>
						<td class="orders-td"><a href="?id='.$mysql["id"].'" title="'.$e[163].' ID-'.$mysql["id"].'" class="order-name">'.str_replace(" ","&nbsp;",$statuss_text[$stat]).'</a></td>
					</tr>';
			
				}
				echo '				
				</table>';
			}
			else
			{
				echo '<div id="error">'.$e[162].'</div>';
			}
		}		
		?>
		<div id="order-menu">
			<a href="<?php echo $root_dir.$_GET["lang"]; ?>/my-data"><?php echo $e[129]; ?></a>&nbsp;&nbsp;&nbsp;
			<a href="<?php echo $root_dir.$_GET["lang"]; ?>/my-orders"><?php echo $e[161]; ?></a>&nbsp;&nbsp;&nbsp;
			<a href="<?php echo $root_dir.$_GET["lang"]; ?>/logout"><?php echo $e[130]; ?></a>
		</div>
		</div>
	</div>
	<div class="clear"></div>
	
</div>
<div id="text-bottom"></div>
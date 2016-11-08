<?php global $result_db; ?>
<div id="content-top"></div>
<div id="content">

	<div id="categories">
		<ul><?php require_once("include/categories.php"); ?></ul>
		<?php

		if($_SESSION["t"] == 1)
		{
			if($parbaudits == "ok")
			{
				echo '
				<div id="user-login">
					<div class="user-login-title">'.$e[128].': '.$lietotajs.'</div>
					<div style="text-align:center;">
						<a href="'.$root_dir.$_GET["lang"].'/my-data">'.$e[129].'</a>
						<a href="'.$root_dir.$_GET["lang"].'/my-orders">'.$e[161].'</a>
						<a href="'.$root_dir.$_GET["lang"].'/logout">'.$e[130].'</a>
					</div>
					<div class="clear"></div>
				</div>
				';
			}
			else
			{
				echo '
				<div id="user-login">
					<div class="user-login-title">'.$e[66].'</div>
					<form method="post" action="'.$root_dir.$_GET["lang"].'/login">
						<div><label for="login">'.$e[69].'</label><input type="text" name="email" class="user-login-input" /></div>
						<div><label for="password">'.$e[68].'</label><input type="password" name="password" class="user-login-input" /></div>
						<div><input type="submit" class="user-login-submit" name="submit" value="'.$e[70].'" /></div>
						<div class="ahref"><a href="'.$root_dir.$_GET["lang"].'/remember" title="'.$e[71].'">'.$e[71].'</a> <a href="'.$root_dir.$_GET["lang"].'/register" title="'.$e[72].'">'.$e[72].'</a></div>
					</form>
					<div class="clear"></div>
				</div>
				';
			}
		}
		?>
	</div>
	<div id="item-container">

		<div id="search-container">

				<form method="get" action="" name="search" id="search-form">
					<div>
						<input type="text" name="search" class="search-input" value="<?php echo $_GET["search"]; ?>" /> <input type="submit" name="search-submit" class="search-button" value="<?php echo $e[30]; ?>" />
					</div>
					<div class="clear"></div>
					<?php if($_SESSION['industry'] == 2){?>

					<select name="speciality" onchange="javascript:document.search.submit();">
						<option value="0"><?php echo $e[21]; ?></option>
						<?php

						$query = mysqli_query($result_db,"select * from specialities order by $name_lang asc");
						while($mysql = mysqli_fetch_array($query))
						{
							$query1 = mysqli_query($result_db,"select items.name_lv, categories.id from categories left join items on categories.id = items.parent_id where categories.statuss='2' and (categories.type = '0' or categories.type = '$_SESSION[t]') and items.speciality like '%*$mysql[id]*%'");

							if($mysql1 = mysqli_fetch_array($query1))
							{
								if($_GET["speciality"] == $mysql["id"])
								{
									$se = ' selected="selected"';$izveleta = $mysql[$name_lang];
								}
								else
								{
									$se = '';
								}
								echo '<option value="'.$mysql["id"].'"'.$se.'>'.$mysql[$name_lang].'</option>';
							}
						}

						?>
					</select>

					<select name="branch" onchange="javascript:document.search.submit();">
						<option value="0"><?php echo $e[22]; ?></option>
						<?php
						$query = mysqli_query($result_db,"select * from branches order by $name_lang asc");
						while($mysql = mysqli_fetch_array($query))
						{
							$query1 = mysqli_query($result_db,"select items.name_lv, categories.id from categories left join items on categories.id = items.parent_id where categories.statuss='2' and (categories.type = '0' or categories.type = '$_SESSION[t]') and items.branch like '%*$mysql[id]*%'");

							if($mysql1 = mysqli_fetch_array($query1))
							{

								if($_GET["branch"] == $mysql["id"])
								{
									$se = ' selected="selected"';$izveleta = $mysql[$name_lang];
								}
								else
								{
									$se = '';
								}
								echo '<option value="'.$mysql["id"].'"'.$se.'>'.$mysql[$name_lang].'</option>';
							}
						}
						?>
					</select>
					<select name="sequence" onchange="javascript:document.search.submit();">
						<option value="0"><?php echo $e[23]; ?></option>
						<option value="1" <?php if($_GET["sequence"] == 1) { echo ' selected="selected"';} ?>><?php echo $e[25]; ?></option>
						<option value="2" <?php if($_GET["sequence"] == 2) { echo ' selected="selected"';} ?>><?php echo $e[26]; ?></option>
						<option value="3" <?php if($_GET["sequence"] == 3) { echo ' selected="selected"';} ?>><?php echo $e[27]; ?></option>
						<option value="4" <?php if($_GET["sequence"] == 4) { echo ' selected="selected"';} ?>><?php echo $e[28]; ?></option>
					</select>

					<?php } ?>



				</form>
			</div>
			<div class="clear"></div>

			<div id="shop-text">
			<?php
			//aizstājam e-pasta adresi ar linku
				$mystring = explode(" ",$e[56]);
				$new_string = array();
				for($r=0;$r<count($mystring);$r++)
				{
					$string = $mystring[$r];
					$findme   = '@';
					$pos = strpos($string, $findme);
					if($pos>0)
					{
						$new_string[] = "<a href=\"mailto:$string\" target=\"_blank\">".$string."</a>";
					}
					else
					{
						$new_string[] = $string;
					}
				}

				$strings = implode(" ",$new_string);
				echo $strings;

			?></div>


			<?php
			$suffix = "items";
			$filters = "";
			$branch_filter = "";
			$branch_query = "";
			$group_filter = "";
			$orders = " order by $suffix.new desc,$suffix.discount desc, $suffix.place asc";
			$group_parameter = "";

			if($_GET["speciality"] > 0)
			{
				$filters .= " and $suffix.speciality like '%*$_GET[speciality]*%'";
			}
			if($_GET["branch"] > 0)
			{
				$filters .= " and branches_items.branche_id = '$_GET[branch]'";
				$branch_query = " left join branches_items on items.id = branches_items.item_id";
				$orders = " order by $suffix.new desc,$suffix.discount desc, branches_items.place asc";
				$group_filter = "group by branches_items.group_type";
				$group_parameter = ", branches_items.group_type ";
			}

			if(!empty($_GET["search"]))
			{
				$filters .= " and ($suffix.$name_lang like '%$_GET[search]%' or $suffix.$text_lang like '%$_GET[search]%' or $suffix.code like '%$_GET[search]%')";
			}


			if($_GET["sequence"] > 0)
			{
				if($_GET["sequence"] == 1){$orders = " order by $suffix.new desc,$suffix.discount desc,  $suffix.price asc";}
				if($_GET["sequence"] == 2){$orders = " order by $suffix.new desc,$suffix.discount desc,  $suffix.price desc";}
				if($_GET["sequence"] == 3){$orders = " order by $suffix.new desc,$suffix.discount desc,  $suffix.$name_lang asc";}
				if($_GET["sequence"] == 4){$orders = " order by $suffix.new desc,$suffix.discount desc,  $suffix.$name_lang desc";}
			}


			if($_SESSION["t"] == 1)
			{
				$buy_filter = " and $suffix.buy = '1'";
			}
			else
			{
				$buy_filter = "";
			}


			// Lapaspuses
			$interval="12";
			if(!isset($_GET["page"]))
			{
				$_GET["page"] = 1;
			}
			$begin = $_GET["page"] * $interval - $interval;

			if($search_on == 1)
			{

				$query_pages = mysqli_query($result_db,"select
				items.picture,
				items.$url_lang,
				items.$name_lang,
				items.code,
				items.id,
				items.discount,
				items.discount_price,
				items.discount_percent,
				items.price,
				items.new,
				items.buy,
				categories.id,
				categories.type,
				items.id as group_type,
				items.parent_id
				$group_parameter
				 from items left join categories on categories.id = items.parent_id $branch_query where categories.statuss='2' and items.statuss = '2' and copy = '0' and (categories.type = '0' or categories.type = '$_SESSION[t]') $filters $buy_filter $group_filter $orders"); echo mysqli_error($result_db);

				$query = mysqli_query($result_db,"select
				items.picture,
				items.$url_lang,
				items.$name_lang,
				items.code,
				items.id,
				items.discount,
				items.discount_price,
				items.discount_percent,
				items.price,
				items.new,
				items.buy,
				categories.id,
				categories.type,
				items.id as group_type,
				items.parent_id
				$group_parameter
				 from items left join categories on categories.id = items.parent_id $branch_query where categories.statuss='2' and items.statuss = '2' and copy = '0' and (categories.type = '0' or categories.type = '$_SESSION[t]') $filters $buy_filter $group_filter $orders LIMIT $begin, $interval ");
			}
			else if($category_discount == 1)
			{
				$query_pages = mysqli_query($result_db,"select * , id as group_type from items where statuss = '2' and  discount = '2' and copy = '0' $filters $buy_filter");
				$query = mysqli_query($result_db,"select * , id as group_type from items where statuss = '2' and discount = '2' and copy = '0' $filters $buy_filter order by parent_id asc, place asc LIMIT $begin, $interval ");
			}
			else
			{
				$query_pages = mysqli_query($result_db,"select * , id as group_type from items where statuss = '2' and  parent_id = '$catalog_id' $filters $buy_filter $orders");
				$query = mysqli_query($result_db,"select * , id as group_type from items where statuss = '2' and parent_id = '$catalog_id' $filters $buy_filter $orders LIMIT $begin, $interval ");
			}



			$pavisam = mysqli_num_rows($query_pages);
			$pages = ceil($pavisam/$interval);
			$page = "";
			$echo_pages = "";

			for($i=1;$i<=$pages;$i++)
			{
				if($i == $_GET["page"])
				{
					$page .= "<div class=\"page_on\"><a href=\"?page=$i&search=$_GET[search]&speciality=$_GET[speciality]&branch=$_GET[branch]&sequence=$_GET[sequence]\"><b>$i</b></a></div>\n";
				}
				else
				{
					$page .= "<div class=\"page\"><a href=\"?page=$i&search=$_GET[search]&speciality=$_GET[speciality]&branch=$_GET[branch]&sequence=$_GET[sequence]\"><b>$i</b></a></div>\n";
				}
			}

			if($pages > 1)
			{
				$echo_pages = "
				<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\">
					<tr>
						<td align=\"center\"><div id=\"page_content\">".$page."</div></td>
					</tr>
					<tr>
						<td colspan=\"2\">&nbsp;</td>
					</tr>
				</table>";

				echo $echo_pages;
			}
			// Lapaspuses beidzas






			$count = mysqli_num_rows($query);
			if($count > 0)
			{
				?>
				<h1><?php if($search_on != 1){ echo $izveleta; } ?></h1>
		<div id="items">
			<div id="choosen"><?php echo $choosen; ?></div>
			<?php
				echo '<table cellpadding="0" cellspacing="1" border="0">';
				$tr = 1; $tr_max = 3; $url_lang = 'url_lv';/*$name_lang = 'name_lv'; $text_lang = 'text_lv';*/
				while($mysql = mysqli_fetch_array($query))
				{
					if($mysql["group_type"] == 0)
					{
						$cats = mysqli_query($result_db,"select * from categories where id = '$mysql[parent_id]'");
						$cat = mysqli_fetch_array($cats);

						if($tr == 1)
						{
							echo '<tr>';
						}

						if($tr == $tr_max)
						{
							$tr_class = "item-td-max";
						}
						else
						{
							$tr_class = "item-td";
						}
						if(!empty($mysql["picture"]))
						{
							$item_picture = '<a href="'.$root_dir.$_GET["lang"].'/'.$cat[$url_lang].'" title="'.$mysql[$name_lang].'"><img src="'.$root_dir.'pictures/items/small/'.$mysql["picture"].'" alt="'.$mysql[$name_lang].'"  /></a>';
						}
						else
						{
							$item_picture = '<a href="'.$root_dir.$_GET["lang"].'/'.$cat[$url_lang].'" title="'.$mysql[$name_lang].'"><img src="'.$root_dir.'include/images/no-picture.gif" alt="'.$mysql[$name_lang].'"  /></a>';
						}


						if(empty($mysql[$name_lang]))
						{
							$item_name = $mysql["name_lv"];
						}
						else
						{
							$item_name = $mysql[$name_lang];
						}



						echo '
						<td class="'.$tr_class.'" valign="top">
							<div class="item-border">
								<div class="item-image">
									<table cellpadding="0" cellspacing="0" border="0" align="center">
										<tr>
											<td valign="middle" align="center" height="180">'.$item_picture.'</td>
										</tr>
									</table>
								</div>
								<h2>'.$e[200].'</h2>
								<div class="item-code">';


								echo '&nbsp;
								</div>

								<div class="price-container-catalog">';

								$discount_image = 0;
								if($mysql["discount"] == 2)
								{
									if($mysql["discount_price"] > 0)
									{
										$price = $mysql["price"] - $mysql["discount_price"];
									}
									else
									{
										$price = $mysql["price"] - $mysql["price"] * $mysql["discount_percent"] / 100;
									}
									$discount_image = 1;
								}
								else
								{
									$price = $mysql["price"];
									// Ja ir piešķirta atlaide
									if($time_discount > 0)
									{
										$price = $price - $price * $time_discount / 100;
										$discount_image = 1;
									}
								}

								// Ja ir lietotāja atlaide
								$price = $price - $price * $user_discount / 100;
								$price = number_format(round($price,2),2,".","");

								if($discount_image == 1)
								{
									$discount_image = '<div class="discount"></div>';
								}
								else
								{
									$discount_image  ="";
								}

								if($mysql["new"] == 2)
								{
									$new_image = '<div class="new"></div>';
								}
								else
								{
									$new_image  ="";
								}

								echo '
								</div>


							</div>
						</td>';

						if($tr == 3)
						{
							$tr = 0;
							echo '</tr>';
						}
						$tr++;

					}
					else
					{
						if($tr == 1)
						{
							echo '<tr>';
						}

						if($tr == $tr_max)
						{
							$tr_class = "item-td-max";
						}
						else
						{
							$tr_class = "item-td";
						}
						if(!empty($mysql["picture"]))
						{
							$item_picture = '<a href="'.$root_dir.$_GET["lang"].'/'.$mysql[$url_lang].'" title="'.$mysql[$name_lang].'"><img src="'.$root_dir.'pictures/items/small/'.$mysql["picture"].'" alt="'.$mysql[$name_lang].'"  /></a>';
						}
						else
						{
							$item_picture = '<a href="'.$root_dir.$_GET["lang"].'/'.$mysql[$url_lang].'" title="'.$mysql[$name_lang].'"><img src="'.$root_dir.'include/images/no-picture.gif" alt="'.$mysql[$name_lang].'"  /></a>';
						}

						if(empty($mysql[$name_lang]))
						{
							$item_name = $mysql["name_lv"];
						}
						else
						{
							$item_name = $mysql[$name_lang];
						}


						$discount_image = 0;
						if($mysql["discount"] == 2)
						{
						    if($mysql["discount_price"] > 0)
						    {
						    	$price = $mysql["price"] - $mysql["discount_price"];
						    }
						    else
						    {
						    	$price = $mysql["price"] - $mysql["price"] * $mysql["discount_percent"] / 100;
						    }
						    $discount_image = 1;
						}
						else
						{
						    $price = $mysql["price"];
						    // Ja ir piešķirta atlaide
						    if($time_discount > 0)
						    {
						    	$discount_image = 1;
						    }
						}

						// Ja ir lietotāja atlaide
						$price = $price - $price * $user_discount / 100;
						$price = number_format(round($price,2),2,".","");

						if($discount_image == 1)
						{
						    $discount_image = '<div class="discount"></div>';
						}
						else
						{
						    $discount_image  ="";
						}

						if($mysql["new"] == 2)
						{
						    $new_image = '<div class="new"></div>';
						}
						else
						{
						    $new_image  ="";
						}

						$item_name = mb_substr(strip_tags($item_name),0,56,"utf-8");
						$cik_dala = mb_strlen($item_name,"utf-8");
						if($cik_dala>=56)
						{
						    $item_name = $item_name."...";
						}

						echo '
						<td class="'.$tr_class.'" valign="top">
							<div class="item-border">
								<div class="item-image">
									<table cellpadding="0" cellspacing="0" border="0" align="center">
										<tr>
											<td valign="middle" align="center" height="180">'.$item_picture.'</td>
										</tr>
									</table>
								</div>
								<h2>'.$item_name.'</h2>';

								echo '
								<div class="item-code">';

								if($mysql["buy"] == 1 && $mysql["code"] != "")
								{
									echo $e[55].': '.$mysql["code"];
								}

								echo '&nbsp;
								</div>

								<div class="price-container-catalog">';




								if($mysql["buy"] == 1 && $cat_type < 2 && $price > 0)
								{
								echo '

									<form action="'.$root_dir.$_GET["lang"]."/to-basket".'" method="get" name="tobasket'.$mysql["id"].'">
										<input type="hidden" name="item_id" value="'.$mysql["id"].'">
										<input type="hidden" name="item_url" value="'.$_GET["url"].'">

											<div class="price-catalog"><span class="price-number-catalog">'.$price.'</span> '.$e[13].'</div>
											<div class="buy"><a href="'.$root_dir.$_GET["lang"].'/'.$mysql[$url_lang].'" title="'.$mysql[$name_lang].'">'.$e[11].'</a></div>

									</form>
									<div class="clear"></div>';
								}

								echo $discount_image.$new_image.'

								</div>


							</div>
						</td>';

						if($tr == 3)
						{
							$tr = 0;
							echo '</tr>';
						}
						$tr++;
					}
				}

				if($tr > 1 && $tr < $tr_max)
				{
					echo '</tr>';
				}
				echo '</table></div>';
			}

			if($pages > 1)
			{
				echo $echo_pages;
			}
			?>

	</div>
	<div class="clear"></div>
</div>
<div id="content-bottom"></div>
<div id="content-top"></div>
<div id="content">
	
	<div id="categories">
		<ul><?php require_once("include/categories.php"); ?></ul>
	</div>
	<div id="item-container">
		<h1><?php echo $izveleta; ?></h1>
		<div id="items">	
			<div id="choosen"><?php echo $choosen.'&nbsp;&gt;&nbsp;'.$izveleta; ?></div>
			
			<div id="price-container"><?php
			
				if($item_buy == 1 && $cat_type < 2 && $item_price > 0)
				{
				?>
				<form action="<?php echo $root_dir.$_GET["lang"]."/to-basket"; ?>" method="get" name="tobasket">
				<input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
				
					<div id="price"><?php echo $e[12].': &nbsp;&nbsp;&nbsp; <span class="price-number">'.$item_price.'</span> '.$e[13]; ?></div>				
					<div id="quantity"> <input type="text" name="quantity" value="1" /> <?php echo $e[14]; ?></div>
					<div id="buy"><a href="javascript:document.tobasket.submit();" title="<?php echo "$e[11] - $izveleta"; ?>"><?php echo $e[11]; ?></a></div>
					<div id="item-code"><?php echo $e[55].': '.$item_code; ?></div>
								</form>
				<div class="clear"></div><?php
				}
				?>
			</div>
			

			<div id="item-text">
				<?php
				if(!empty($item_picture))
				{
				?>
				<div id="item-picture">
					<div id="inside-picture">
						<a href="<?php echo $root_dir; ?>pictures/items/big/<?php echo $item_picture; ?>" rel="lightbox[items-<?php echo $item_id; ?>]" title="<?php echo $izveleta; ?>"><img src="<?php echo $root_dir; ?>pictures/items/small/<?php echo $item_picture; ?>" alt="<?php echo $izveleta; ?>" /></a>
						<div id="loupe"><a href="<?php echo $root_dir; ?>pictures/items/big/<?php echo $item_picture; ?>" rel="lightbox[items-loupe-<?php echo $item_id; ?>]" title="<?php echo $izveleta; ?>"><img src="<?php echo $root_dir; ?>include/images/loupe.png" alt="<?php echo $izveleta; ?>" /></a></div>
						<?php echo $discount_image; ?>
						<?php echo $new_image; ?>
					</div>
				</div>
				<?php
				}
				?>
				<?php echo $item_text; ?>
			</div>		
		</div>
		
		<?php
		//Papildus fotogrāfijas
		if($item_copy > 0){$image_id = $item_copy;}else{$image_id = $item_id;}
		$query = mysql_query("select * from images where parent_id = '$image_id'");
		$count = mysql_num_rows($query);
		if($count > 0)
		{
			echo '
			<div id="pictures-title">'.$e[185].'</div>
			<div id="pictures">';
			while($mysql = mysql_fetch_array($query))
			{
				echo '
					<a href="'.$root_dir.'pictures/items/pic-big/'.$mysql["file"].'.jpg" rel="lightbox[items-'.$item_id.']" title="'.$izveleta.'"><img src="'.$root_dir.'pictures/items/pic-small/'.$mysql["file"].'.jpg" alt="'.$izveleta.'" /></a>';
			}
			echo '<div class="clear"></div></div>';
		}
		mysql_free_result($query);
		?>
		
		<?php
		$query = mysql_query("select * from persons where id = '$item_person'");
		if($mysql = mysql_fetch_array($query))
		{
			$cat_menu = "";	
			$r=mysql_query("Select * from $tabula where parent_id='0' and publish='on' and lang='$_GET[lang]' and type = '3' order by place asc"); 
        	$i = 0;
        	while($f=mysql_fetch_array($r))
        	{
        	    if($f["link"]=="null"){$linc=$root_dir.$_GET["lang"]."/".$f["url"];}
        	    else{$linc="$f[link]";}
        	    if($f["target"]=="null"){$tar="";}
        	    else{$tar=" target=\"$f[target]\"";}        	    
        	    
        	    if(!empty($f["icon"]))
				{
					$icon = '<img src="'.$root_dir.'images/icons/'.$f["icon"].'" width="25" height="25" alt="'.$f["name"].'" />';
				}
				else
				{
					$icon = '';
				}
	
        	  	$cat_menu .= "<div><a href=\"$linc\" title=\"$f[name]\">$icon$f[name]</a></div>";	            			
        	}	

			
			echo '
	  		<div id="person">'.$e[16].'</div>
				<div id="person-info">';
				if(!empty($mysql["picture"]))
				{
					echo '
					<a href="'.$root_dir.'pictures/persons/big/'.$mysql["picture"].'" rel="lightbox[person-'.$mysql["picture"].']" title="'.$mysql[$name_lang].'"><img src="'.$root_dir.'pictures/persons/small/'.$mysql["picture"].'" alt="'.$mysql[$name_lang].'" /></a>';
				}
			echo '
				<p>'.$mysql[$name_lang].'</p>
				<p>'.$e[18].': '.$mysql["phone"].'</p>
				<p>'.$e[19].': '.$mysql["email"].'</p>			
					
			</div>';
			
			if($item_buy == 1 && $cat_type < 2 && $item_price > 0)
			{
				echo '<div id="add-categories">'.$cat_menu.'</div>';
			}
		}
		
		
	  	$filter = explode("**",$item_referals);
	  	$filters = array();
	  	for($i=0;$i<count($filter);$i++)
	  	{
	  		$filters[] = "id = '".str_replace("*","",trim($filter[$i]))."'";
	  	}
	  	$filter = implode(" or ",$filters);
	  	
	  	if(!empty($filter))
	  	{
	  		
	  		
	  		$query = mysql_query("select * from items where $filter order by parent_id, place asc");
	  		$count_items = mysql_num_rows($query);
	  		if($count_items > 0)
	  		{
	  			echo '
	  			<div id="related">'.$e[15].'</div>
				<div id="related-items">';	  		
	  			
	  			echo '<table cellpadding="0" cellspacing="5" border="0">';
				$tr = 1; $tr_max = 3;
				while($mysql = mysql_fetch_array($query))
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
					
					// Ja ir lietotāja atlaide
					$price = $price - $price * $user_discount / 100;								
					$price = number_format(round($price,2),2,".","");
							
					echo '
					<td class="'.$tr_class.'" valign="top">
					<div class="item-border">
						<div class="item-image"><a href="'.$root_dir.$_GET["lang"].'/'.$mysql['url_lv'].'" title="'.$mysql['name_lv'].'"><img src="'.$root_dir.'pictures/items/small/'.$mysql["picture"].'" alt="'.$mysql['name_lv'].'" border="0" /></a></div>
						<h2>'.$mysql['name_lv'].'</h2>';
						
								
						echo '
						<div class="item-code">'.$e[55].': '.$mysql["code"].'</div>
						
						<div class="price-container-catalog">';
							
							
							
							if($mysql["buy"] == 1 && $cat_type < 2 && $price > 0)
							{
							echo '
							<form action="'.$root_dir.$_GET["lang"]."/to-basket".'" method="get" name="tobasket'.$mysql["id"].'">
								<input type="hidden" name="item_id" value="'.$mysql["id"].'">
								<input type="hidden" name="item_url" value="'.$_GET["url"].'">
								<div class="price-catalog"><span class="price-number-catalog">'.$price.'</span> '.$e[13].'</div>								
								<div class="buy-catalog"><a href="javascript:document.tobasket'.$mysql["id"].'.submit();" title="'.$e[11].' - '.$izveleta.'"></a></div>
								<div class="quantity-catalog"> <input type="text" name="quantity" value="1" /> '.$e[14].'</div>
							</form>
							<div class="clear"></div>';
						}
						
						echo $discount_image.$new_image.'
						</div></div>
					</td>';
					
					if($tr == 3)
					{
						$tr = 0;
						echo '</tr>';
					}
					$tr++;
				}
				
				if($tr > 1 && $tr < $tr_max)
				{
					echo '</tr>';
				}
				echo '</table>';
				
	  			echo '</div>';
	  		}	  		
	  	}
	  	
      	?>
		
		<div id="back"><a href="javascript:history.go(-1)"><b>&laquo; <?php echo $e[10]; ?></b></a></div>		
	</div>
	<div class="clear"></div>
</div>
<div id="content-bottom"></div>
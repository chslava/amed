		<div id="languages">
			<a href="<?php echo $root_dir; ?>lv" title="">LV</a> | 
			<a href="<?php echo $root_dir; ?>en" title="">EN</a> | 
			<a href="<?php echo $root_dir; ?>ru" title="">RU</a>
		</div>		
		
		<?php
		if($content_change > 0)
		{
			if($_SESSION['industry'] == 2)
			{
	    		$queryx = mysql_query("select * from categories where parent_id = '0' and industry = '1'");
	    		$mysqlx = mysql_fetch_array($queryx);
	    		$mysqlx_url = 'industry';
	    	}
	    	else
	    	{
	    		$queryx = mysql_query("select * from categories where parent_id = '0' and industry = '2'");
	    		$mysqlx = mysql_fetch_array($queryx);
	    		$mysqlx_url = 'medicine';
	    	}	   
	    
	    	echo '<div id="industry"><a href="'.$root_dir.$_GET["lang"].'/'.$mysqlx_url.'" title="'.$mysqlx[$name_lang].'">'.$mysqlx[$name_lang].'</a></div>';
		}
		
		$query = mysql_query("select * from content where template = '3' and publish = 'on' and lang = '$_GET[lang]'");
		if($mysql = mysql_fetch_array($query))
		{
		    echo '<div id="basket">';
		    $basket_content = '';
		    $ch = mysql_query("select * from basket where ip = '$ip' and session_id = '$ses_id' and user_id = '$user_id'  order by id asc");	
		    $cik = mysql_num_rows($ch);
		    if($cik > 0 )
		    {	
		    	$count = 0;
		    	$total = 0;
		    	while($exists=mysql_fetch_array($ch))
		    	{
		    		$query1 = mysql_query("select * from items where id = '$exists[parent_id]'");
		    		$mysql1 = mysql_fetch_array($query1);
		    		
		    		$tagad = time();
					$di = mysql_query("select * from discounts where '$tagad' >= start_time and '$tagad' <= end_time and cats like '%*$mysql1[parent_id]*%' and type < '3'");
					if($disc = mysql_fetch_array($di))
					{
						$time_discount = $disc["value"];
					}
					else
					{
						$time_discount = 0;
					}
					
		    	
		    		$count = $count + $exists["count"];
		    		$price = $mysql1["price"];
		    		// Ja ir piešķirta atlaide
					if($time_discount > 0 && $time_discount > $mysql1["discount_percent"])
					{
						$price = $price - $price * $time_discount / 100;
					}
					else
					{
						$price = $price - $price * $mysql1["discount_percent"] / 100;
					}
					
					// Ja ir lietotāja atlaide
					$price = $price - $price * $user_discount / 100;							
					$price = number_format(round($price,2),2,".","");
							
		    		$total = $total + $price * $exists["count"];							                   
		    	}								
		    	
		    
		    	$total = number_format($total,2,"."," ");	
		    	$basket_content = '<span>&nbsp;&nbsp;&nbsp;<a href="'.$root_dir.$_GET["lang"].'/'.$mysql["url"].'" title="'.$mysql["name"].'">'.$total.' '.$e[13].' ('.$count.' '.$e[14].')</a>';
		    	
		    	
		    	if($user_id > 0)
		    	{
		    		$basket_content .= '<a href="javascript:void(0);" onclick="ShowPointInfo()"><span>&nbsp;&nbsp;&nbsp;'.$e[180].': '.number_format($user_points,2,".","").' '.$e[13].' </span></a>';
		    	}
		    	
		    	$basket_content .= '</span>';
		    }
		    else
		    {		    	
		    	if($user_id > 0)
		    	{
		    		$basket_content .= '<a href="javascript:void(0);" onclick="ShowPointInfo()"><span>&nbsp;&nbsp;&nbsp;'.$e[180].': '.$user_points.' '.$e[13].' '.$e[13].' </span></a>';
		    	}
		    }
		    echo '<a href="'.$root_dir.$_GET["lang"].'/'.$mysql["url"].'" title="'.$mysql["name"].'">'.$mysql["name"].'</a>'.$basket_content;
		    if($parbaudits == "ok")
		    {
		    	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$root_dir.$_GET["lang"].'/logout">'.$e[130].'</a></div>
		    	<div id="user-points-info">
					'.$e[188].' <b>'.$e[13].' '.$user_points.'</b>
				</div>';		    	
		    }
		    else
		    {
		    	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="ShowLogin()">'.$e[184].'</a></div>';
		    	
		    	if($_GET["url"] == "login")
		    	{
		    		$cl = 'style="display: block;"';
		    	}
		    	else
		    	{
		    		$cl = 'style="display: none;"';
		    	}
		    	echo '
		    	
				<div id="user-popup-login" '.$cl.'>
					<div class="user-login-title">'.$e[66].'</div>
					<form method="post" action="'.$root_dir.$_GET["lang"].'/login">
						<div><label for="login">'.$e[69].'</label><input type="text" name="email" class="user-login-input-top" /></div>
						<div><label for="password">'.$e[68].'</label><input type="password" name="password" class="user-login-input-top" /></div>
						<div><label for="submit"></label><input type="submit" class="user-login-submit-top" name="submit" value="'.$e[70].'" /></div>
						<div class="ahref"><a href="'.$root_dir.$_GET["lang"].'/remember" title="'.$e[71].'">'.$e[71].'</a> <a href="'.$root_dir.$_GET["lang"].'/register" title="'.$e[72].'">'.$e[72].'</a></div>
					</form>
					<div class="clear"></div>
				</div>
				';
		    }
		}
		
		?>
		
		<div id="bottom-banner">
		<?php require_once("include/bottom-banners.php"); ?>
		<!--<img src="<?php echo $root_dir; ?>images/bottom-banner.jpg" width="1000" height="130" border="0" alt="" />-->
		</div>
		<div id="copyright">
		<?php
/*
		$query0 = mysql_query("select * from content where publish = 'on' and type = '4' and lang = '$_GET[lang]'");
		$mysql0 = mysql_fetch_array($query0);
		mysql_free_result($query0);
		
		echo  '<p>';$a = 1;
		$query = mysql_query("select * from keywords order by rand() limit 0,20");
		while($mysql = mysql_fetch_array($query))
		{
			echo '<a href="'.$root_dir.$_GET["lang"].'/'.$mysql0["url"].'" title="'.$mysql["name"].'" class="item-name">'.$mysql["name"].'</a>';
			$a++;
		}
		mysql_free_result($query);
		echo '</p>'*/;
		
		
		$string = "$e[6]<br />$e[7]<br />$e[8]";		
		
		$mystring = explode(" ",$string);
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
							
							
		 ?>
		 	

		 <div class="counter"><a href="http://www.kurpirkt.lv" title="Kurpirkt.lv - visi Latvijas interneta veikali un cenas"
style="Overflow: hidden; Position: relative; Width:88px; Height:31px; font-size: 10px; display:block;">
<img style="Border: none; Position: absolute; Top: 0px; left:0px;" alt="Kurpirkt.lv - visi Latvijas interneta veikali un cenas"
src="http://www.kurpirkt.lv/media/kurpirkt88.gif" width=88 height=31></a></div>
		 </div>
	</div>
	
	<div class="popup" id="popup">
		<div class="popup-content" id="popup-content">
			<div class="popup-text" id="popup-text">
			<?php
			$query = mysql_query("select * from content where template = '4' and lang = '$_GET[lang]'");
			if($mysql = mysql_fetch_array($query))
			{
				echo $mysql['text'];
			}
			?>
			</div>
			<div class="close"><a href="javascript:void(0);" onclick="CloseServicePopup(); return false;"><img src="<?php echo $img_dir; ?>close.png" width="35" height="35" border="0" /></a></div>
		</div>
	</div>
	
</div>			
</body>
</html>
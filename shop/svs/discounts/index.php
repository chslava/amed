<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

?>

<html>
	<head>
		<title><?php echo $head[0]; ?></title>
		<meta http-equiv="Content-Type" content="text/html; <?php echo $head[1]; ?>">
		<link rel="stylesheet" href="<?php echo $wolf_path; ?>style.css" type="text/css">
		<script language="JavaScript">
			function go( url){
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
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
                  		<tr>
                     		<td valign="top" class="sad" height="30"><a href="index.php<?php echo $li1; ?>" class="sad_link"><?php echo $menu_it[21]; ?></a></td>                    
                  		</tr>
                  		<tr>
		 				  <td class="text1" valign="top" height="30"><INPUT TYPE="Button" VALUE="<?php echo "$discounts[23]"; ?>" class="button" onclick='go("pievienot.php<?php echo $li1; ?>")'></td>
	   				</tr>
              		 </table>
               
               

               	<table cellpadding="3" cellspacing="2" width="100%" style="border: 1px solid #d0d2dd">
	 				<tr>
	  					<td class="standart" bgcolor="#f2f3f7" colspan="8"><b><?php echo $discounts[21]; ?></b></td>
	  				</tr>
	  				<?php
	  				$all_discounts = array("",$discounts[34],$discounts[35],$discounts[36],$discounts[37],$discounts[39],$discounts[42]);
	  				$a = 0;
	  				$text_lang = "text_".$ver;
					$rep=mysqli_query($result_db,"Select * from discounts order by start_time desc");
	  				while($rop=mysqli_fetch_array($rep))
					{
						$start_time = date("d.m.Y H:i",$rop["start_time"]);
						$end_time = date("d.m.Y H:i",$rop["end_time"]);
						$tagad = time();
						if($tagad >= $rop["start_time"] && $tagad <= $rop["end_time"])
						{
							$act = " - <span style=\"color: red;\"><b>$discounts[30]</b></span>";
						}
						else
						{
							if($tagad < $rop["start_time"])
							{
								$act = " - $discounts[31]";
							}
							if($tagad > $rop["end_time"])
							{
								$act = " - $discounts[32]";
							}
						}
						
						$d_type = $rop["type"];
						
						if($rop["type"] == 4)
						{
							$cc = $rop["coupon"];
						}
						else
						{
							$cc = "";
						}
	 					echo "
							<tr>
								<td class=\"st1\">$rop[name] $act</td>
								<td class=st1 valign=top>$rop[value]%</td>
								<td class=st1 valign=top>$cc&nbsp;</td>
								<td class=st1 valign=top>$start_time</td>
								<td class=st1 valign=top>$end_time</td>	
								<td class=st1 valign=top>$all_discounts[$d_type]</td>								
								<td class=st1 valign=top width=\"90\">
									<INPUT TYPE=Button VALUE=\"$jaunumi[28]\" class=button1 onclick='go(\"mainit.php$li1&name=$rop[id]\")'>
									<INPUT TYPE=Button VALUE=\"$pr[56]\" class=button1 onclick='go(\"dzest.php$li1&name=$rop[id]\")'>
								</td>
							</tr>";
						$a++;
					}
	  				mysqli_free_result($rep);
	 				if($a == 0)
	 				{
	 					echo "<tr><td class=\"standart\">$discounts[22]</td></tr>";
	 				}
	  				?>
	 			</table>
               	<!--
                <table cellpadding="3" cellspacing="2" width="100%" style="border: 1px solid #d0d2dd">
	 					<tr>
                     <td class="standart" bgcolor="#f2f3f7"><b><?php echo $katalogs[38]; ?></b></td>
                  </tr>
                  <?php
						/*
						$name_lang = "name_".$ver;

						$brands = array();
						$brands[0] = "-";
						$ren=mysqli_query($result_db,"Select * from tire_brands order by name asc");
						while($row=mysqli_fetch_array($ren))
						{
							$brand_id = $row["id"];
							$brands[$brand_id] = $row["name"];							
						}
						mysqli_free_result($ren);
						
						$seasons = array("-",$item[71],$item[72],$item[85]);
						$types = array("-",$item[77],$item[78],$item[79],$item[86],$item[87],$item[88]);
						$news = array("-",$item[90],$item[91]);

						$query = mysqli_query($result_db,"select * from items where discount1 = '2' group by discount1_percents, parent_id, brand, season, type, new order by discount1_percents asc");
						while($mysql = mysqli_fetch_array($query))
						{
							$brand_id = $mysql["brand"];
							$season_id = $mysql["season"];
							$type_id = $mysql["type"];
							$new_id = $mysql["new"];
							
							$query1 = mysqli_query($result_db,"select * from categories where id = '$mysql[parent_id]'");
							$mysql1 = mysqli_fetch_array($query1);
							mysqli_free_result($query1);
							
							echo "
							<tr>
								<td class=\"standart\">$mysql1[name_lv] ($brands[$brand_id], $seasons[$season_id], $types[$type_id], $news[$new_id]) - $mysql[discount1_percents]%</td>
							</tr>
							";
						}
						mysqli_free_result($query);*/
						?>
                  
               </table>
               -->
					
				</td>
			</tr>
		</table>
	</body>
</html>


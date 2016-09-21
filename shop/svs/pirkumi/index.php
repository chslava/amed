<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

$interval="25";
if(empty($_GET["page"]))
{
	$_GET["page"] = 1;
}
$begin = $_GET["page"] * $interval - $interval;

if(isset($_SESSION['searching']))
{
	if($_SESSION['searching'] == "on")
	{
		$_SESSION['searching'] == "off";

		
		
		if(isset($_SESSION['statuss'])){$statuss = $_SESSION['statuss'];}else{$statuss="";}
		if(isset($_SESSION['keyword'])){$keyword = $_SESSION['keyword'];}else{$keyword="";}		
		if(isset($_SESSION['summa'])){$summa = $_SESSION['summa'];}else{$summa="";}
		
		
		
		
		
		if(isset($_SESSION['keyword']))
		{
			$keyword = $_SESSION['keyword'];
			$keyword1= " and (
			company_email like '%$keyword%' or 
			person_email like '%$keyword%' or
			company_code like '%$keyword%' or
			company_address like '%$keyword%' or
			company_bank_code like '%$keyword%' or
			company_account like '%$keyword%' or
			company_phone like '%$keyword%' or
			company_deliver like '%$keyword%' or
			company_comments like '%$keyword%' or
			person_name like '%$keyword%' or
			company_name like '%$keyword%' or
			person_phone like '%$keyword%' or
			person_code like '%$keyword%' or
			person_deliver like '%$keyword%' or
			company_person like '%$keyword%' or
			company_position like '%$keyword%'
			)";
		}
		else{$keyword="";$keyword1="";}
		
			
		
		if(isset($_SESSION['summa']))
		{
			if($_SESSION['summa'] > 0)
			{
				$summax = $_SESSION['summa'];
				$summa1= " and amount = '$summax'";
			}
			else{$summa="";$summa1="";}
		}
		else{$summa="";$summa1="";}
		
		if(isset($_SESSION['sdat'])){$sdat = $_SESSION['sdat'];}else{$sdat="";}
		
		if($_SESSION['sdat']!="")
		{	
			$sdat = $_SESSION['sdat'];
			$da = explode("-",$sdat);
			$sakums = mktime(0,0,0,$da[1],$da[0],$da[2]);
			$sdat1= " and (time>='$sakums')";
		}
		else{$sdat="";$sdat1="";}
		
		if($_SESSION['bdat']!="")
		{	
			$bdat = $_SESSION['bdat'];
			$da = explode("-",$bdat);
			$beigas = mktime(0,0,0,$da[1],$da[0],$da[2]) + 86400;
			$bdat1= " and (time<'$beigas')";
		}
		else{$bdat="";$bdat1="";}
		
		
		if(isset($_SESSION['statuss']))
		{
			if($_SESSION['statuss'] != '')
			{
				$statuss = $_SESSION['statuss'];
				$statuss1= " and statuss='$statuss'";
			}
			else{$statuss="";$statuss1="";}
		}
		else{$statuss="";$statuss1="";}
		
		
		
		$select1 = "select id from orders where id>'0' $keyword1  $summa1 $statuss1 $sdat1 $bdat1 ";
		$select2 = "select * from orders where id>'0' $keyword1  $summa1 $statuss1 $sdat1 $bdat1 order by id desc LIMIT $begin, $interval";
	
	}
}
else
{
	$valst = "";
	$nr = "";
	$ids = "";
	$keyword = "";
	$vards = "";
	$uzvards = "";
	$summa = "";
	$arh = time() - 5184000;
	$select1 = "select id from orders ";
	$select2 = "select * from orders order by id desc LIMIT $begin, $interval";
	$sdd = date("d");
	$smm = date("m");
	$syy = date("Y");
	$sdat = "";
	$statuss=0;
	$bdat = "";
	
}


?>

<html>
	<head>
		<title><?php echo $head[0]; ?></title>
		<meta http-equiv="Content-Type" content="text/html; <?php echo $head[1]; ?>">
		<link rel="stylesheet" href="<?php echo $wolf_path; ?>style.css" type="text/css">
		<script language="JavaScript" src="calendar1.js"></script>
		<script language="JavaScript">
			function go( url){
			window.location.href = url;
			}
		</script>
		<script language="JavaScript" src="calendar1.js"></script>
		<style>
			.statuss-0, .statuss-1, .statuss-2, .statuss-3, .statuss-4, .statuss-5, .statuss-6 
			{
				font-family: Tahoma,Arial,Helvetica, geneva,sans-serif;
				font-size:11px;
				border: 1px solid #d0d2dd;
			}
			
			/* PIENEMTS */
			.statuss-0 {			 	
				color:#008000;
				font-weight: bold;
				background-color: #B7FFB7;
			}
			
			/* SAZVANITS KLIENTS */
			.statuss-1 {			 	
				color:#000000;
				font-weight: bold;
				background-color: #ffffff;
			}
			
			/* NOSUTITS REKINS */
			.statuss-2 {			 	
				color:#999999;
				background-color: #ffffff;
			}
			
			/* PRIEKSAPMAKSA SANEMTA */
			.statuss-3 {			 	
				color:#008000;
				font-weight: bold;
				background-color: #B7FFB7;
				
			}
			
			/* NODOTS PIEGADEI */
			.statuss-4 {			 	
				color:#ff0000;
				font-weight: bold;
				background-color: #ffffff;
			}
			
			/* IZPILDITS */
			.statuss-5 {			 	
				color:#ff0000;
				color:#999999;
				background-color: #ffffff;
			}
			
			/* ATTEIKTS */
			.statuss-6 {			 	
				color:#ffffff;
				font-weight: bold;
				background-color: #ff0000;
			}
		</style>
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
		 				  <td height="30" valign="top" class="sad">
								<table width="100%" cellspacing="0" cellpadding="0" border="0">
									<tr>
										<td class="sad"><a href="delet_session.php<?php echo $li1; ?>" class="sad_link"><?php echo $menu_it[24]; ?></a></td>
										<td class="sad" align="right"><a href="stoped-orders.php<?php echo $li1; ?>" class="sad_link"><?php echo $orders[169]; ?></a></td>
									</tr>
								</table>
							</td>
	   					</tr>
	  	    			<tr>
							<td>
                     
                     
                     
                     
                     
                     
								<table cellpadding="3" cellspacing="1" border="0" width="100%" style="border: 1px solid #d0d2dd">
									<form action="search.php?lang=<?php echo $ver; ?>" method="post" name="search">
									<tr> 
		 				 				<td bgcolor="#f2f3f7" class="standart" colspan="10"><b><?php echo $orders[61]; ?></b></td>
	   							</tr>
                         
                           <tr>
                              <td>
                              	<table cellpadding="2" cellspacing="1" border="0">
                              		<tr>
													<td class="standart" valign="middle">
													<select name="statuss" class="input" style="width: 150px">
													<option value=""></option>
													
													<option value="0" <?php if($statuss=="0")echo " selected"; ?>><?php echo $statuses[0]; ?></option>
													<option value="1" <?php if($statuss=="1")echo " selected"; ?>><?php echo $statuses[1]; ?></option>
													<option value="2" <?php if($statuss=="2")echo " selected"; ?>><?php echo $statuses[2]; ?></option>
													<option value="3" <?php if($statuss=="3")echo " selected"; ?>><?php echo $statuses[3]; ?></option>
													<option value="4" <?php if($statuss=="4")echo " selected"; ?>><?php echo $statuses[4]; ?></option>
													<option value="5" <?php if($statuss=="5")echo " selected"; ?>><?php echo $statuses[5]; ?></option>
													<option value="6" <?php if($statuss=="6")echo " selected"; ?>><?php echo $statuses[6]; ?></option>
											
													
													</select></td>
													<td class="standart" valign="middle" align="right"><?php echo $orders[166]; ?>:</td>
													<td class="standart" valign="middle"><input type="text" name="keyword" class="input" style="width: 150px" value="<?php echo $keyword; ?>"></td>
                                 		
                                       													
                                       
                                       <td class="standart" valign="middle" align="right"><?php echo $orders[113]; ?></td>
													<td class="standart" valign="middle"><input type="text" name="summa" class="input" style="width: 50px" value="<?php echo $summa; ?>"></td>
													
													
													
													
												
													<td class="standart" valign="middle" align="right"><?php echo $orders[167]; ?>:</td>
                           	<td class="standart" valign="bottom"><?php echo "<input type=\"text\" name=\"sdat\"  style=\"width: 70px; margin:0px;\" value=\"$sdat\" class=\"input\">"; ?>&nbsp;<a href="javascript:cal11.popup();"><img src="img/cal.gif" width="18" height="18" border="0" align="absbottom"></a></td>
                          
                           	<td class="standart" valign="middle" align="right"><?php echo $orders[168]; ?>:</td>
                              <td class="standart" valign="bottom"><?php echo "<input type=\"text\" name=\"bdat\"  style=\"width: 70px; margin:0px;\" value=\"$bdat\" class=\"input\">"; ?>&nbsp;<a href="javascript:cal12.popup();"><img src="img/cal.gif" width="18" height="18" border="0" align="absbottom"></a></td>
													
													
													
													
													
													
                                       <td class="standart" valign="middle" align="center" rowspan="2"><input type="submit" name="search_button" value="<?php echo $orders[144]; ?>" class="button"></td>
                                    </tr>
                                 </table>
                              </td>
                           </tr>
                           </form>
                           <script language="JavaScript">
											var cal11 = new calendar1(document.forms['search'].elements['sdat']);
											cal11.year_scroll = true;
											cal11.time_comp = false;
											
											var cal12 = new calendar1(document.forms['search'].elements['bdat']);
											cal12.year_scroll = true;
											cal12.time_comp = false;
											
										//-->
										</script>
								</table>
							
									
									
							</td>
						</tr>
												
			    </table>
					
					<table><tr><td>&nbsp;</td></tr></table>
				<?php 
					
					$r = mysqli_query($result_db,$select1);
					$pavisam = mysqli_num_rows($r);
					$pages = ceil($pavisam/$interval);
					$page = "";
					$echo_pages = "";
					
					for($i=1;$i<=$pages;$i++)
					{
						if($i == $_GET["page"])
						{
							$page .= "<div class=\"page_on\"><a href=\"$li"."&page=$i\" class=\"page_number\"><b>$i</b></a></div><div class=\"atstarpe\"></div>\n";
						}
						else
						{
							$page .= "<div class=\"page\"><a href=\"$li"."&page=$i\" class=\"page_number\"><b>$i</b></a></div><div class=\"atstarpe\"></div>\n";
						}
					}
				
				
					
					if($pages > 1)
					{
						$echo_pages = "
						<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\">
							<tr>
								<td align=\"center\"><div id=\"page_content\">".$page."</div></td>
							</tr>
						</table>";
						
						echo $echo_pages;
					}
					
				
					?>
					
					
	 				<table cellpadding="3" cellspacing="2" width="100%" style="border: 1px solid #d0d2dd">
	 					<tr>
							<td class="standart" bgcolor="#f2f3f7" valign="top"><b><?php echo $orders[1]; ?></b></td>
							<td class="standart" bgcolor="#f2f3f7" valign="top"><b><?php echo str_replace(" ","&nbsp;",$orders[2]); ?></b></td>
							<td class="standart" bgcolor="#f2f3f7" valign="top" width="20%"><b><?php echo $orders[104]; ?></b>
							<td class="standart" bgcolor="#f2f3f7" valign="top"><b><?php echo str_replace(" ","&nbsp;",$orders[5]); ?></b></td>
							<td class="standart" bgcolor="#f2f3f7" valign="top"><b><?php echo $orders[3]; ?></b></td>
							<td class="standart" bgcolor="#f2f3f7" valign="top"><b><?php echo $orders[13]; ?></b></td>
	  				</tr>
	  				<?php
						$nos = "orders";
						$statuss_text = array(0 => $statuses[0], 1 => $statuses[1], 2 => $statuses[2], 3 => $statuses[3], 4 => $statuses[4], 5 => $statuses[5], 6 => $statuses[6]);
	  				
						$rep=mysqli_query($result_db,$select2);
						echo mysqli_error();
	  					$a=1;
	 					while($rop=mysqli_fetch_array($rep))
						{
							//echo "$rop[id]";
							$datums = str_replace(" ","&nbsp;",date("d.m.Y H:i:s",$rop["time"]));
							$stat = $rop["statuss"];
							if($rop["person"] == 2)
							{
								$client_name = $rop["person_name"];
							}
							else
							{
								$client_name = $rop["company_name"];
							}
							
							$der = 0; $rest1 = 0; $rest2 = 0;
							
							if($rop["statuss"] == 0 || $rop["statuss"] == 1)
							{
								
								$query = mysqli_query($result_db,"select * from statuses where order_id = '$rop[id]' order by time desc limit 0,1");
								$mysql = mysqli_fetch_array($query);
								mysqli_free_result($query);
								
								
								$end = mktime(23,59,59,date("n"),date("j"),date("Y"));
															
								if(date("G",$mysql["time"])> 17)
								{
									$start_time =  strtotime('+1 day', $mysql["time"]);
									$start = mktime(9,0,0,date("n",$start_time),date("j",$start_time),date("Y",$start_time));									
								}
								elseif(date("G",$mysql["time"])> 9 && date("G",$mysql["time"])< 17)
								{
									$start_time =  $mysql["time"];
									$start = $start_time;									
								}
								else
								{
									$start_time = $mysql["time"];
									$start = mktime(9,0,0,date("n",$start_time),date("j",$start_time),date("Y",$start_time));									
								}	
								
								//echo " Sākuma datums =".date("d.m.Y H:i:s",$start);
								for($i=$start; $i<$end; $i = $i + 86400)
								{
									
									if(date("w",$i) >= 1 && date("w",$i) < 6)
									{		
										//echo "&nbsp;&nbsp;&nbsp;".date("d.m.Y",$i)."<br >";								
										if(date("d.m.Y",$i) == date("d.m.Y"))
										{	
											//echo "=".date("G")."=";
											//Šodiena
											if(date("G") >= 9 && date("G") <= 17)
											{											
												$rest1 = $rest1 + (date("G") - date("G",$i)) * 60 * 60;
											}											
											else
											{
												$rest1 = $rest1 + (17 - date("G",$i)) * 60 * 60;												
											}										
										}
										else
										{
											
											//Iepriekšējās dienas										
											if(date("G",$mysql["time"]) >= 9 && date("G",$mysql["time"]) <= 17)
											{											
												$rest1 = $rest1 + (17 - date("G",$mysql["time"])) * 60 * 60;												
											}											
											else
											{
												$rest1 = $rest1 + 8 * 60 * 60;
												
											}
										}
									}											
								}	
								//echo "<br />";	
								
																								
							}
							
							
							if($rop["statuss"] == 0)
							{
								if($rest1 > 3600)
								{	
									$der = 1;	
								}
							}						
							
							if($rop["statuss"] == 1)
							{
								if($rest1 > 10800)
								{	
									$der = 1;	
								}
							}	
		
							
							if($der > 0)
							{
								$risk = " style=\"background-color:#ff0000; color:#ffffff;\"";
							}
							else
							{
								$risk = "";
							}
							
	  						echo "
							<tr onmouseover=\"this.style.backgroundColor='#FFFCAE'\" onmouseout=\"this.style.backgroundColor=''\">
								<td class=st1 valign=top$risk>$rop[id]</td>
								<td class=st1 valign=top$risk>$datums</td>
								<td class=st1 valign=top width=\"100%\"$risk>$client_name</td>
								
							";
							$sum = number_format($rop["amount"],2,"."," ");
							echo "
								
								<td class=st1 valign=top$risk>".str_replace(" ","&nbsp;",$sum)."&nbsp;€</td>
								<td class=\"statuss-$stat\" valign=top$risk>$statuss_text[$stat]</td>
				
								<td class=st1 valign=top width=\"210\"$risk><INPUT TYPE=Button VALUE=\"$orders[14]\" class=button1 onclick='go(\"apskatit.php$li1&name=$rop[id]&limit=$limit\")'>";
								echo "</td>
							</tr>";
							$a++;
						}
	  				mysqli_free_result($rep);
	 					if($a==1)
						{
	  					echo "<tr><td class=\"st1\" colspan=\"7\">$orders[32]</td></tr>";
	  				}
	   				?>
						
	 				</table>
				</td>
			</tr>
		</table>
	</body>
</html>


<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

$res = mysql_query("select * from clients where id = '$id'");
$rop = mysql_fetch_array($res);
mysql_free_result($res);
	
$error = "";

if(isset($_POST["submit"]))
{
	$change_from=array("\"","\'","'","\n","\\");
	$change_to=array("&quot;","","","<br />","");
	
	$change_from1=array("\\r","\\n","\\","'","\\");
	$change_to1=array("","","","&lsquo;","");
	
	$coupon_value = trim(str_replace($change_from,$change_to,$_POST["coupon_value"]));
	$coupon_code = trim(str_replace($change_from,$change_to,$_POST["coupon_code"]));
		
	$coupon_start_time = mktime($_POST["s_hour"],$_POST["s_minute"],0,$_POST["s_month"],$_POST["s_day"],$_POST["s_year"]);
	$coupon_end_time = mktime($_POST["e_hour"],$_POST["e_minute"],0,$_POST["e_month"],$_POST["e_day"],$_POST["e_year"]);
	
	$coefficient_start_time = mktime($_POST["cs_hour"],$_POST["cs_minute"],0,$_POST["cs_month"],$_POST["cs_day"],$_POST["cs_year"]);
	$coefficient_end_time = mktime($_POST["ce_hour"],$_POST["ce_minute"],0,$_POST["ce_month"],$_POST["ce_day"],$_POST["ce_year"]);
		
	$client_contract = 1;
	if(isset($_POST["client_contract"]))
	{
		if($_POST["client_contract"] == "on")
		{
			$client_contract = 2;
		}
	}
	
	$coupon = 1;
	if(isset($_POST["coupon"]))
	{
		if($_POST["coupon"] == "on")
		{
			$coupon = 2;
		}
	}
	
	if($rop["person"] == 1)
	{
	
		$client_name = trim(str_replace($change_from,$change_to,$_POST["client_name"]));
		$client_code = trim(str_replace($change_from,$change_to,$_POST["client_code"]));
		$client_address = trim(str_replace($change_from,$change_to,$_POST["client_address"]));
		$client_bank = trim(str_replace($change_from,$change_to,$_POST["client_bank"]));
		$client_account = trim(str_replace($change_from,$change_to,$_POST["client_account"]));
		$client_phone = trim(str_replace($change_from,$change_to,$_POST["client_phone"]));
		$client_deliver = trim(str_replace($change_from,$change_to,$_POST["client_deliver"]));
		$client_person = trim(str_replace($change_from,$change_to,$_POST["client_person"]));
		$client_position = trim(str_replace($change_from,$change_to,$_POST["client_position"]));
		$coefficient = trim(str_replace($change_from,$change_to,$_POST["client_coefficient"]));
		
		$client_contract = 1;
		if(isset($_POST["client_contract"]))
		{
			if($_POST["client_contract"] == "on")
			{
				$client_contract = 2;
			}
		}
		
		$rakstam=mysql_query("update clients set 
		company_name = '$client_name',
		company_code = '$client_code',
		company_address = '$client_address',
		company_bank = '$client_bank',
		company_account = '$client_account',
		company_phone = '$client_phone',
		company_deliver = '$client_deliver',
		company_person = '$client_person',
		company_position = '$client_position',
		company_contract = '$client_contract',
		coefficient = '$coefficient',
		
		coupon = '$coupon',
		coupon_value = '$coupon_value',
		coupon_code = '$coupon_code',
		coupon_start_time = '$coupon_start_time',
		coupon_end_time = '$coupon_end_time',
		coefficient_start_time = '$coefficient_start_time',
		coefficient_end_time = '$coefficient_end_time'
		 
				
		where id = '$id'
		");
	}
	else
	{
		$client_name = trim(str_replace($change_from,$change_to,$_POST["client_name"]));
		$client_code = trim(str_replace($change_from,$change_to,$_POST["client_code"]));
		$client_address = trim(str_replace($change_from,$change_to,$_POST["client_address"]));
		$client_phone = trim(str_replace($change_from,$change_to,$_POST["client_phone"]));
		$client_deliver = trim(str_replace($change_from,$change_to,$_POST["client_deliver"]));
		$coefficient = trim(str_replace($change_from,$change_to,$_POST["client_coefficient"]));
		
		$client_contract = 1;
		if(isset($_POST["client_contract"]))
		{
			if($_POST["client_contract"] == "on")
			{
				$client_contract = 2;
			}
		}
				
		$rakstam=mysql_query("update clients set 
		person_name = '$client_name',
		person_code = '$client_code',
		person_deliver = '$client_deliver',
		person_contract = '$client_contract',
		coefficient = '$coefficient',
		
		coupon = '$coupon',
		coupon_value = '$coupon_value',
		coupon_code = '$coupon_code',
		coupon_start_time = '$coupon_start_time',
		coupon_end_time = '$coupon_end_time',
		coefficient_start_time = '$coefficient_start_time',
		coefficient_end_time = '$coefficient_end_time'
				
		where id = '$id'
		");
	}
	
	$links = "index.php".$li;
	header("Location: $links");
	exit;
	
}
else
{	
	$person = $rop["person"];
	
	$coupon = $rop["coupon"];
	$coupon_value = $rop["coupon_value"];
	$coupon_code = $rop["coupon_code"];
	
	$s_year = date("Y",$rop["coupon_start_time"]);
	$s_month = date("n",$rop["coupon_start_time"]);
	$s_day = date("j",$rop["coupon_start_time"]);	
	$s_hour = date("H",$rop["coupon_start_time"]);
	$s_minute = date("i",$rop["coupon_start_time"]);
	
	$e_year = date("Y",$rop["coupon_end_time"]);
	$e_month = date("n",$rop["coupon_end_time"]);
	$e_day = date("j",$rop["coupon_end_time"]);	
	$e_hour = date("H",$rop["coupon_end_time"]);
	$e_minute = date("i",$rop["coupon_end_time"]);
	
	$cs_year = date("Y",$rop["coefficient_start_time"]);
	$cs_month = date("n",$rop["coefficient_start_time"]);
	$cs_day = date("j",$rop["coefficient_start_time"]);	
	$cs_hour = date("H",$rop["coefficient_start_time"]);
	$cs_minute = date("i",$rop["coefficient_start_time"]);
	
	$ce_year = date("Y",$rop["coefficient_end_time"]);
	$ce_month = date("n",$rop["coefficient_end_time"]);
	$ce_day = date("j",$rop["coefficient_end_time"]);	
	$ce_hour = date("H",$rop["coefficient_end_time"]);
	$ce_minute = date("i",$rop["coefficient_end_time"]);
	
	
	if($rop["person"] == 1)
	{
		$client_name = $rop["company_name"];
		$client_code = $rop["company_code"];
		$client_address = $rop["company_address"];
		$client_bank = $rop["company_bank"];
		$client_account = $rop["company_account"];
		$client_phone = $rop["company_phone"];
		$client_deliver = $rop["company_deliver"];
		$client_person = $rop["company_person"];
		$client_position = $rop["company_position"];
		$client_contract = $rop["company_contract"];
		$client_coefficient = $rop["coefficient"];
	}
	else
	{
		$client_name = $rop["person_name"];
		$client_code = $rop["person_code"];
		$client_phone = $rop["person_phone"];
		$client_deliver = $rop["person_deliver"];
		$client_contract = $rop["person_contract"];
		$client_coefficient = $rop["coefficient"];
	}	
}
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
										<td class="sad" height="30" valign="top"><a href="index.php<?php echo $li1; ?>" class="sad_link"><?php echo $menu_it[29]; ?></a> <img src="<?php echo $wolf_path; ?>img/next.gif" align="absmiddle"> <a href="mainit.php<?php echo $li; ?>" class="sad_link"><?php echo $orders[153]; ?></a></td>										
									</tr>	    	
			   </table>
				
               
               <form action="mainit.php<?php echo $li; ?>" method="post" name="jaunumi" enctype="multipart/form-data" style="margin:0px;">
               
					<table cellpadding="5" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd;" id="lv-content">
               			<tr>
                    		<td class="standart" bgcolor="#f2f3f7" colspan="8"><b><?php echo $orders[154]; ?></b></td>
                  		</tr>
                  				
                  		<?php
                  		if($person == 1)
                  		{
                  		?>
                  		<tr>
							<td valign="middle" align="right" class="standart" width="250"><b><?php echo $e[80]; ?></b></td>
							<td valign="middle"><input type="text" name="client_name" class="input" style="width: 300px" value="<?php echo $client_name; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="250"><b><?php echo $e[81]; ?></b></td>
							<td valign="middle"><input type="text" name="client_code" class="input" style="width: 300px" value="<?php echo $client_code; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="250"><b><?php echo $e[82]; ?></b></td>
							<td valign="middle"><input type="text" name="client_address" class="input" style="width: 300px" value="<?php echo $client_address; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="250"><b><?php echo $e[83]; ?></b></td>
							<td valign="middle"><input type="text" name="client_bank" class="input" style="width: 300px" value="<?php echo $client_bank; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="250"><b><?php echo $e[85]; ?></b></td>
							<td valign="middle"><input type="text" name="client_account" class="input" style="width: 300px" value="<?php echo $client_account; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="250"><b><?php echo $e[87]; ?></b></td>
							<td valign="middle"><input type="text" name="client_phone" class="input" style="width: 300px" value="<?php echo $client_phone; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="250"><b><?php echo $e[89]; ?></b></td>
							<td valign="middle"><input type="text" name="client_deliver" class="input" style="width: 300px" value="<?php echo $client_deliver; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="250"><b><?php echo $e[91]; ?></b></td>
							<td valign="middle"><input type="text" name="client_person" class="input" style="width: 300px" value="<?php echo $client_person; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="250"><b><?php echo $e[138]; ?></b></td>
							<td valign="middle"><input type="text" name="client_position" class="input" style="width: 300px" value="<?php echo $client_position; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="250"><b><?php echo $orders[157]; ?></b></td>
							<td valign="middle"><input type="checkbox" name="client_contract" <?php if($client_contract == 2) { echo "checked";} ?>></td>
						</tr>
						<?php
                  		}
                  		else
                  		{
                  		?>
                  		<tr>
							<td valign="middle" align="right" class="standart" width="250"><b><?php echo $e[91]; ?></b></td>
							<td valign="middle"><input type="text" name="client_name" class="input" style="width: 300px" value="<?php echo $client_name; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="250"><b><?php echo $e[92]; ?></b></td>
							<td valign="middle"><input type="text" name="client_code" class="input" style="width: 300px" value="<?php echo $client_code; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="250"><b><?php echo $e[87]; ?></b></td>
							<td valign="middle"><input type="text" name="client_phone" class="input" style="width: 300px" value="<?php echo $client_phone; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="250"><b><?php echo $e[89]; ?></b></td>
							<td valign="middle"><input type="text" name="client_deliver" class="input" style="width: 300px" value="<?php echo $client_deliver; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="250"><b><?php echo $orders[157]; ?></b></td>
							<td valign="middle"><input type="checkbox" name="client_contract" <?php if($client_contract == 2) { echo "checked";} ?>></td>
						</tr>
                  		<?php
                  		}
                  		?>	
						<tr>
                    		<td class="standart" bgcolor="#f2f3f7" colspan="8"><b><?php echo $discounts[40]; ?></b></td>
                  		</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="250"><b><?php echo $orders[158]; ?></b></td>
							<td valign="middle" class="standart"><input type="text" name="client_coefficient" class="input" style="width: 40px" value="<?php echo $client_coefficient; ?>"> %</td>
						</tr> 
						<tr>
							<td valign="middle" align="right" class="standart"><b><?php echo $discounts[24]; ?></b></td>
							<td class="standart">
							    <select name="cs_year">
							    <?php
							    for($i = date("Y"); $i<date("Y")+3;$i++)
							    {
							    	if($i == $cs_year){$se="selected";} else{$se="";}
							    	echo '<option name="cs_year" value="'.$i.'"'.$se.'>'.$i.'</option>';
							    }
							    ?>
							    </select>-
							    <select name="cs_month">
							    <?php
							    $months = array("",$t_hotels[69],$t_hotels[70],$t_hotels[71],$t_hotels[72],$t_hotels[73],$t_hotels[74],$t_hotels[75],$t_hotels[76],$t_hotels[77],$t_hotels[78],$t_hotels[79],$t_hotels[80]);
							    for($i = 1; $i<count($months);$i++)
							    {
							    	if($i == $cs_month){$se="selected";} else{$se="";}
							    	echo '<option name="cs_month" value="'.$i.'"'.$se.'>'.$months[$i].'</option>';
							    }
							    ?>
							    </select>-
							    <select name="cs_day">
							    <?php
							    for($i = 1; $i<=31;$i++)
							    {
							    	if($i == $cs_day){$se="selected";} else{$se="";}
							    	echo '<option name="cs_day" value="'.$i.'"'.$se.'>'.$i.'</option>';
							    }
							    ?>
							    </select>
							    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							    Laiks <select name="cs_hour">
							    <?php
							    for($i = 0; $i<=23;$i++)
							    {
							    	if($i == $cs_hour){$se="selected";} else{$se="";}
							    	echo '<option name="cs_hour" value="'.$i.'"'.$se.'>'.$i.'</option>';
							    }
							    ?>
							    </select>:
							    <select name="cs_minute">
							    <?php
							    for($i = 0; $i<=59;$i++)
							    {
							    	if($i == $cs_minute){$se="selected";} else{$se="";}
							    	echo '<option name="cs_minute" value="'.$i.'"'.$se.'>'.$i.'</option>';
							    }
							    ?>
							    </select>
							    Stundas : Minūtes
							</td>
						</tr> 
						<tr>
							
							<td valign="middle" align="right" class="standart"><b><?php echo $discounts[25]; ?></b></td>
							<td class="standart">
							    <select name="ce_year">
							    <?php
							    for($i = date("Y"); $i<date("Y")+3;$i++)
							    {
							    	if($i == $ce_year){$se="selected";} else{$se="";}
							    	echo '<option name="ce_year" value="'.$i.'"'.$se.'>'.$i.'</option>';
							    }
							    ?>
							    </select>-
							    <select name="ce_month">
							    <?php
							    $months = array("",$t_hotels[69],$t_hotels[70],$t_hotels[71],$t_hotels[72],$t_hotels[73],$t_hotels[74],$t_hotels[75],$t_hotels[76],$t_hotels[77],$t_hotels[78],$t_hotels[79],$t_hotels[80]);
							    for($i = 1; $i<count($months);$i++)
							    {
							    	if($i == $ce_month){$se="selected";} else{$se="";}
							    	echo '<option name="ce_month" value="'.$i.'"'.$se.'>'.$months[$i].'</option>';
							    }
							    ?>
							    </select>-
							    <select name="ce_day">
							    <?php
							    for($i = 1; $i<=31;$i++)
							    {
							    	if($i == $ce_day){$se="selected";} else{$se="";}
							    	echo '<option name="ce_day" value="'.$i.'"'.$se.'>'.$i.'</option>';
							    }
							    ?>
							    </select>
							    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							    Laiks <select name="ce_hour">
							    <?php
							    for($i = 0; $i<=23;$i++)
							    {
							    	if($i == $ce_hour){$se="selected";} else{$se="";}
							    	echo '<option name="ce_hour" value="'.$i.'"'.$se.'>'.$i.'</option>';
							    }
							    ?>
							    </select>:
							    <select name="ce_minute">
							    <?php
							    for($i = 0; $i<=59;$i++)
							    {
							    	if($i == $ce_minute){$se="selected";} else{$se="";}
							    	echo '<option name="ce_minute" value="'.$i.'"'.$se.'>'.$i.'</option>';
							    }
							    ?>
							    </select>
							    Stundas : Minūtes
							</td>
						</tr>
						<tr>
                    		<td class="standart" bgcolor="#f2f3f7" colspan="8"><b><?php echo $discounts[41]; ?></b></td>
                  		</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="250"><b><?php echo $orders[161]; ?></b></td>
							<td valign="middle"><input type="checkbox" name="coupon" <?php if($coupon == 2) { echo "checked";} ?>></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="250"><b><?php echo $orders[163]; ?></b></td>
							<td valign="middle" class="standart"><input type="text" name="coupon_value" class="input" style="width: 40px" value="<?php echo $coupon_value; ?>"> %</td>
						</tr>
						<tr>
									<td valign="middle" align="right" class="standart"><b><?php echo $discounts[38]; ?></b></td>
									<td class="standart"><input type="text" name="coupon_code" style="width: 100px" class="input" value="<?php echo $coupon_code; ?>"></td>
								</tr> 
								<tr>
									<td valign="middle" align="right" class="standart"><b><?php echo $discounts[24]; ?></b></td>
									<td class="standart">
										<select name="s_year">
										<?php
										for($i = date("Y"); $i<date("Y")+3;$i++)
										{
											if($i == $s_year){$se="selected";} else{$se="";}
											echo '<option name="s_year" value="'.$i.'"'.$se.'>'.$i.'</option>';
										}
										?>
										</select>-
										<select name="s_month">
										<?php
										$months = array("",$t_hotels[69],$t_hotels[70],$t_hotels[71],$t_hotels[72],$t_hotels[73],$t_hotels[74],$t_hotels[75],$t_hotels[76],$t_hotels[77],$t_hotels[78],$t_hotels[79],$t_hotels[80]);
										for($i = 1; $i<count($months);$i++)
										{
											if($i == $s_month){$se="selected";} else{$se="";}
											echo '<option name="s_month" value="'.$i.'"'.$se.'>'.$months[$i].'</option>';
										}
										?>
										</select>-
										<select name="s_day">
										<?php
										for($i = 1; $i<=31;$i++)
										{
											if($i == $s_day){$se="selected";} else{$se="";}
											echo '<option name="s_day" value="'.$i.'"'.$se.'>'.$i.'</option>';
										}
										?>
										</select>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										Laiks <select name="s_hour">
										<?php
										for($i = 0; $i<=23;$i++)
										{
											if($i == $s_hour){$se="selected";} else{$se="";}
											echo '<option name="s_hour" value="'.$i.'"'.$se.'>'.$i.'</option>';
										}
										?>
										</select>:
										<select name="s_minute">
										<?php
										for($i = 0; $i<=59;$i++)
										{
											if($i == $s_minute){$se="selected";} else{$se="";}
											echo '<option name="s_minute" value="'.$i.'"'.$se.'>'.$i.'</option>';
										}
										?>
										</select>
										Stundas : Minūtes
									</td>
								</tr> 
								<tr>
									<td valign="middle" align="right" class="standart"><b><?php echo $discounts[25]; ?></b></td>
									<td class="standart">
										<select name="e_year">
										<?php
										for($i = date("Y"); $i<date("Y")+3;$i++)
										{
											if($i == $e_year){$se="selected";} else{$se="";}
											echo '<option name="e_year" value="'.$i.'"'.$se.'>'.$i.'</option>';
										}
										?>
										</select>-
										<select name="e_month">
										<?php
										$months = array("",$t_hotels[69],$t_hotels[70],$t_hotels[71],$t_hotels[72],$t_hotels[73],$t_hotels[74],$t_hotels[75],$t_hotels[76],$t_hotels[77],$t_hotels[78],$t_hotels[79],$t_hotels[80]);
										for($i = 1; $i<count($months);$i++)
										{
											if($i == $e_month){$se="selected";} else{$se="";}
											echo '<option name="e_month" value="'.$i.'"'.$se.'>'.$months[$i].'</option>';
										}
										?>
										</select>-
										<select name="e_day">
										<?php
										for($i = 1; $i<=31;$i++)
										{
											if($i == $e_day){$se="selected";} else{$se="";}
											echo '<option name="e_day" value="'.$i.'"'.$se.'>'.$i.'</option>';
										}
										?>
										</select>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										Laiks <select name="e_hour">
										<?php
										for($i = 0; $i<=23;$i++)
										{
											if($i == $e_hour){$se="selected";} else{$se="";}
											echo '<option name="e_hour" value="'.$i.'"'.$se.'>'.$i.'</option>';
										}
										?>
										</select>:
										<select name="e_minute">
										<?php
										for($i = 0; $i<=59;$i++)
										{
											if($i == $e_minute){$se="selected";} else{$se="";}
											echo '<option name="e_minute" value="'.$i.'"'.$se.'>'.$i.'</option>';
										}
										?>
										</select>
										Stundas : Minūtes
									</td>
								</tr>
                  		
                  				
						
					</table>
               <table cellpadding="0" cellspacing="0" border="0"> 
              		<tr>
                  	<td valign="middle" height="30"><INPUT TYPE=Button VALUE="<?php echo $orders[155];?>" class=button onclick='go("index.php<?php echo $li1; ?>")' style="margin:0px;">  <input type="submit" name="submit" class="button" value="<?php echo $orders[156]; ?>"></td>
						</tr>						
					</table>
					</form>
					
					
					
				</td>
			</tr>
		</table>
	</body>
</html>


<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");
if(isset($_POST["add-discount"]))
{

	$change_from=array("\"","\'","'","\\","\n","&");
	$change_to=array("&quot;","&rsquo;","&rsquo;","","<br />","&amp;");

	$name_lv=trim(str_replace($change_from,$change_to,$_POST["name_lv"]));
	$type=trim(str_replace($change_from,$change_to,$_POST["type"]));
	$coupon=trim(str_replace($change_from,$change_to,$_POST["coupon"]));
	
	$cats = ""; $cat = array();
	if(isset($_POST["categories"]))
	{
		foreach($_POST["categories"] as $key => $value)
		{
			$cats=$cats."*".$value."*";
			$cat[$value]=$value;
		}
		
	}	
	else
	{
		$error[0] = 1;
	}
		
	if(empty($_POST["discount_percent"]))
	{
		$discount_percent = 0; 
		$error[0] = 1;
	}
	else
	{
		$discount_percent = $_POST["discount_percent"]; 
	}
	
	$start_time = mktime($_POST["s_hour"],$_POST["s_minute"],0,$_POST["s_month"],$_POST["s_day"],$_POST["s_year"]);
	$end_time = mktime($_POST["e_hour"],$_POST["e_minute"],0,$_POST["e_month"],$_POST["e_day"],$_POST["e_year"]);
	
	$result = mysqli_query($result_db,"update discounts set 
	
	start_time = '$start_time',
	end_time = '$end_time',
	value = '$discount_percent',
	name = '$name_lv',
	cats = '$cats',
	type = '$type',
	coupon = '$coupon'
	
	where id = '$name'
	");

	$links = "index.php?lang=$lang&ver=$ver";
	header("Location: $links");
	exit;
} 
else
{
	$ren=mysqli_query($result_db,"Select * from discounts where id='$name'");
	$row=mysqli_fetch_array($ren);
	mysqli_free_result($ren);

	$name_lv = $row["name"];
	$type = $row["type"];
	$discount_percent = $row["value"];
	
	$cats = explode("*",$row["cats"]);
	$cat=array();
	$c=count($cats);
	
	for($v=0;$v<$c;$v++)
	{	
		$k = $cats[$v];
		$cat[$k] = $k;
	}
	
	$s_year = date("Y",$row["start_time"]);
	$s_month = date("n",$row["start_time"]);
	$s_day = date("j",$row["start_time"]);	
	$s_hour = date("H",$row["start_time"]);
	$s_minute = date("i",$row["start_time"]);
	
	$e_year = date("Y",$row["end_time"]);
	$e_month = date("n",$row["end_time"]);
	$e_day = date("j",$row["end_time"]);	
	$e_hour = date("H",$row["end_time"]);
	$e_minute = date("i",$row["end_time"]);
	$coupon = $row["coupon"];
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
                     <td height="30" valign="top" class="sad"><a href="index.php<?php echo $li1; ?>" class="sad_link"><?php echo $menu_it[21]; ?></a></td>
                  </tr>
                </table>
					<form action="mainit.php<?php echo $li1."&name=$name"; ?>" method="post">
               		<table cellpadding="3" cellspacing="2" width="100%" style="border: 1px solid #d0d2dd">
	 					<tr>
                     		<td class="standart" bgcolor="#f2f3f7"><b><?php echo $discounts[27]; ?></b></td>
                  		</tr>
                  		
	  					<tr>
                  			<td>
                     
                        	<table cellpadding="5" cellspacing="0" border="0">
                        		<tr>
									<td valign="middle" align="right" class="standart" width="150"><b><?php echo $discounts[28]; ?></b></td>
									<td valign="middle" class="text1"><input type="text" name="name_lv" style="width: 300px" class="input" value="<?php echo $name_lv; ?>"></td>
								</tr>
                              	<?php
                              	function sub_cat($cat_id,$category,$cat_name)
                              	{
                                 	$mysql1 = mysqli_query($result_db,"select * from categories where parent_id = '$cat_id' order by place asc");
                                 	while($cat1 = mysqli_fetch_array($mysql1))
                                 	{	
                                    	$parent_name = $cat_name." $cat1[name_lv]";
                                    
                                    	$c_id = $cat1["id"];
                                    	if(isset($category[$c_id]))
                                    	{
                                       		$se = " selected";
                                    	}
                                    	else
                                    	{
                                      	 	$se = "";
                                    	}										
                                    	echo "<option value=\"$cat1[id]\"$se>$parent_name</option>\n";                                           
                                    	sub_cat($cat1["id"],$category,$cat_name."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");							
                                 	}
                                 	mysqli_free_result($mysql1);                                                                  
                              	}
                              	function sub_cats($category)
                              	{
                                	$mysql = mysqli_query($result_db,"select * from categories where parent_id = '0' order by place asc");
                                 	while($cat = mysqli_fetch_array($mysql))
                                 	{	
                                    	$c_id = $cat["id"];
                                    	if(isset($category[$c_id]))
                                    	{
                                      		$se = " selected";
                                    	}
                                    	else
                                    	{
                                       	$se = "";
                                    	}
                                    	echo "<option value=\"$cat[id]\"$se>$cat[name_lv]</option>\n";
                                    	$cat_name = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";	
                                    	sub_cat($cat["id"],$category,$cat_name);						
                                 	}
                                 	mysqli_free_result($mysql);
                              	}
                              	?>
                          		<tr>
                              		<td valign="middle" align="right" class="standart" width="150"><b><?php echo $discounts[14]; ?></b></div></td>
                              		<td valign="middle">
                              			<select class="input" name="categories[]" multiple="multiple" size="20">
                                 			<option value="0"></option>
                                 			<?php sub_cats($cat); ?>
                              			</select>
                              		</td>
                           		</tr>
                           		<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $discounts[33]; ?></b></td>
							<td valign="middle">
                     
							<select class="input" name="type">
                            	<option value="0"></option>                                
                               	<!--<option value="1" <?php if($type == 1) {echo " selected";} ?>><?php echo $discounts[34]; ?></option>-->
                               	<option value="2" <?php if($type == 2) {echo " selected";} ?>><?php echo $discounts[35]; ?></option>
                               	<option value="3" <?php if($type == 3) {echo " selected";} ?>><?php echo $discounts[36]; ?></option>                               	
                               	<option value="4" <?php if($type == 4) {echo " selected";} ?>><?php echo $discounts[37]; ?></option>
                               	<option value="5" <?php if($type == 5) {echo " selected";} ?>><?php echo $discounts[39]; ?></option>
                               	<option value="6" <?php if($type == 6) {echo " selected";} ?>><?php echo $discounts[42]; ?></option>
                            </select>
							</td>
						</tr>
                           		<tr>
									<td valign="middle" align="right" class="standart"><b><?php echo $discounts[15]; ?></b></td>
									<td class="standart"><input type="text" name="discount_percent" style="width: 50px" class="input" value="<?php echo $discount_percent; ?>"> % </td>
								</tr> 
								<tr>
									<td valign="middle" align="right" class="standart"><b><?php echo $discounts[38]; ?></b></td>
									<td class="standart"><input type="text" name="coupon" style="width: 100px" class="input" value="<?php echo $coupon; ?>"></td>
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
								<tr>
									<td valign="middle" align="right" class="standart"></td>
									<td class="standart"><div style="margin-top:5px;"><INPUT TYPE=Button VALUE="<?php echo $discounts[18];?>" class=button onclick='go("index.php<?php echo $li; ?>")'> <input type="submit" name="add-discount" class="button" value="<?php echo $food[19]; ?>"></div></td>
								</tr>                          
                        	</table>
                     	</td>
                  	</tr>						
	 			</table>
	 			
               	
               	</form>
					
				</td>
			</tr>
		</table>
	</body>
</html>


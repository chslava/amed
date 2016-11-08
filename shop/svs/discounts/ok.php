<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

$error = array();
if(isset($_POST["add-discount"]))
{
	$filter = "";
	if(isset($_POST["categories"]))
	{
		foreach($_POST["categories"] as $key => $value)
		{
			$filter[] = "parent_id = '$value'";
		}
		
		if(count($filter) > 0)
		{
			$filter = implode(" or ", $filter);
			$filter = ' and ('.$filter.')';
		}
	}	
	else
	{
		$error[0] = 1;
	}
		
	$discount_percent = $_POST["discount_percent"]; 
	
}
else
{
	$error[0] = 1;
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
                     		<td valign="top" class="sad" height="25"><a href="index.php<?php echo $li1; ?>" class="sad_link"><?php echo $menu_it[21]; ?></a></td>                    
                  		</tr>
               		</table>
               
               		<table cellpadding="3" cellspacing="2" width="100%" style="border: 1px solid #d0d2dd">
	 					<tr>
                     		<td class="standart" bgcolor="#f2f3f7"><b><?php echo $discounts[20]; ?></b></td>
                  		</tr>
	  					<tr>
                  			<td class="standart">                     
                        	<?php
                        		if(count($error) > 0)
								{
									echo $discounts[17];
								}
								else
								{
									$a = 1;
									$query = mysqli_query($result_db,"select * from items where id > '0' $filter");								
									while($mysql = mysqli_fetch_array($query))
									{
										$update = mysqli_query($result_db,"update items set discount_percent = '$discount_percent' where id = '$mysql[id]'");
										
										echo "$a. $mysql[name_lv]<br />";
										$a++;
									}
									mysqli_free_result($query);
									
									if($a == 1)
									{
										echo $discounts[19];
									}
								}
							?>
							</td>
                  		</tr>						
	 				</table>               
               		<div style="margin-top:5px;"><INPUT TYPE=Button VALUE="<?php echo $discounts[18];?>" class=button onclick='go("index.php<?php echo $li; ?>")'></div>
					
				</td>
			</tr>
		</table>
	</body>
</html>


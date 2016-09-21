<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

if(isset($_POST["submit"]))
{
	$change_from=array("\"","\'","'","\\");
	$change_to=array("&quot;","","","");
		
	$nosaukums=str_replace($change_from,$change_to,$_POST["nosaukums"]);
	$nosaukums=trim($nosaukums);
	
	$tips=str_replace($change_from,$change_to,$_POST["tips"]);
	$tips=trim($tips);
	
	$garums=str_replace($change_from,$change_to,$_POST["garums"]);
	$garums=trim($garums);
	
	$platums=str_replace($change_from,$change_to,$_POST["platums"]);
	$platums=trim($platums);
	
	$ieraksti=str_replace($change_from,$change_to,$_POST["ieraksti"]);
	$ieraksti=trim($ieraksti);
	
	$parbaude=str_replace($change_from,$change_to,$_POST["parbaude"]);
	$parbaude=trim($parbaude);
	
	$obligati=str_replace($change_from,$change_to,$_POST["obligati"]);
	$obligati=trim($obligati);
	if($obligati == "on")
	{
		$obl = 2;
	}
	else
	{
		$obl = 1;
	}
	
	$result = mysqli_query($result_db,"update anketas set 
	
	field_name = '$nosaukums',
	field_type = '$tips',
	field_length = '$garums',
	field_width = '$platums',
	field_check = '$parbaude',
	field_fill = '$obl',
	field_value = '$ieraksti'
	
	where id='$k'
	"); 
	
	$links = "lauki.php".$li1."&name=$name";
	header("Location: $links");
	exit;
	
}
else
{
	$ren=mysqli_query($result_db,"Select * from anketas where id='$k'");
	$row=mysqli_fetch_array($ren);
	mysqli_free_result($ren);

	$nosaukums = $row["field_name"];
	$tips =  $row["field_type"];
	$garums =  $row["field_length"];
	$platums =  $row["field_width"];
	$ieraksti =  $row["field_value"];
	$parbaude =  $row["field_check"];
	if($row["field_fill"] == "1")
	{
		$obligati = "off";
	}
	else
	{
		$obligati = "on";
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
				<td colspan="2" height="20" bgcolor="d0d2dd">
				<?php require_once($wolf_path."izveleta.php"); ?>
				</td>
			</tr>
			<tr>
				<td width="250" valign="top" bgcolor="#f2f3f7">
				<?php require_once($wolf_path."page_menu.php"); ?>
				</td>
				<td bgcolor="#ffffff" width="100%" valign="top" class="text">
				<?php 
$ren=mysqli_query($result_db,"Select * from anketas where id='$name'");
$row=mysqli_fetch_array($ren);
mysqli_free_result($ren);


?>
					<table cellpadding="3" cellspacing="0" border="0" width="100%">
						<tr>
	  					<td class="text1" colspan="2"></td>
						</tr>
   				</table>
					<table><tr><td></td></tr></table>
					<table width="100%" cellpadding="3" cellspacing="2" border="0" style="border: 1px solid #d0d2dd">
      			<tr>
       				<td bgcolor="#f2f3f7" colspan="4" class="standart"><b><?php echo $sabloni[15].": \"".$row["name"]."\""; ?></b></td>
						</tr>
						<tr>
							<td>
								<form name="formas_lauks" enctype="multipart/form-data" action="lauks_mainit.php<?php echo "$li1&name=$name&k=$k"; ?>" method="post">
								<table cellpadding="3" cellspacing="2">
									<tr>
										<td valign="middle" align="right" class="standart"><b><?php echo $sabloni[22]; ?></b></td>
										<td><input type="text" name="nosaukums" style="width: 300px" class="input" value="<?php echo $nosaukums; ?>"></td>
									</tr>
									<tr>
										<td valign="middle" align="right" class="standart"><b><?php echo $sabloni[23]; ?></b></td>
										<td>
										<select class="input" name="tips">
										<option value="0" <?php if($tips == 0) { echo "selected";} ?>></option>
										<option value="1" <?php if($tips == 1) { echo "selected";} ?>><?php echo $sabloni[24]; ?></option>
										<option value="2" <?php if($tips == 2) { echo "selected";} ?>><?php echo $sabloni[25]; ?></option>
										<option value="3" <?php if($tips == 3) { echo "selected";} ?>><?php echo $sabloni[26]; ?></option>
										<option value="4" <?php if($tips == 4) { echo "selected";} ?>><?php echo $sabloni[27]; ?></option>
										<option value="5" <?php if($tips == 5) { echo "selected";} ?>><?php echo $sabloni[49]; ?></option>
										
										</select>
										</td>
									</tr>
									<tr>
										<td valign="middle" align="right" class="standart"><b><?php echo $sabloni[28]; ?></b></td>
										<td valign="middle"><input type="text" name="garums" style="width: 50px" class="input"  value="<?php echo $garums; ?>"></td>
									</tr>
									<tr>
										<td valign="middle" align="right" class="standart"><b><?php echo $sabloni[63]; ?></b></td>
										<td valign="middle"><input type="text" name="platums" style="width: 50px" class="input"  value="<?php echo $platums; ?>"></td>
									</tr>
									<tr>
										<td valign="top" align="right" class="standart"><?php echo $sabloni[29]; ?></td>
										<td valign="top"><textarea class="input" style="width: 300px" rows="8" name="ieraksti" ><?php echo $ieraksti ?></textarea></td>
									</tr>
									
									<tr>
										<td valign="top" align="right" class="standart"><b><?php echo $sabloni[37]; ?></b></td>
										<td>
										<select class="input" name="parbaude">
										<option value="0" <?php if($parbaude == 0) { echo "selected";} ?>></option>
										<option value="1" <?php if($parbaude == 1) { echo "selected";} ?>><?php echo $sabloni[31]; ?></option>
										<option value="4" <?php if($parbaude == 4) { echo "selected";} ?>><?php echo $sabloni[36]; ?></option>
										</select>
										</td>
									</tr>
									<tr>
										<td valign="middle" align="right" class="standart"><b><?php echo $sabloni[38]; ?></b></td>
										<td valign="middle"><input type="Checkbox" name="obligati"  class="ch" <?php if($obligati == "on") { echo "checked";} ?>></td>
									</tr>
									<tr>
										<td align="right"><INPUT TYPE="Button" VALUE="<?php echo $sabloni[16]; ?>" class="button" onclick='go("<?php echo "lauks_mainit.php$li1&name=$name\")'"; ?>'></td>
										<td><INPUT TYPE="Submit" VALUE="<?php echo $sabloni[78]; ?>" class="button" name="submit"></td>
									</tr>
									</form>
								</table>
							
							</td>
						</tr>
					</table>
					
				</td>
			</tr>
		</table>
	</body>
</html>


<?php
//iel�d�jam funkcijas
require_once("config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

$error = "";
if(isset($_POST["submit"])){

	$change_from=array("\"","\'","'","\\");
	$change_to=array("&quot;","","","");

	$name_lv=str_replace($change_from,$change_to,$_POST["name_lv"]);$name_lv=trim($name_lv);
	$name_ru=str_replace($change_from,$change_to,$_POST["name_ru"]);$name_ru=trim($name_ru);
	$name_en=str_replace($change_from,$change_to,$_POST["name_en"]);$name_en=trim($name_en);
	$name_ee=str_replace($change_from,$change_to,$_POST["name_ee"]);$name_ee=trim($name_ee);
	$name_lt=str_replace($change_from,$change_to,$_POST["name_lt"]);$name_lt=trim($name_lt);
	
	$nos = "specialities";
		
	$rakstam=mysqli_query($result_db,"insert into $nos values ('','$name_ee','$name_lv','$name_lt','$name_ru','$name_en')");
	
	$links = "speciality.php".$li1;
	header("Location: $links");
	exit; 

}
else{
$name_en="";
$name_lv="";
$name_ru="";
$name_ee="";
$name_lt="";

$type=1;

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
				<?php require_once("izveleta.php"); ?>
				</td>
			</tr>
			<tr>
				<td width="250" valign="top" bgcolor="#f2f3f7">
				<?php require_once("page_menu.php"); ?>
				</td>
				<td bgcolor="#ffffff" width="100%" valign="top" class="text">
				
				
				
				
					<table cellpadding="0" cellspacing="0" width="100%">
						<tr>
		 				  <td height="30" valign="top" class="sad"><a href="index.php<?php echo $li1; ?>" class="sad_link"><?php echo $pr[0]; ?></a> <img src="<?php echo $wolf_path; ?>img/next.gif" align="absmiddle"><a href="speciality.php<?php echo $li1; ?>" class="sad_link"><?php echo $pr[85]; ?></a> <img src="<?php echo $wolf_path; ?>img/next.gif" align="absmiddle"><a href="speciality_pievienot.php<?php echo $li1; ?>" class="sad_link"><?php echo $pr[87]; ?></a></td>
	   				</tr>
						<tr>
							<td>
								<table cellpadding="3" cellspacing="2" style="border: 1px solid #d0d2dd" width="100%">
								<form name="jaunumi" enctype="multipart/form-data" action="speciality_pievienot.php<?php echo $li1; ?>" method="post">
									<?php echo $error; ?>
									<tr>
		 							  <td bgcolor="#f2f3f7" colspan="2" class="standart"><b><?php echo $pr[88]; ?></b></td>
	   							</tr>
									
									<tr>
										<td valign="middle" align="right" width="150" class="standart"><b><?php echo $head[5]; ?></b></td>
										<td><input type="text" name="name_ee" style="width: 200px" class="input" value="<?php echo $name_ee; ?>"></td>
									</tr>
									<tr>
										<td valign="middle" align="right" width="150" class="standart"><b><?php echo $head[2]; ?></b></td>
										<td><input type="text" name="name_lv" style="width: 200px" class="input" value="<?php echo $name_lv; ?>"></td>
									</tr>
									<tr>
										<td valign="middle" align="right" width="150" class="standart"><b><?php echo $head[6]; ?></b></td>
										<td><input type="text" name="name_lt" style="width: 200px" class="input" value="<?php echo $name_lt; ?>"></td>
									</tr>
									<tr>
										<td valign="middle" align="right" width="150" class="standart"><b><?php echo $head[3]; ?></b></td>
										<td><input type="text" name="name_ru" style="width: 200px" class="input" value="<?php echo $name_ru; ?>"></td>
									</tr>
									<tr>
										<td valign="middle" align="right" width="150" class="standart"><b><?php echo $head[4]; ?></b></td>
										<td><input type="text" name="name_en" style="width: 200px" class="input" value="<?php echo $name_en; ?>"></td>
									</tr>
									
									<tr>
                           
										<td valign="top">&nbsp;</td>
										<td><INPUT TYPE="Submit" VALUE="<?php echo $pr[89]; ?>" class="button" name="submit"></td>
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


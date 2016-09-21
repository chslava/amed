<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

$rep=mysql_query("Select * from keywords where id='$_GET[name]'");
$rop=mysql_fetch_array($rep);
mysql_free_result($rep);

if(isset($_POST["submit"]))
{
	$change_from=array("'","\\","&","<");
	$change_to=array("`","","&amp;","&lt;");
	
	$name_lv=str_replace("\"","&quot;",$_POST["name_lv"]);
	$name_lv=str_replace("\'","",$name_lv);
	$name_lv=str_replace("'","",$name_lv);
	$name_lv=trim($name_lv);
	
	$url_ee=str_replace($change_from,$change_to,trim($_POST["url_ee"]));
	$url_lv=str_replace($change_from,$change_to,trim($_POST["url_lv"]));
	$url_lt=str_replace($change_from,$change_to,trim($_POST["url_lt"]));
	$url_ru=str_replace($change_from,$change_to,trim($_POST["url_ru"]));
	$url_en=str_replace($change_from,$change_to,trim($_POST["url_en"]));

	
	$rakstam=mysql_query("update keywords set url_lv='$url_lv', url_ru='$url_ru', url_en = '$url_en', url_ee = '$url_ee', url_lt = '$url_lt', name='$name_lv' where id='$_GET[name]'");
	
	$links = "index.php?lang=$lang&ver=$ver";
	header("Location: $links");
	exit;
	
}

if(!isset($_POST["submit"]))
{
	$url_lt=$rop["url_lt"];
	$url_ee=$rop["url_ee"];
	$url_lv=$rop["url_lv"];
	$url_ru=$rop["url_ru"];
	$url_en=$rop["url_en"];
	$name_lv=$rop["name"];
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
                     <td height="30" valign="top" class="sad"><a href="mainit.php<?php echo $li1."&name=$_GET[name]"; ?>" class="sad_link"><?php echo $menu_it[41]; ?></a></td>
                  </tr>
                </table>
            
            
					<form name="jaunumi" enctype="multipart/form-data" action="mainit.php<?php echo "$li1&name=$_GET[name]"; ?>" method="post">
						<table cellpadding="3" cellspacing="2" width="100%" style="border: 1px solid #d0d2dd">
                     <tr>
                     	<td class="standart" bgcolor="#f2f3f7" colspan="8"><b><?php echo $text[14]; ?></b></td>
                  	</tr>
							<tr>
								<td valign="middle" align="right" class="standart"><b><?php echo $text[13]; ?></b></td>
								<td valign="middle" class="text1"><input type="text" name="name_lv" style="width: 500px" class="input" value="<?php echo $name_lv; ?>"></td>
							</tr>
							<tr>
								<td valign="middle" align="right" class="standart"><b><?php echo $text[16]; ?></b></td>
								<td valign="middle" class="text1"><input type="text" name="url_lv" style="width: 500px" class="input" value="<?php echo $url_lv; ?>"></td>
							</tr>
							<tr>
								<td valign="middle" align="right" class="standart"><b><?php echo $text[15]; ?></b></td>
								<td valign="middle" class="text1"><input type="text" name="url_ee" style="width: 500px" class="input" value="<?php echo $url_ee; ?>"></td>
							</tr>
                    		
							<tr>
								<td valign="middle" align="right" class="standart"><b><?php echo $text[17]; ?></b></td>
								<td valign="middle" class="text1"><input type="text" name="url_lt" style="width: 500px" class="input" value="<?php echo $url_lt; ?>"></td>
							</tr>
							<tr>
								<td valign="middle" align="right" class="standart"><b><?php echo $text[18]; ?></b></td>
								<td valign="middle" class="text1"><input type="text" name="url_ru" style="width: 500px" class="input" value="<?php echo $url_ru; ?>"></td>
							</tr>	
                            <tr>
								<td valign="middle" align="right" class="standart"><b><?php echo $text[19]; ?></b></td>
								<td valign="middle" class="text1"><input type="text" name="url_en" style="width: 500px" class="input" value="<?php echo $url_en; ?>"></td>
							</tr>
							
							
							<tr>
								<td valign="top">&nbsp;</td>
								<td><input type="Button" value="<?php echo $text[5]; ?>" class="button" onclick='go("index.php<?php echo $li1; ?>")'>&nbsp;<INPUT TYPE="Submit" VALUE="<?php echo $text[10]; ?>" class="button" name="submit"></td>
							</tr>
						</table>
					</form>
					
				</td>
			</tr>
		</table>
	</body>
</html>


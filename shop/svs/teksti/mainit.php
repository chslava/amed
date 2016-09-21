<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

$rep=mysqli_query($result_db,"Select * from texts where id='$_GET[name]'");
$rop=mysqli_fetch_array($rep);
mysqli_free_result($rep);

if(isset($_POST["submit"]))
{
	$teksts_ee=str_replace("\"","&quot;",$_POST["teksts_ee"]);
	$teksts_ee=str_replace("\'","",$teksts_ee);
	$teksts_ee=str_replace("'","",$teksts_ee);
	$teksts_ee=trim($teksts_ee);
	
	$teksts_lt=str_replace("\"","&quot;",$_POST["teksts_lt"]);
	$teksts_lt=str_replace("\'","",$teksts_lt);
	$teksts_lt=str_replace("'","",$teksts_lt);
	$teksts_lt=trim($teksts_lt);
	
	$teksts_lv=str_replace("\"","&quot;",$_POST["teksts_lv"]);
	$teksts_lv=str_replace("\'","",$teksts_lv);
	$teksts_lv=str_replace("'","",$teksts_lv);
	$teksts_lv=trim($teksts_lv);
	
	$teksts_en=str_replace("\"","&quot;",$_POST["teksts_en"]);
	$teksts_en=str_replace("\'","",$teksts_en);
	$teksts_en=str_replace("'","",$teksts_en);
	$teksts_en=trim($teksts_en);
	
	$teksts_ru=str_replace("\"","&quot;",$_POST["teksts_ru"]);
	$teksts_ru=str_replace("\'","",$teksts_ru);
	$teksts_ru=str_replace("'","",$teksts_ru);
	$teksts_ru=trim($teksts_ru);
	
	$apraksts=str_replace("\"","&quot;",$_POST["apraksts"]);
	$apraksts=str_replace("\'","",$apraksts);
	$apraksts=str_replace("'","",$apraksts);
	$apraksts=trim($apraksts);
	
	$sadala=str_replace("\"","&quot;",$_POST["sadala"]);
	$sadala=str_replace("\'","",$sadala);
	$sadala=str_replace("'","",$sadala);
	$sadala=trim($sadala);

	
	$rakstam=mysqli_query($result_db,"update texts set text_lv='$teksts_lv', text_ru='$teksts_ru', text_en = '$teksts_en', text_ee = '$teksts_ee', text_lt = '$teksts_lt', description='$apraksts', category='$sadala' where id='$_GET[name]'");
	
	$links = "index.php?lang=$lang&ver=$ver";
	header("Location: $links");
	exit;
	
}

if(!isset($_POST["submit"]))
{
	$teksts_lt=$rop["text_lt"];
	$teksts_ee=$rop["text_ee"];
	$teksts_lv=$rop["text_lv"];
	$teksts_ru=$rop["text_ru"];
	$teksts_en=$rop["text_en"];
	$apraksts=$rop["description"];
	$sadala=$rop["category"];
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
                     <td height="30" valign="top" class="sad"><a href="mainit.php<?php echo $li1."&name=$_GET[name]"; ?>" class="sad_link"><?php echo $text[3]; ?></a></td>
                  </tr>
                </table>
            
            
					<form name="jaunumi" enctype="multipart/form-data" action="mainit.php<?php echo "$li1&name=$_GET[name]"; ?>" method="post">
						<table cellpadding="3" cellspacing="2" width="100%" style="border: 1px solid #d0d2dd">
                     <tr>
                     	<td class="standart" bgcolor="#f2f3f7" colspan="8"><b><?php echo $text[4]; ?></b></td>
                  	</tr>
							<tr>
								<td valign="middle" align="right" class="standart"><b><?php echo $text[0]; ?></b></td>
								<td valign="middle" class="text1"><input type="text" name="teksts_lv" style="width: 500px" class="input" value="<?php echo $teksts_lv; ?>"></td>
							</tr>
							<tr>
								<td valign="middle" align="right" class="standart"><b><?php echo $text[11]; ?></b></td>
								<td valign="middle" class="text1"><input type="text" name="teksts_ee" style="width: 500px" class="input" value="<?php echo $teksts_ee; ?>"></td>
							</tr>
							
                    		 <tr>
								<td valign="middle" align="right" class="standart"><b><?php echo $text[12]; ?></b></td>
								<td valign="middle" class="text1"><input type="text" name="teksts_lt" style="width: 500px" class="input" value="<?php echo $teksts_lt; ?>"></td>
							</tr>
							<tr>
								<td valign="middle" align="right" class="standart"><b><?php echo $text[2]; ?></b></td>
								<td valign="middle" class="text1"><input type="text" name="teksts_ru" style="width: 500px" class="input" value="<?php echo $teksts_ru; ?>"></td>
							</tr>
                            <tr>
								<td valign="middle" align="right" class="standart"><b><?php echo $text[1]; ?></b></td>
								<td valign="middle" class="text1"><input type="text" name="teksts_en" style="width: 500px" class="input" value="<?php echo $teksts_en; ?>"></td>
							</tr>
							<tr>
								<td valign="middle" align="right" class="standart"><b><?php echo $text[8]; ?></b></td>
								<td valign="middle" class="t_10"><textarea name="apraksts" class="input" rows="5" cols="60"><?php echo $apraksts; ?></textarea></td>
							</tr>
							<tr>
								<td valign="middle" align="right" class="standart"><b><?php echo $text[9]; ?></b></td>
								<td valign="middle" class="text1"><input type="text" name="sadala" style="width: 200px" class="input" value="<?php echo $sadala; ?>"></td>
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


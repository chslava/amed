<?php
//ielādējam funkcijas
require_once("config.php");
//pārbaudam, vai lietotājs ir reģistrējies
require_once($wolf_path."check.php");

$name_lang = "name_".$ver;
$text_lang = "text_".$ver;

$ren=mysql_query("Select * from items where id='$name'");
$row=mysql_fetch_array($ren);
if($row['copy'] > 0)
{
    $query = mysql_query("select * from items where id='$row[copy]'");
    $mysql = mysql_fetch_array($query);
    $nosaukums = $mysql[$name_lang];
	$apraksts = $mysql[$text_lang];
}
else
{	
	$nosaukums = $row[$name_lang];
	$apraksts = $row[$text_lang];
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
				
               <table cellpadding="0" cellspacing="0" border="0" width="100%">
                  <tr>
                     <td height="30" valign="top" class="sad"><a href="p_dzest.php<?php echo $li."&name=$name"; ?>" class="sad_link"><?php echo $item[0]; ?></a></td>
                  </tr>                  
                </table>
					<table cellpadding="5" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd" width="100%">
						<tr>
							<td valign="middle" class="standart"><?php echo $pr[62]; ?></td>
						</tr>
						<tr>
							<td valign="middle"><INPUT TYPE=Button VALUE="<?php echo $teksti[35];?>" class=button onclick='go("index.php<?php echo $li."&limit=$limit"; ?>")' style="margin:0px;"> <input type="Button" value="<?php echo $teksti[31]; ?>" class="button" onclick='go("p_dzest_ok.php<?php echo $li."&name=$name"; ?>")'></td>
						</tr>
                  <tr>
							<td valign="middle">
                     	<table cellpadding="3" cellspacing="2">
									<tr>
										<td class="standart"><b><?php echo $nosaukums; ?></b></td>
									</tr>
                           <tr>
										<td class="standart"><?php echo $apraksts; ?></td>
									</tr>                           
								</table>                     
                     </td>
						</tr>
					</table>
               
				</td>
			</tr>
		</table>
	</body>
</html>


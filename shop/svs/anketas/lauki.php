<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
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
				$ren=mysql_query("Select * from anketas where id='$name'");
				$row=mysql_fetch_array($ren);
				mysql_free_result($ren);
				
				?>
					<table cellpadding="3" cellspacing="0" border="0" width="100%">
						<tr>
	  					<td class="text1" colspan="2"></td>
						</tr>
   				</table>
					<table><tr><td></td></tr></table>
					<table width="100%" cellpadding="3" cellspacing="2" border="0" style="border: 1px solid #d0d2dd">
      			<tr>
       				<td bgcolor="#f2f3f7" colspan="6">
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr>
										<td class="standart"><b><?php echo $sabloni[15].": \"".$row["name"]."\""; ?></b></td>
										<td align="right"><INPUT TYPE="Button" VALUE="<?php echo $sabloni[74]; ?>" class="button1" onclick='go("<?php echo "lauks_pievienot.php$li1&name=$name"; ?>")'></td>
									</tr>
								</table>
							</td>
      			</tr>
					<?php 
					$a=1;
					$rez=mysql_query("Select * from anketas where parent_id='$name' order by place asc");
					while($roz=mysql_fetch_array($rez))
					{
						echo"
							<tr>
								<td class=\"st1\" valign=\"middle\"><b>$a. $roz[field_name]</b></td>
								<td class=\"st1\" valign=\"middle\">";
								
								// Nekas nav atzīmēts
								if($roz["field_type"]=="0")
								{
									echo "&nbsp;";
								}
								// Izkrītošā izvēlne
								if($roz["field_type"]=="1")
								{
									echo "<select  class=input>";
									$list=explode("\n",$roz["field_value"]);	$sas=count($list);$b=0;
									while($b<$sas)
									{
										echo "<option>$list[$b]</option>";
										$b++;
									}
									echo "</select>";
								}
								// Checkbox
								if($roz["field_type"]=="2")
								{
									echo "<input type=\"Checkbox\" class=\"ch\">";
								}
								// Vienas rindas teksta lauks
								if($roz["field_type"]=="3")
								{
									echo "<input type=\"text\" class=\"input\" maxlength=\"$roz[field_width]\" style=\"width:$roz[field_width]px;\">";
								}
								// Vairāku rindu teksta lauks
								if($roz["field_type"]=="4")
								{
									echo "<textarea class=\"input\"  style=\"width:$roz[field_width]px;\" rows=\"4\"></textarea>";
								}
								// Atstarpe
								if($roz["field_type"]=="5")
								{
									echo "$sabloni[49]";
								}
								
	
	
echo "</td>
<td class=st1 width=\"50\"><INPUT TYPE=\"Button\" VALUE=\"$sabloni[40]\" class=button onclick='go(\"lauks_mainit.php$li1&name=$name&k=$roz[id]\")'></td>
<td class=st1 width=\"50\"><INPUT TYPE=\"Button\" VALUE=\"$sabloni[41]\" class=button onclick='go(\"lauks_dzest.php$li1&name=$name&k=$roz[id]\")'></td>
<td class=st1 width=\"20\"><a href=\"lauks_up.php$li1&name=$name&k=$roz[id]&iz=$roz[place]\"><img src=\"".$wolf_path."img/up.gif\" vspace=1 border=0></a></td>
<td class=st1 width=\"20\"><a href=\"lauks_down.php$li1&name=$name&k=$roz[id]&iz=$roz[place]\"><img src=\"".$wolf_path."img/down.gif\" vspace=1 border=0></a></td></tr>";
$a++;
}

if($a==1){
$dis="disabled";
echo "<tr>
<td colspan=3 class=\"standart\">$sabloni[19]</td></tr>";
}
@mysql_free_result($rez);
?>

    			</table>
					<table cellpadding="0" cellspacing="0" border="0" height="10"><tr><td></td></tr></table>
					<table cellpadding="0" cellspacing="0" border="0">
						<tr>
	  					<td class="text1" colspan="2"><INPUT TYPE=Button VALUE="<?php echo $sabloni[16];?>" class=button onclick='go("index.php<?php echo $li1; ?>")'>&nbsp;<INPUT TYPE=Button VALUE="<?php echo $sabloni[17];?>" class=button onclick='go("index.php<?php echo $li1; ?>")'></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>


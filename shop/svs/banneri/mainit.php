<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

$rep=mysqli_query($result_db,"Select * from banners where id='$name'");
$rop=mysqli_fetch_array($rep);
mysqli_free_result($rep);

if(isset($_POST["submit"])){

$change_from=array("\"","\'","'","\\");
$change_to=array("&quot;","","","");

$sdd=$_POST["sdd"];
$smm=$_POST["smm"];
$syy=$_POST["syy"];

$bdd=$_POST["bdd"];
$bmm=$_POST["bmm"];
$byy=$_POST["byy"];

$langs = "";

if(isset($_POST["lang_1"]))
{
	if($_POST["lang_1"] == "on")
	{
		$langs .= "*lv*";
	}
}

if(isset($_POST["lang_2"]))
{
	if($_POST["lang_2"] == "on")
	{
		$langs .= "*ru*";
	}
}

if(isset($_POST["lang_3"]))
{
	if($_POST["lang_3"] == "on")
	{
		$langs .= "*en*";
	}
}

if(isset($_POST["lang_4"]))
{
	if($_POST["lang_4"] == "on")
	{
		$langs .= "*ee*";
	}
}

if(isset($_POST["lang_5"]))
{
	if($_POST["lang_5"] == "on")
	{
		$langs .= "*lt*";
	}
}

if($sdd==""||$smm==""||$syy==""){$w1="off";}else{$w1="on";}
if($bdd==""||$bmm==""||$byy==""){$w2="off";}else{$w2="on";}
if(empty($_POST["novietojums"])){$w4="off";}else{$w4="on";}
$saite_lv=str_replace($change_from,$change_to,$_POST["saite_lv"]);$saite_lv=trim($saite_lv);
$saite_ru=str_replace($change_from,$change_to,$_POST["saite_ru"]);$saite_ru=trim($saite_ru);
$saite_en=str_replace($change_from,$change_to,$_POST["saite_en"]);$saite_en=trim($saite_en);
$saite_ee=str_replace($change_from,$change_to,$_POST["saite_ee"]);$saite_ee=trim($saite_ee);
$saite_lt=str_replace($change_from,$change_to,$_POST["saite_lt"]);$saite_lt=trim($saite_lt);

$formats = str_replace($change_from,$change_to,$_POST["formats"]);
$novietojums = str_replace($change_from,$change_to,$_POST["novietojums"]);


$change_from=array("�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�");
$change_to=array("a","c","e","g","i","k","l","n","s","u","z","A","C","E","G","I","K","L","N","S","U","Z");
$file=$_FILES["fails"]["tmp_name"];
$filenameo=$_FILES["fails"]["name"];
$filename=str_replace($change_from,$change_to,$filenameo);

if(empty($filename)){$w7="off";}else{$w7="on";}


if($w1=="on" && $w2=="on" && $w4=="on" ){


$datums=mktime(0,0,0,$smm,$sdd,$syy);
$bdatums=mktime(0,0,0,$bmm,$bdd,$byy);


if($w7=="on"){

$string=$filename.$datums;
$length=10;
$string=md5($string.$datums);
$stringlength=strlen($string);
srand((double) microtime()*1000000);
$begin=rand(0,($stringlength-$length-1));
$ups=substr($string,$begin,$length); 




move_uploaded_file($file,"../../banners/$ups$filename");
chmod("../../banners/$ups$filename", 0777);
$datnes_f=", datne='$ups$filename'";

$filex="../../banners/$rop[datne]";
unlink($filex);
}
else{
$datnes_f="";
}

$notik="";
if(isset($_POST["lv_category"]))
{
	foreach($_POST["lv_category"] as $key => $value)
	{
		$notik=$notik."*".$value."*";
	}
}
if(isset($_POST["ru_category"]))
{
	foreach($_POST["ru_category"] as $key => $value)
	{
		$notik=$notik."*".$value."*";
	}
}
if(isset($_POST["en_category"]))
{
	foreach($_POST["en_category"] as $key => $value)
	{
		$notik=$notik."*".$value."*";
	}
}

if(isset($_POST["ee_category"]))
{
	foreach($_POST["ee_category"] as $key => $value)
	{
		$notik=$notik."*".$value."*";
	}
}

if(isset($_POST["lt_category"]))
{
	foreach($_POST["lt_category"] as $key => $value)
	{
		$notik=$notik."*".$value."*";
	}
}

$rakstam=mysqli_query($result_db,"update banners set sdat='$datums', bdat='$bdatums', novietojums='$novietojums', formats='$formats', saite_lv='$saite_lv', saite_ru='$saite_ru', saite_en='$saite_en', saite_lt='$saite_lt',saite_ee='$saite_ee', lang='$langs', category = '$notik' $datnes_f where id='$name'");



$links = $wolf_path."banneri/index.php$li1";
header("Location: $links");
exit;

} 

$izmers=$_POST["izmers"];
$formats=$_POST["formats"];
$saite=$_POST["saite"];
$lietotajs=$_POST["lietotajs"];
$novietojums=$rop["novietojums"];

$sdd=$_POST["sdd"];
$smm=$_POST["sdd"];
$syy=$_POST["syy"];

$bdd=$_POST["bdd"];
$bmm=$_POST["bmm"];
$byy=$_POST["byy"];
}

if(!isset($_POST["submit"])){

$w1=$w2=$w3=$w4=$w5=$w7=$w9=$w10="";

$sdd=date("d");
$smm=date("m");
$syy=date("Y");

$formats=$rop["formats"];
$saite_lv=$rop["saite_lv"];
$saite_ru=$rop["saite_ru"];
$saite_en=$rop["saite_en"];
$saite_ee=$rop["saite_ee"];
$saite_lt=$rop["saite_lt"];

$lietotajs=$rop["user"];
$novietojums=$rop["novietojums"];

$sdd=date("d", $rop["sdat"]);
$smm=date("m", $rop["sdat"]);
$syy=date("Y", $rop["sdat"]);

$bdd=date("d", $rop["bdat"]);
$bmm=date("m", $rop["bdat"]);
$byy=date("Y", $rop["bdat"]);

$notikumi = explode("*",$rop["category"]);
$not=array();
$c=count($notikumi);
							
for($v=0;$v<$c;$v++)
{	
	$k = $notikumi[$v];
	$not[$k] = $k;
}

$lang_1 = 1;
$lang_2 = 1;
$lang_3 = 1;
$lang_4 = 1;
$lang_5 = 1;
$langs = explode("**",$rop["lang"]);

for($c=0;$c<count($langs);$c++)
{
	$val = trim(str_replace("*","",$langs[$c]));
	if($val == "lv")
	{
		$lang_1 = 2;
	}
	if($val == "ru")
	{
		$lang_2 = 2;
	}
	if($val == "en")
	{
		$lang_3 = 2;
	}	
	if($val == "ee")
	{
		$lang_4 = 2;
	}	
	if($val == "lt")
	{
		$lang_5 = 2;
	}
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
				
					<form name="banner" enctype="multipart/form-data" action="mainit.php<?php echo $li."&name=$name"; ?>" method="post">
               <table cellpadding="0" cellspacing="0" border="0" width="100%">
                  <tr>
                     <td valign="top" class="sad"><a href="index.php<?php echo $li1; ?>" class="sad_link"><?php echo $banneri[77]; ?></a> <img src="<?php echo $wolf_path; ?>img/next.gif" align="absmiddle"> <a href="mainit.php<?php echo $li."&name=$name"; ?>" class="sad_link"><?php echo $banneri[79]; ?></a></td>
                  </tr>
                  <tr>
		 				  <td>&nbsp;</td>
	   				</tr>
               </table>
					<table cellpadding="3" cellspacing="2" style="border: 1px solid #d0d2dd" width="100%">
						<tr>
	  					<td class="standart" bgcolor="#f2f3f7" colspan="7"><b><?php echo $banneri[64]; ?></b></td>
	  				</tr>
						<?php if($w1=="off"){ echo "<tr><td valign=\"top\" colspan=\"2\" class=\"sarkanst\">$banneri[28]</td></tr>";}?>
						<?php if($w2=="off"){ echo "<tr><td valign=\"top\" colspan=\"2\" class=\"sarkanst\">$banneri[29]</td></tr>";}?>
						<?php if($w4=="off"){ echo "<tr><td valign=\"top\" colspan=\"2\" class=\"sarkanst\">$banneri[31]</td></tr>";}?>
						<?php if($w5=="off"){ echo "<tr><td valign=\"top\" colspan=\"2\" class=\"sarkanst\">$banneri[32]</td></tr>";}?>
						
						<?php if($w7=="off"){ echo "<tr><td valign=\"top\" colspan=\"2\" class=\"sarkanst\">$banneri[34]</td></tr>";}?>
						
						<tr>
			<td align="right" class="standart"><b><?php echo $banneri[1]; ?></b></td>
			<td><?php echo "<input type=text name=sdd size=2 value=$sdd class=input>-<input type=text name=smm size=2 value=$smm class=input>-<input type=text name=syy size=4 value=$syy class=input>"; ?></td>
		</tr>
		<tr>
			<td align="right" class="standart"><b><?php echo $banneri[2]; ?></b></td>
			<td><?php echo "<input type=text name=bdd size=2 value=\"$bdd\" class=input maxlength=2>-<input type=text name=bmm size=2 value=\"$bmm\" class=input maxlength=2>-<input type=text name=byy size=4 value=\"$byy\" class=input maxlength=4>"; ?></td>
		</tr>
		<tr>
			<td valign="middle" align="right" class="standart"><b><?php echo $banneri[6]; ?></b></td>
			<td valign="middle" class="standart"><input type="radio" name="formats" value="1" class="ch" <?php if($formats=="1"){echo "checked";} ?>><?php echo $banneri[8]; ?>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" class="ch" name="formats" value="2" <?php if($formats=="2"){echo "checked";} ?>><?php echo $banneri[7]; ?></td>
		</tr>
<tr>
						<td valign="middle" align="right" class="standart"><b><?php echo $banneri[3]; ?></b></td>
						<td valign="middle" class="standart">
						<input type="radio" name="novietojums" value="1" class="ch" <?php if($novietojums=="1"){echo "checked";} ?>><?php echo $banneri[68]; ?>&nbsp;&nbsp;&nbsp;
                     <input type="radio" name="novietojums" value="2" <?php if($novietojums=="2"){echo "checked";} ?>><?php echo $banneri[69]; ?>&nbsp;&nbsp;&nbsp;                  </td>
					</tr>
               <tr>
						<td valign="middle" align="right" class="standart"><b><?php echo $banneri[81]; ?></b></td>
						<td class="standart">
                  	<input type="checkbox" name="lang_1" class="input" <?php if($lang_1 == 2) {echo " checked";} ?>> <?php echo $banneri[74]; ?>&nbsp;&nbsp;&nbsp;
                     <input type="checkbox" name="lang_2" class="input" <?php if($lang_2 == 2) {echo " checked";} ?>> <?php echo $banneri[75]; ?>&nbsp;&nbsp;&nbsp;
                     <input type="checkbox" name="lang_3" class="input" <?php if($lang_3 == 2) {echo " checked";} ?>> <?php echo $banneri[76]; ?>&nbsp;&nbsp;&nbsp;
                     <input type="checkbox" name="lang_4" class="input" <?php if($lang_4 == 2) {echo " checked";} ?>> <?php echo $head[5]; ?>&nbsp;&nbsp;&nbsp;
                     <input type="checkbox" name="lang_5" class="input" <?php if($lang_5 == 2) {echo " checked";} ?>> <?php echo $head[6]; ?>&nbsp;&nbsp;&nbsp;
                  </td>
					</tr>
		
					<tr>
						<td valign="middle" align="right" class="standart"><b><?php echo $banneri[14]; ?></b></td>
						<td><input type="file" class="input" name="fails"></td>
					</tr>
               <tr>
	  					<td class="standart" bgcolor="#f2f3f7" colspan="7"><b><?php echo $banneri[9]; ?></b></td>
	  				</tr>
	  				<tr>
						<td valign="middle" align="right" class="standart"><b><?php echo $banneri[74]; ?></b></td>
						<td><input type="text" name="saite_lv" class="input" value="<?php echo $saite_lv; ?>" style="width:300px;"></td>
					</tr>
	  				<tr>
						<td valign="middle" align="right" class="standart"><b><?php echo $head[5]; ?></b></td>
						<td><input type="text" name="saite_ee" class="input" value="<?php echo $saite_ee; ?>" style="width:300px;"></td>
					</tr>
					
					<tr>
						<td valign="middle" align="right" class="standart"><b><?php echo $head[6]; ?></b></td>
						<td><input type="text" name="saite_lt" class="input" value="<?php echo $saite_lt; ?>" style="width:300px;"></td>
					</tr>
               <tr>
						<td valign="middle" align="right" class="standart"><b><?php echo $banneri[75]; ?></b></td>
						<td><input type="text" name="saite_ru" class="input" value="<?php echo $saite_ru; ?>" style="width:300px;"></td>
					</tr>
               <tr>
						<td valign="middle" align="right" class="standart"><b><?php echo $banneri[76]; ?></b></td>
						<td><input type="text" name="saite_en" class="input" value="<?php echo $saite_en; ?>" style="width:300px;"></td>
					</tr>
					
					
               <?php
                  	function sub_cat($cat_id,$category,$cat_name)
							{
								global $result_db;
								$mysql1 = mysqli_query($result_db,"select * from content where parent_id = '$cat_id' order by place asc");
								while($cat1 = mysqli_fetch_array($mysql1))
								{	
									$parent_name = $cat_name." $cat1[name]";
									$item_id = $cat1["id"];	
									if(isset($category[$item_id]))
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
								global $result_db;
								$mysql = mysqli_query($result_db,"select * from content where parent_id = '0' order by place asc");
								while($cat = mysqli_fetch_array($mysql))
								{	
									$cat_id = $cat["id"];
									if(isset($category[$cat_id]))
									{
										$se = " selected";
									}
									else
									{
										$se = "";
									}
									echo "<option value=\"$cat[id]\"$se>$cat[name]</option>\n";
									$cat_name = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";	
									sub_cat($cat["id"],$category,$cat_name);						
								}
								mysqli_free_result($mysql);
							}
						?>
                  <tr>
                     <td class="standart" bgcolor="#f2f3f7" colspan="7"><b><?php echo $banneri[87]; ?></b></td>
                  </tr>
                  <tr>
                     <td valign="middle" align="right" class="standart"><b><?php echo $banneri[88]; ?></b></div></td>
                     <td valign="middle">
                     <select name="lv_category[]" multiple class="input" style="width:300px;" size="10">
                        <option value="0"></option>
                     	<?php sub_cats($not); ?>
                     </select>
                     </td>
                  </tr>					<tr>
							<td valign="top" align="right"><INPUT TYPE=Button VALUE="<?php echo $jaunumi[36];?>" class=button onclick='go("<?php echo $wolf_path; ?>banneri/index.php<?php echo $li1; ?>")'></td>
							<td><input type="Submit" value="<?php echo $teksti[28]; ?>" class="button" name="submit"></td>
						</tr>
					</table>
					</form>
					
				</td>
			</tr>
		</table>
	</body>
</html>


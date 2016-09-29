<?php
//iel�d�jam funkcijas
require_once("../config.php");
if($ar > 0){header("Location: member.php$li");	exit;}
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

$ren=mysqli_query($result_db,"Select * from user where id='$_GET[name]'");
$row=mysqli_fetch_array($ren);
mysqli_free_result($ren);

	
if(isset($_POST["submit"])){
	
	$error = "";
	
	$lietotajs=str_replace("\"","&quot;",$_POST["lietotajs"]);
	$lietotajs=str_replace("\'","",$lietotajs);
	$lietotajs=str_replace("'","",$lietotajs);
	$lietotajs=trim($lietotajs);
	if(empty($lietotajs))
	{
		$error = $error.$lietotaji[8]."<br>";
	}
	
	$parole1=str_replace("\"","&quot;",$_POST["parole1"]);
	$parole1=str_replace("\'","",$parole1);
	$parole1=str_replace("'","",$parole1);
	$parole1=trim($parole1);
	if(empty($parole1))
	{
		$error = $error.$lietotaji[9]."<br>";
	}
	
	$parole2=str_replace("\"","&quot;",$_POST["parole2"]);
	$parole2=str_replace("\'","",$parole2);
	$parole2=str_replace("'","",$parole2);
	$parole2=trim($parole2);
	if(empty($parole2))
	{
		$error = $error.$lietotaji[10]."<br>";
	}


	if($error =="")
	{
		$ren=mysqli_query($result_db,"Select * from user where id!='$_GET[name]'");
		while($row=mysqli_fetch_array($ren))
		{
			if($row["username"]==$lietotajs)
			{
			$error = $error.$lietotaji[11];
			}
		}
		
		if($parole1!=$parole2)
		{
				$error= $error.$lietotaji[12]."<br>";
		}
		
		if($error == "")
		{
		$rr=mysqli_query($result_db,"Select * from user where id='$_GET[name]'");
			$rrr=mysqli_fetch_array($rr);
			$useris=$rrr["username"];
			mysqli_free_result($rr);
			
			$password=md5($parole1);
			$password=md5($password);
			$result = mysqli_query($result_db,"update user set username='$lietotajs', password='$password' where id='$_GET[name]'"); 
			
			
			$cik = count($valodas);

			$s=0;
			while($s<$cik)
			{
				$tab="sadalas_".$valodas[$s];
				$rr=mysqli_query($result_db,"Select * from $tab");
				while($rrr=mysqli_fetch_array($rr))
				{
					$info=$rrr["user"];
					$info=str_replace("$useris","$lietotajs",$info);
					$ziel=mysqli_query($result_db,"update $tab set user='$info' where id='$rrr[id]'"); 
				}
			mysqli_free_result($rr);
			$s++;
			}
		
			$links = $wolf_path."users/index.php";
			header("Location: $links");
			exit;
		}
	}
}
else{
$lietotajs = $row["username"];
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
								$ren=mysqli_query($result_db,"Select * from user where id='$_GET[name]'");
								$ros=mysqli_fetch_array($ren);
								mysqli_free_result($ren);
								?>
								<table cellpadding="3" cellspacing="2" width="100%" style="border: 1px solid #d0d2dd">
								<form action="<?php echo $wolf_path; ?>users/apstiprinat.php<?php echo $li1."&name=".$_GET["name"]; ?>" method="post" name="pievienot">
	 								<tr>
	  								<td bgcolor="#f2f3f7" colspan="7" class="standart"><?php echo $lietotaji[19]."<b><u>".$ros["username"]; ?></u></b></td>
	  							</tr>
									<?php 

$krasa=array("#ffffff","#fafbfe");
$kr=0;

function sad($parent_id,$atstarpe,$user,$tabula)
{
	global $result_db;
	$r1=mysqli_query($result_db,"Select * from $tabula where parent_id='$parent_id' order by place asc");
	while($f1=mysqli_fetch_array($r1))
	{
	$ch2="";
	echo "<input class=\"ch\" type=\"Checkbox\" name=\"vvv[]\" value=\"$f1[id]\"";
	$file2=explode("*",$f1["user"]);
	for ($s2=0; $s2<count($file2); $s2++){
	$lin2=each ($file2);
		if($lin2["value"]==$user){ $ch2="checked";}
		
	}
	if($ch2=="checked"){$ch2="";}else{$ch2="checked";}
echo" $ch2>$f1[name]<ul>\n";
$ch2="";
		$indent="";
			sad($f1["id"],$indent,$user,$tabula);
echo "</ul>\n";
	}
}

	$r=mysqli_query($result_db,"Select * from $tabula where parent_id='0' order by place asc");
	while($f=mysqli_fetch_array($r))
	{
	$ch1="";
		echo "<tr bgcolor=\"$krasa[$kr]\"><td width=100% class=\"standart\"><input class=\"ch\" type=\"Checkbox\" name=\"vvv[]\" value=\"$f[id]\"";
		$file1=explode("*",$f["user"]);
		for ($s1=0; $s1<count($file1); $s1++)
		{
			$lin1=each ($file1);
			if($lin1["value"]==$ros["username"]){	$ch1="checked";	}
		}
		if($ch1=="checked"){$ch1="";}else{$ch1="checked";}
		echo " $ch1><b>$f[name]</b><ul>\n";
		$ch1="";
		sad($f["id"],$indent,$ros["username"],$tabula);
		echo "</ul></td></tr>";
		if($kr==0){	$kr=1;}
		elseif($kr==1){	$kr=0;}
	}
mysqli_free_result($r)





?>

	   </table>
	   <table cellpadding="2" cellspacing="0" border="0" width="100%"> 
	   <tr>
	 	   <td valign="top">&nbsp;</td>
	  </tr>
	
   </table>
    
    
	<table cellpadding="3" cellspacing="1" border="0" width="100%" bgcolor="#ffffff" class="st1"> 
	  	<tr>
       		<td bgcolor="#f2f3f7" class="standart"><?php echo $lietotaji[30]." <b><u>".$ros["username"]; ?></u></b></td>
	  	</tr>
		<?php 
		$kr=0;if($ros["module_1"] == "on"){$ch="checked";}else{$ch="";}
		echo "
		<tr bgcolor=\"$krasa[$kr]\">
			<td width=100% class=\"standart\"><input type=\"Checkbox\" name=\"module_1\" $ch>&nbsp;<b>$menu_it[3]</b></td>
		</tr>";
		?>
        
        <?php 
		$kr=1;if($ros["module_2"] == "on"){$ch="checked";}else{$ch="";}
		echo "
		<tr bgcolor=\"$krasa[$kr]\">
			<td width=100% class=\"standart\"><input type=\"Checkbox\" name=\"module_2\" $ch>&nbsp;<b>$menu_it[7]</b></td>
		</tr>";
		?>
        
        <?php 
		$kr=0;if($ros["module_3"] == "on"){$ch="checked";}else{$ch="";}
		echo "
		<tr bgcolor=\"$krasa[$kr]\">
			<td width=100% class=\"standart\"><input type=\"Checkbox\" name=\"module_3\" $ch>&nbsp;<b>$menu_it[8]</b></td>
		</tr>";
		?>
        
        <?php 
		$kr=0;if($ros["module_4"] == "on"){$ch="checked";}else{$ch="";}
		echo "
		<tr bgcolor=\"$krasa[$kr]\">
			<td width=100% class=\"standart\"><input type=\"Checkbox\" name=\"module_4\" $ch>&nbsp;<b>$menu_it[14]</b></td>
		</tr>";
		?>
        
        <?php 
		$kr=0;if($ros["module_5"] == "on"){$ch="checked";}else{$ch="";}
		echo "
		<tr bgcolor=\"$krasa[$kr]\">
			<td width=100% class=\"standart\"><input type=\"Checkbox\" name=\"module_5\" $ch>&nbsp;<b>$menu_it[29]</b></td>
		</tr>";
		?>
        
        <?php 
		$kr=0;if($ros["module_6"] == "on"){$ch="checked";}else{$ch="";}
		echo "
		<tr bgcolor=\"$krasa[$kr]\">
			<td width=100% class=\"standart\"><input type=\"Checkbox\" name=\"module_6\" $ch>&nbsp;<b>$menu_it[24]</b></td>
		</tr>";
		?>
		
		<?php 
		$kr=0;if($ros["module_7"] == "on"){$ch="checked";}else{$ch="";}
		echo "
		<tr bgcolor=\"$krasa[$kr]\">
			<td width=100% class=\"standart\"><input type=\"Checkbox\" name=\"module_7\" $ch>&nbsp;<b>$menu_it[23]</b></td>
		</tr>";
		?>
		
		<?php 
		$kr=0;if($ros["module_8"] == "on"){$ch="checked";}else{$ch="";}
		echo "
		<tr bgcolor=\"$krasa[$kr]\">
			<td width=100% class=\"standart\"><input type=\"Checkbox\" name=\"module_8\" $ch>&nbsp;<b>$menu_it[12]</b></td>
		</tr>";
		?>
		
		<?php 
		$kr=0;if($ros["module_9"] == "on"){$ch="checked";}else{$ch="";}
		echo "
		<tr bgcolor=\"$krasa[$kr]\">
			<td width=100% class=\"standart\"><input type=\"Checkbox\" name=\"module_9\" $ch>&nbsp;<b>$menu_it[13]</b></td>
		</tr>";
		?>
		
		<?php 
		$kr=0;if($ros["module_10"] == "on"){$ch="checked";}else{$ch="";}
		echo "
		<tr bgcolor=\"$krasa[$kr]\">
			<td width=100% class=\"standart\"><input type=\"Checkbox\" name=\"module_10\" $ch>&nbsp;<b>$menu_it[21]</b></td>
		</tr>";
		?>
        
        
   	</table>
    
    
    
	  <table cellpadding="2" cellspacing="0" border="0" width="100%"> 
	   <tr>
	 	   <td valign="top">&nbsp;</td>
	  </tr>
	
   </table>
	   <table cellpadding="3" cellspacing="1" border="0" width="100%" bgcolor="#ffffff" class="st1"> 
	   <tr>
	  								<td bgcolor="#f2f3f7" class="standart"><?php echo $lietotaji[20]."<b><u>".$ros["username"]; ?></u></b></td>
	  							</tr>
	<?php 
$cik=count($valodas);
$kr=0;
$o=0;
while($o<$cik){
$ch="";
echo "<tr bgcolor=\"$krasa[$kr]\"><td width=100% class=\"standart\"><input type=\"Checkbox\" name=\"valodas_$valodas[$o]\" value=\"$valodas[$o]\"";
	$file=explode("*",$ros["lang"]);
	for ($s1=0; $s1<count($file); $s1++){
	$lin=each ($file);
	if($lin["value"]==$valodas[$o]){ $ch="checked";}
	}
	if($ch=="checked"){$ch="";}else{$ch="checked";}
	$c = $valodas[$o];
	echo " $ch>&nbsp;<b>$nosaukumi[$c]</b>\n";
	$ch="";
echo "</td></tr>";
$o++;
}

if($kr==0){	$kr=1;}
elseif($kr==1){	$kr=0;}
	?>
   </table>
	  <table cellpadding="2" cellspacing="0" border="0" width="100%"> 
	   <tr>
	 	   <td valign="top">&nbsp;</td>
	  </tr>
	
   </table>
	
								<input type="Hidden" name="valo" value="<?php echo "$o"; ?>">
								<table cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td><INPUT TYPE=Button VALUE="<?php echo $lietotaji[13];?>" class=button onclick='go("<?php echo $wolf_path; ?>users/index.php<?php echo $li1; ?>")'>&nbsp;<input type="Submit" name="submit" value="<?php echo $lietotaji[21] ?>" class="button"></td>
									</tr></form>
								</table>
								
								
								<table cellpadding="2" cellspacing="0" border="0" width="100%"> 
	   <tr>
	 	   <td valign="top">&nbsp;</td>
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


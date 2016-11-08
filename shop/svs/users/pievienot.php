<?php
//iel�d�jam funkcijas
require_once("../config.php");
if($ar > 0){header("Location: ".$wolf_path."member.php$li");	exit;}
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");
$error = "";
if(isset($_POST["submit"])){
	
	
	
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
		$ren=mysqli_query($result_db,"Select * from user");
		while($row=mysqli_fetch_array($ren))
		{
			if($row["username"]==$lietotajs)
			{
				$error= $error.$lietotaji[11]."<br>";
			}
		}
		
		if($parole1!=$parole2)
		{
				$error= $error.$lietotaji[12]."<br>";
		}

		if($error == "")
		{
			$password=md5($parole1);
			$password=md5($password);
			
			$val="";
			$s1=0;
			$cik=count($valodas);
			while($s1<$cik)
			{
				$val = $val.$valodas[$s1]."*";
			$s1++;
			}
	
			$result = mysqli_query($result_db,"INSERT INTO user VALUES (null, '$lietotajs', '$password','no','','','$val','off','off','off','off','off','off','off','off','off','off')"); 

			$cik =count($valodas);
			$s=0;
			while($s<$cik)
			{
				$tab="content";
				$rr=mysqli_query($result_db,"Select * from $tab");
				while($rrr=mysqli_fetch_array($rr))
				{
					$info=$rrr["user"].$lietotajs."*";
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
else
{
$lietotajs ="";
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
					
					<table cellpadding="0" cellspacing="0" border="0" style="border: 1px solid #d0d2dd" width="100%">
	 					<tr>
	   					<td>
				
								<table cellpadding="3" cellspacing="1" border="0" width="100%">
	 								<tr>
	   								<td bgcolor="#f2f3f7" class="standart"><b><?php echo $lietotaji[3]; ?></b></td>
	  							</tr>
									<tr>
	   								<td>&nbsp;</td>
	  							</tr>
									
									<?php
										if ($error!="")
										{
									?>
									<tr>
	   								<td>
											<table cellpadding="3" cellspacing="1" border="0">
												<tr>
													<td valign="top" class="sarkanst"><?php echo $error;?></td>
												</tr>
											</table>
										</td>
	  							</tr>
									<?php 
										}
									?>
										
									</table>
									<table cellpadding="3" cellspacing="1" border="0">
									<form action="<?php echo $wolf_path; ?>users/pievienot.php<?php echo $li; ?>" method="post" name="pievienot">
	  							<tr>
	   								<td width="120" align="right" class="standart"><b><?php echo $lietotaji[4]; ?></b></td>
	   								<td align="left"><input type="text" name="lietotajs" class="input" value="<?php echo $lietotajs; ?>"></td>
	  							</tr>
	  							<tr>
	  								<td width="120" align="right" class="standart"><b><?php echo $lietotaji[5]; ?></b></td>
	  								<td align="left"><input type="password" name="parole1" class="input"></td>
	  							</tr>
	  							<tr>
	  								<td width="120" align="right" class="standart"><b><?php echo $lietotaji[6]; ?></b></td>
	   								<td align="left"><input type="password" name="parole2" class="input"></td>
	  							</tr>
	  							<tr>
	   								<td>&nbsp;</td>
	   								<td><input type="Submit" value="<?php echo $lietotaji[7]; ?>" class="button" name="submit"></td>
	  							</tr>
									</form>
									<tr>
	   								<td colspan="2">&nbsp;</td>
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


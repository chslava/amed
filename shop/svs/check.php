<?php
$module_1 = "off";
$module_2 = "off";
$module_3 = "off";
$module_4 = "off";
$module_5 = "off";
$module_6 = "off";
$module_7 = "off";
$module_8 = "off";
$module_9 = "off";
$module_10 = "off";

$user_id = 0;
if (isset($_SESSION['valid_user']) )
{

	$laiks = time();
	$ip=$_SERVER["REMOTE_ADDR"];
	$ren=mysqli_query($result_db,"Select * from user where username='$_SESSION[valid_user]'");
	$row=mysqli_fetch_array($ren);
	mysqli_free_result($ren);

	$user_id = $row["id"];
	
	$module_1 = $row["module_1"];
	$module_2 = $row["module_2"];
	$module_3 = $row["module_3"];
	$module_4 = $row["module_4"];
	$module_5 = $row["module_5"];
	$module_6 = $row["module_6"];
	$module_7 = $row["module_7"];
	$module_8 = $row["module_8"];
	$module_9 = $row["module_9"];
	$module_10 = $row["module_10"];
	
	if($module != "0")
	{
		if($row[$module] != "on")
		{
			$links = $wolf_path."member.php";
			header("Location: $links");
			exit;
		}
	}
	// p�rbaudam, vai lietot�js ir galvenais vai n�
	$us = $row["value"];
}
else
{
	$links = $wolf_path."index.php";
	header("Location: $links");
	exit;
}
$laiks = time();
$result=mysqli_query($result_db,"update user set time='$laiks' where username='$_SESSION[valid_user]'"); 
?>
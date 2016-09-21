<?php
if(isset($_POST["remember"]))
{
	if(!empty($_POST["email"]))
	{		
		$change_from=array("'","\\");
		$change_to=array("`","");
	
		$lietotajs=str_replace($change_from,$change_to,$_POST["email"]);
		$lietotajs=trim($lietotajs);
		
		$pr=mysqli_query($result_db,"SELECT * FROM clients where email='$lietotajs'");
		$z=mysqli_num_rows($pr);
		$zz=mysqli_fetch_array($pr);
		mysqli_free_result($pr);
			
		if($z>0)
		{
			$n=10;
			$chars='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
			$x="";
			srand((double)microtime()*1000000);  
			$m=strlen($chars);  
			while($n--) 
			{ 
			$x.=substr($chars,rand()%$m,1); 
			}  
	
			$password=md5($x);
			$password=md5($password);
			
			$result = mysqli_query($result_db,"update clients set password='$password', password_changed = '1' where id='$zz[id]'");
			
			require_once("include/send-remember.php");
									
			$links = $root_dir.$_GET["lang"]."/remember-ok";
			header("Location: $links");
			exit;
		}
		else
		{
			$error[1] = 1;
		}	
	}
	else
	{
		$error[0] = 1;
		$_POST["email"] = "";
	}	
}
else
{
	$_POST["email"] = "";
}
?>
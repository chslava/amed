<?php 
if(isset($_POST["register"]))
{	
	if($_POST["person"] == 2)
	{
		if(empty($_POST["person_name"])){$error[0] = 1;}
		if(empty($_POST["person_code"])){$error[0] = 1;}
		if(empty($_POST["person_phone"])){$error[0] = 1;}
		
		if(empty($_POST["person_deliver"])){$error[0] = 1;}
		if(empty($_POST["person_user_password1"])){$error[0] = 1;}
		
		if($_POST["person_user_password1"] != $_POST["person_user_password2"])
		{
			$error[1] = 1;
		}

		if(!filter_var($_POST["person_user_email"], FILTER_VALIDATE_EMAIL))
		{
			$error[2] = 1;
		}
		
		$email = $_POST["person_user_email"];
		$pas = $_POST["person_user_password1"];	
		
	}
	else
	{
		if(empty($_POST["company_name"])){$error[0] = 1;}
		if(empty($_POST["company_code"])){$error[0] = 1;}
		if(empty($_POST["company_address"])){$error[0] = 1;}
		if(empty($_POST["company_bank"])){$error[0] = 1;}
		if(empty($_POST["company_account"])){$error[0] = 1;}
		if(empty($_POST["company_phone"])){$error[0] = 1;}
		
		if(empty($_POST["company_position"])){$error[0] = 1;}
		if(empty($_POST["company_person"])){$error[0] = 1;}
		if(empty($_POST["company_deliver"])){$error[0] = 1;}
		if(empty($_POST["company_user_password1"])){$error[0] = 1;}
		
		if($_POST["company_user_password1"] != $_POST["company_user_password2"])
		{
			$error[1] = 1;
		}
		
		if(!filter_var($_POST["company_user_email"], FILTER_VALIDATE_EMAIL))		
		{
			$error[2] = 1;
		}
		
		$email = $_POST["company_user_email"];
		$pas = $_POST["company_user_password1"];
	}	
	
	
	
	if(count($error) == 0)
	{
		$check_mail = mysql_query("select id from clients where email='$email'");
		if(mysql_num_rows($check_mail) > 0)
		{
			$error[3] = 1;
		}
		mysql_free_result($check_mail);
			
		if(count($error) == 0)
		{				
			$laiks = time();
			$ip = $_SERVER['REMOTE_ADDR'];
			$password = md5($pas);
			$password = md5($password);
				
			$n=50;
				
			$chars='abcdefghijklmnopqrstuvwxyz1234567890';
			$code="";
							
			srand((double)microtime()*1000000);  
			$m=strlen($chars);  
			while($n--) 
			{
				$code.=substr($chars,rand()%$m,1); 
			}
			
			
			$n=5;
				
			$chars='ABCDEFGHIJKLMNOPRSTQWYZ1234567890';
			$ccode="";
							
			srand((double)microtime()*1000000);  
			$m=strlen($chars);  
			while($n--) 
			{
				$ccode.=substr($chars,rand()%$m,1); 
			}
																	
			$result = mysql_query("insert into clients values (
			'',
			'$ses_id',
			'1',
			'$laiks',
			'$laiks',
			'$ip',
			'$email',
			'$password',
			'$code',
			'$_POST[person]',
			'$_POST[company_name]',
			'$_POST[company_code]',
			'$_POST[company_address]',
			'$_POST[company_bank]',
			'',
			'$_POST[company_account]',	
			'$_POST[company_phone]',
			'',
			'$_POST[company_deliver]',
			'1',
			
			'$_POST[person_name]',
			'$_POST[person_code]',
			'$_POST[person_address]',	
			'$_POST[person_phone]',
			'',
			'$_POST[person_deliver]',
			'1',
			'$_POST[company_person]',
			'$_POST[company_position]',
			'0',
			'0',
			'1',
			'$ccode',
			'0',
			'',
			'',
			'0',
			'0'
			)");
			
			require_once("include/send-registration.php");
								
			$links = $root_dir.$_GET["lang"]."/register-ok";
			header("Location: $links");
			exit;
		}
	}	
}
else
{
	$_POST["person"] = 1;
	$_POST["company_name"] = "";
	$_POST["company_code"] = "";
	$_POST["company_address"] = "";
	$_POST["company_bank"] = "";
	$_POST["company_account"] = "";
	$_POST["company_phone"] = "";
	$_POST["company_email"] = "";
	$_POST["company_deliver"] = "";
	$_POST["company_user_email"] = "";
	$_POST["company_user_password1"] = "";
	$_POST["company_user_password2"] = "";
	$_POST["company_contract"] = 1;
	$_POST["company_position"] = "";
	$_POST["company_person"] = "";
	
	$_POST["person_name"] = "";
	$_POST["person_code"] = "";
	$_POST["person_phone"] = "";
	$_POST["person_email"] = "";
	$_POST["person_deliver"] = "";
	$_POST["person_user_email"] = "";
	$_POST["person_user_password1"] = "";
	$_POST["person_user_password2"] = "";
	$_POST["person_contract"] = 1;	
}
?>
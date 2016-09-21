<?php 
if(isset($_POST["register"]))
{	
	if(isset($_POST["company_contract"])){$_POST["company_contract"] = 2;} else {$_POST["company_contract"] = 1;}
	if(isset($_POST["person_contract"])){$_POST["person_contract"] = 2;} else {$_POST["person_contract"] = 1;}
	$password = "";
	if($_POST["person"] == 2)
	{
		if(empty($_POST["person_name"])){$error[0] = 1;}
		if(empty($_POST["person_code"])){$error[0] = 1;}
		if(empty($_POST["person_phone"])){$error[0] = 1;}
		
		if(empty($_POST["person_deliver"])){$error[0] = 1;}
		if(!empty($_POST["person_user_password1"]))
		{		
			if($_POST["person_user_password1"] != $_POST["person_user_password2"])
			{
				$error[1] = 1;
			}
			$pas = $_POST["person_user_password1"];
			$password = md5($pas);
			$password = md5($password);
			$password = ', password=\''.$password.'\'';
		}

		if(!filter_var($_POST["person_user_email"], FILTER_VALIDATE_EMAIL))
		{
			$error[2] = 1;
		}
		
		$email = $_POST["person_user_email"];
	
		
	}
	else
	{
		if(empty($_POST["company_name"])){$error[0] = 1;}
		if(empty($_POST["company_code"])){$error[0] = 1;}
		if(empty($_POST["company_address"])){$error[0] = 1;}
		if(empty($_POST["company_bank"])){$error[0] = 1;}
		if(empty($_POST["company_account"])){$error[0] = 1;}
		if(empty($_POST["company_phone"])){$error[0] = 1;}
	
		if(empty($_POST["company_deliver"])){$error[0] = 1;}
		if(empty($_POST["company_position"])){$error[0] = 1;}
		if(empty($_POST["company_person"])){$error[0] = 1;}
		if(!empty($_POST["company_user_password1"]))
		{		
			if($_POST["company_user_password1"] != $_POST["company_user_password2"])
			{
				$error[1] = 1;
			}
			$pas = $_POST["company_user_password1"];
			$password = md5($pas);
			$password = md5($password);
			$password = ', password=\''.$password.'\'';
		}
		
		if(!filter_var($_POST["company_user_email"], FILTER_VALIDATE_EMAIL))		
		{
			$error[2] = 1;
		}
		
		$email = $_POST["company_user_email"];
		
	}	
	
	
	
	if(count($error) == 0)
	{
		$check_mail = mysql_query("select id from clients where email='$email' and id <> '$user_id'");
		if(mysql_num_rows($check_mail) > 0)
		{
			$error[3] = 1;
		}
		mysql_free_result($check_mail);
			
		if(count($error) == 0)
		{				
					
			$_SESSION["valid_user"] = $email;									
			$result = mysql_query("update clients set 
			
			email = '$email',
						
			person = '$_POST[person]',
			company_name = '$_POST[company_name]',
			company_code = '$_POST[company_code]',
			company_address = '$_POST[company_address]',
			company_bank = '$_POST[company_bank]',
			company_account = '$_POST[company_account]',	
			company_phone = '$_POST[company_phone]',
			
			company_deliver = '$_POST[company_deliver]',
			company_contract = '$_POST[company_contract]',
			company_person = '$_POST[company_person]',
			company_position = '$_POST[company_position]',
			
			person_name = '$_POST[person_name]',
			person_code = '$_POST[person_code]',	
			person_phone = '$_POST[person_phone]',
			
			person_deliver = '$_POST[person_deliver]',
			person_contract = '$_POST[person_contract]',
			password_changed = '0'
			$password
			
			where id = '$user_id'
			");
							
			$links = $root_dir.$_GET["lang"]."/my-data-ok";
			header("Location: $links");
			exit;
		}
	}	
}
else
{
	$_POST["person"] = $uses["person"];
	$_POST["company_name"] = $uses["company_name"];
	$_POST["company_code"] = $uses["company_code"];
	$_POST["company_address"] = $uses["company_address"];
	$_POST["company_bank"] = $uses["company_bank"];
	$_POST["company_account"] = $uses["company_account"];
	$_POST["company_phone"] = $uses["company_phone"];
	$_POST["company_email"] = $uses["company_email"];
	$_POST["company_deliver"] = $uses["company_deliver"];
	$_POST["company_user_email"] = $uses["email"];
	$_POST["company_user_password1"] = "";
	$_POST["company_user_password2"] = "";
	$_POST["company_contract"] = $uses["company_contract"];
	$_POST["company_position"] = $uses["company_position"];
	$_POST["company_person"] = $uses["company_person"];
	
	$_POST["person_name"] = $uses["person_name"];
	$_POST["person_code"] = $uses["person_code"];
	$_POST["person_phone"] = $uses["person_phone"];
	$_POST["person_email"] = $uses["person_email"];
	$_POST["person_deliver"] = $uses["person_deliver"];
	$_POST["person_user_email"] = $uses["email"];
	$_POST["person_user_password1"] = "";
	$_POST["person_user_password2"] = "";
	$_POST["person_contract"] = $uses["person_contract"];	
}
?>
<?php
$error = array();
if(isset($_POST["email"]))
{
	if(isset($_POST["email"]) && isset($_POST["password"]))
	{		
		$change_from=array("\'","'","\\","\"");
		$change_to=array("","","","");
			
		if(!empty($_POST["password"]))
		{
			$password=str_replace($change_from,$change_to,$_POST["password"]);
			$password=trim($password);
		}
		else
		{
			$_POST["password"] = "";
			$password = "";
			$error[0] = 1;
		}
		
		if(!empty($_POST["email"]))
		{
			$username=str_replace($change_from,$change_to,$_POST["email"]);
			$username=trim($username);
		}
		else
		{
			$_POST["email"] = "";
			$error[0] = 1;
			$username = "";
		}
			
		if ($username && $password)
		// they have just tried logging in
		{
			 if (login($username, $password))
			 {
			 	
				$password=md5($password);
				$password=md5($password);
				// if they are in the database register the user id			
					
				$use=mysql_query("Select * from clients where email='$username' and password='$password'");
				$uses=mysql_fetch_array($use);
				mysql_free_result($use);
				
				$_SESSION["valid_user"]=$uses["email"];
				$_SESSION["user_id"]=$uses["id"];
										
				$query = mysql_query("select * from content where template = '1' and lang = '$_GET[lang]'");
				$mysql = mysql_fetch_array($query);
				mysql_free_result($query);
				
				//Lietotājs pieslēdzies
				AddStatistic($ip,$user_id,$ses_id,$url,'',3);				
				$bb = mysql_query("select * from user_statistic where ip = '$ip' and session_id = '$ses_id' and user_id = '$user_id' order by id asc");
				while($bbb = mysql_fetch_array($bb))
				{
					$result = mysql_query("update user_statistic set user_id = '$uses[id]' where id = '$bbb[id]'");
				}
				mysql_free_result($bb);
				
				$bb = mysql_query("select * from basket where ip = '$ip' and session_id = '$ses_id' and user_id = '$user_id' order by id asc");
				while($bbb = mysql_fetch_array($bb))
				{
					$result = mysql_query("update basket set user_id = '$uses[id]' where id = '$bbb[id]'");
				}
				mysql_free_result($bb);
				
				if($uses["password_changed"] == 1)
				{
					$links = $root_dir.$_GET["lang"]."/my-data";
				}
				else
				{
					if(isset($_POST["backlink"]))
					{
						$links = $root_dir.$_GET["lang"]."/".$_POST["backlink"];
					}
					else
					{
						$bb = mysql_query("select * from orders where user_id = '$_SESSION[user_id]'");
						$count_orders = mysql_num_rows($bb);
						mysql_free_result();
						
						if($count_orders == 0)
						{
							$query = mysql_query("select * from content where template = '1' and lang = '$_GET[lang]'");
							$mysql = mysql_fetch_array($query);
							mysql_free_result($query);
							$links = $root_dir.$_GET["lang"]."/$mysql[url]";
						}
						else
						{
							$links = $root_dir.$_GET["lang"]."/my-orders";
						}
					}
				}
				
				header("Location: $links");
				exit;
			}  
			else
			{
				$error[0] = 1;
				$_POST["password"] = "";
				$_POST["email"] = "";		
			}      
		}
	}
	else
	{
		$error[0] = 1;
		$_POST["email"] = "";
		$_POST["password"] = "";
	}	
}
else
{
	$_POST["email"] = "";
	$_POST["password"] = "";
	$error[0] = 1;
}
?>
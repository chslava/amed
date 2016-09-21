<?php
//iel�d�jam funkcijas
$wolf_path="";
require_once($wolf_path."config.php");

$change_from=array("\'","'","\\","\"");
$change_to=array("","","","");
		
$password=str_replace($change_from,$change_to,$_POST["password"]);
$password=trim($password);

$username=str_replace($change_from,$change_to,$_POST["username"]);
$username=trim($username);

if ($username && $password)
// they have just tried logging in
{
    if (login($username, $password))
    {
      // if they are in the database register the user id
	  	$_SESSION["valid_user"]=$username;
			$laiks = time();
			$ip=$_SERVER["REMOTE_ADDR"];
			$result=mysqli_query($result_db,"update user set ip='$ip', time='$laiks' where username='$username'"); 
	  	header("Location: member.php");
	  	exit;
    }  
    else
    {
      // unsuccessful login
			header("Location: index.php");
			exit;
    }      
}
else{
// unsuccessful login
header("Location: index.php");
exit;
}

?>

<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

$change_from=array("\"","\'","'","\\","delete","drop","alter","update");
$change_to=array("","","","","","","","");

	foreach ($_SESSION as $key => $value)
	{
		if($key=="valid_user"){}
		else
		{
  	 	unset($_SESSION[$key]); 
		}
	}

$_SESSION['searching']="on";
foreach ($_POST as $key => $value)
{
	$value=str_replace($change_from,$change_to,$value);$value=trim($value);
	$_SESSION[$key]=$value;
}

$links ="index.php".$li1."&limit=$limit";
header("Location: $links");
exit;
?>
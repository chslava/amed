<?php
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

foreach ($_SESSION as $key => $value)
{
	if($key=="valid_user"){}
	else
	{
   	unset($_SESSION[$key]); 
	}
}

$links ="index.php".$li1."&limit=$limit";
header("Location: $links");
exit;
?>
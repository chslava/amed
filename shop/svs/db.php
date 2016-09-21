<?php
$url = 'http://';

if(!getenv('APPLICATION_ENV')){define('APPLICATION_ENV','production');}else{define('APPLICATION_ENV',getenv('APPLICATION_ENV'));}
if(APPLICATION_ENV == 'development'){
	$url .= $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	$db_host="localhost"; //MySql hostname
	$db_user="amedical_adm";//MySql username
	$db_password="raweicieya0ai9yo";//MySql password
	$db_name="amedical";//MySql database name
}
else{
	$url .= str_replace('\\','',$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']));
	$db_host = "sql-05.deac.lv";
	$db_user="amedical_adm";//MySql username
	$db_password="raweicieya0ai9yo";//MySql password
	$db_name="amedical";//MySql database name
}
$result_db = mysqli_connect($db_host,$db_user,$db_password);
mysqli_select_db($result_db, $db_name);

mysqli_query($result_db,"SET NAMES utf8");
?>
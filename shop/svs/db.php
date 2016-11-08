<?php
$url = 'http://';

require_once (dirname(dirname(__FILE__)) . "/config.php");

global $result_db;
$result_db = mysqli_connect($db_host,$db_user,$db_password);
mysqli_select_db($result_db, $db_name);

mysqli_query($result_db,"SET NAMES utf8");
?>
<?php

function datums(){
$men=array("01","02","03","04","05","06","07","08","09","10","11","12");
$m=date("n")-1;
$dat=date("d");
$gad=date("Y");
echo "$dat.$men[$m].$gad";
}

function do_html_URL($url, $name)
{
?>
  <br><a href="<?php echo"$url";?>" class=login><?php echo"$name";?></a><br>
<?php 
}

function login($username, $password)
{
	global $result_db;
$password=md5($password);
$password=md5($password);

$result = mysqli_query($result_db,"select * from user where username='$username' and password = '$password'");

  if (!$result)
  return 0;
	if (mysqli_num_rows($result)>0)
	return 1;
	else
	return 0;
}

?>
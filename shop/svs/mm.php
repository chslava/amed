<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title>Test�jam sada�as</title>
</head>

<body>
<table border="1" cellpadding="2" cellspacing="2">
<?php 
$db_host="localhost";
$db_user="aliens";
$db_password="KI3voatO9T";
$db_name="aliens";

$result_db = mysqli_connect($db_host,$db_user,$db_password);
mysqli_select_db($result_db, $db_name);

$r=mysqli_query($result_db,"Select * from sadalas_lv where parent_id='0' order by place asc");
while($f=mysqli_fetch_array($r))
{
		echo "
		<tr>
			<td>$f[id]</t><td>$f[name]</td><td>$f[text]</td>
		</tr>\n";
}
mysqli_free_result($r);
?>

</table>
</body>
</html>

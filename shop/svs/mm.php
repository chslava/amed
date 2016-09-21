<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title>Testçjam sadaïas</title>
</head>

<body>
<table border="1" cellpadding="2" cellspacing="2">
<?php 
$db_host="localhost";
$db_user="aliens";
$db_password="KI3voatO9T";
$db_name="aliens";

$result_db = mysql_connect($db_host,$db_user,$db_password);
mysql_select_db($db_name,$result_db);

$r=mysql_query("Select * from sadalas_lv where parent_id='0' order by place asc");
while($f=mysql_fetch_array($r))
{
		echo "
		<tr>
			<td>$f[id]</t><td>$f[name]</td><td>$f[text]</td>
		</tr>\n";
}
mysql_free_result($r);
?>

</table>
</body>
</html>

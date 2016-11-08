<?php
//ielâdçjam funkcijas
require_once("config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once("check.php");

?>

<html>
	<head>
		<title><?php echo $head[0]; ?></title>
		<meta http-equiv="Content-Type" content="text/html; <?php echo $head[1]; ?>">
		<link rel="stylesheet" href="<?php echo $wolf_path; ?>style.css" type="text/css">
<script>
<!--

/*
Auto Refresh Page with Time script
By JavaScript Kit (javascriptkit.com)
Over 200+ free scripts here!
*/

//enter refresh time in "minutes:seconds" Minutes should range from 0 to inifinity. Seconds should range from 0 to 59
var limit="1:00"

if (document.images){
var parselimit=limit.split(":")
parselimit=parselimit[0]*60+parselimit[1]*1
}
function beginrefresh(){
if (!document.images)
return
if (parselimit==1)
window.location.reload()
else{ 
parselimit-=1
curmin=Math.floor(parselimit/60)
cursec=parselimit%60
if (curmin!=0)
curtime=curmin+" minutes and "+cursec+" seconds left until page refresh!"
else
curtime=cursec+" seconds left until page refresh!"

setTimeout("beginrefresh()",1000)
}
}

window.onload=beginrefresh
//-->
</script>
</head>
<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0">
	<table cellpadding="0" cellspacing="0" border="0" width="236" background="<?php echo $wolf_path; ?>img/augsa.gif" height="70">
		<tr>
			<td><a href="member.php?lang=<?php echo $lang."&ver=".$ver; ?>" target="_top"><img src="<?php echo $wolf_path; ?>img/logo.gif" border="0"></a></td>
		</tr>
</table>
</body>
</html>
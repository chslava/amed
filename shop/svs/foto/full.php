<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");
?>

<html>
	<head>
		<title><?php echo $head[0]; ?></title>
		<meta http-equiv="Content-Type" content="text/html; <?php echo $head[1]; ?>">
		<link rel="stylesheet" href="<?php echo $wolf_path; ?>style.css" type="text/css">
		<script language="JavaScript">
function MM_closeBrWindow(theURL,winName,features) { //v2.0
  window.close(theURL,winName,features);
}
</script>
<SCRIPT LANGUAGE="JavaScript">
<?php 
$filename=$wolf_path."../$_GET[dir]$_GET[gal]/$_GET[name]";
list($width, $height, $type) = getimagesize($filename);
echo "var www = $width\n";
echo "var hhh = $height\n";
?>
function fitWindowSize() {
window.resizeTo(www, hhh);
}

</script>
	</head>
	<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="fitWindowSize()">
<div style="position:absolute; left:0px; top:0px">
<table cellpadding=0 cellspacing=0 border=0 width="100%" height="100%">
	<tr>
		<td align="center" valign="middle"><a href="javascript:;" onClick="MM_closeBrWindow()"><img align="middle" src="<?php echo $wolf_path."../$_GET[dir]$_GET[gal]/$_GET[name]"; ?>" border="0" alt="AizvÄ“rt"></a></td>
	</tr>
</table>
</div>

</body>
</html>


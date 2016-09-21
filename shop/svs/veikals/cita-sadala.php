<?php
//ielâdçjam funkcijas
require_once("config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");
$error="";
if(isset($_POST["submit"]))
{
	$change_from=array("'","\\","\"");
	$change_to=array("`","","&quot;");
	
	
	if(!empty($_POST["sadala"]))
	{
		$sadala=str_replace($change_from,$change_to,$_POST["sadala"]);
		$sadala=trim($sadala);
	}
	else
	{
		$sadala="";
	}
	
	if(empty($sadala))
	{
		$error = $error."<tr><td class=\"sarkanst\" colspan=\"2\">$pr[74]</td></tr>";
	}
	
	if($error == "")
	{
		$req=mysql_query("Select place from items where parent_id='$sadala' order by place desc Limit 0, 1");
		$roq=mysql_fetch_array($req);
		mysql_free_result($req);
		$place=$roq["place"];
		
		if(empty($place)){$place=1;}
		
		$prec_mas = explode("|",$_POST["precu_id"]);
		for($i=0; $i<count($prec_mas);$i++)
		{	
			$place++;
			$rakstam=mysql_query("update items set parent_id='$sadala', place='$place' where id='$prec_mas[$i]'");
		}
		$links ="index.php".$li;
		header("Location: $links");
		exit;
	}

}

?>

<html>
	<head>
		<title><?php echo $head[0]; ?></title>
		<meta http-equiv="Content-Type" content="text/html; <?php echo $head[1]; ?>">
		<link rel="stylesheet" href="<?php echo $wolf_path; ?>style.css" type="text/css">
		<script language="JavaScript">
			function go( url){
			window.location.href = url;
			}
		</script>
		</head>
	<body leftmargin="0" topmargin="0" background="<?php echo $wolf_path; ?>img/fons.gif" marginheight="0" marginwidth="0">
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
		<?php	require_once($wolf_path."augsa.php");?>
			<tr>
				<td colspan="2" valign="top" height="25">
				<?php require_once($wolf_path."menu.php"); ?>
				</td>
			</tr>
			<tr>
				<td colspan="2" height="20" bgcolor="d0d2dd">
				<?php require_once("izveleta.php"); ?>
				</td>
			</tr>
			<tr>
				<td width="250" valign="top" bgcolor="#f2f3f7">
				<?php require_once("page_menu.php"); ?>
				</td>
				<td bgcolor="#ffffff" width="100%" valign="top" class="text">
					<table cellpadding="0" cellspacing="0" border="0">
						<tr>
		 				  <td height="30" valign="top" class="sad"><a href="index.php<?php echo $li1; ?>" class="sad_link"><?php echo $item[0]; ?></a> <img src="<?php echo $wolf_path; ?>img/next.gif" align="absmiddle"> <a href="cita-sadala.php<?php echo $li."&page=$_GET[page]"; ?>" class="sad_link"><?php echo $pr[111]; ?></a></td>
	   				</tr>	  	    			
			   	</table>
            
					
					<form name="prece" enctype="multipart/form-data" action="cita-sadala.php<?php echo $li."&page=$_GET[page]"; ?>" method="post">
						<table cellpadding="3" cellspacing="2" style="border: 1px solid #d0d2dd" width="100%">
							<tr>
								<td bgcolor="#f2f3f7"><b><?php echo $pr[112]; ?></b></td>
							</tr>
							<?php echo $error;?>
							<tr>
								<td>
								<?php 
								
								if(!empty($_POST["ppp"]))
								{
									$n=0;
									$masivs="";
									while($n<count($_POST["ppp"]))
									{
										$line=each ($_POST["ppp"]);
										$masivs=$masivs."$line[value]|";
										$n++;
									}
								}
								else
								{
									$masivs="";
								}
							
								
								?>
								<input type="Hidden" name="precu_id" value="<?php echo $masivs; ?>">
								</td>
							</tr>
							<tr>
								<td valign="top">
									   <table cellpadding="2" cellspacing="0" border="0" bgcolor="#ffffff" width="100%"> 
										<?php 
$krasa=array("#f4f5f8","#FFFFFF");

$kr=0;
$tabula="categories";
function sad($parent_id,$indent,$tabula,$ver,$kr)
{$indent=$indent."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	$r1=mysql_query("Select * from $tabula where parent_id='$parent_id' order by place asc");
	while($f1=mysql_fetch_array($r1))
	{
		echo "$indent<input type=\"radio\" name=\"sadala\" value=\"$f1[id]\"><b>$f1[name_lv]</b><br>\n";
	
		sad($f1["id"],$indent,$tabula,$ver,$kr);
	}
}
$indent="&nbsp;&nbsp;&nbsp;&nbsp;";
	$r=mysql_query("Select * from $tabula where parent_id='0' order by place asc");
	while($f=mysql_fetch_array($r))
	{
	
		echo "<tr bgcolor=\"$krasa[$kr]\"><td class=text3 width=300><input type=\"radio\" name=\"sadala\" value=\"$f[id]\"><b>$f[name_lv]</b><br>\n";
		
		
		sad($f["id"],$indent,$tabula,$ver,$kr);
		echo "</td></tr>";
		if($kr==0){	$kr=1;}
		elseif($kr==1){	$kr=0;}
	}
mysql_free_result($r)
?>
  								</table>
								</td>
							</tr>
							<tr>
								<td><INPUT TYPE="Submit" VALUE="<?php echo $pr[113]; ?>" class="button" name="submit"></td>
							</tr>
						</table>
					</form>
				</td>
			</tr>
		</table>
	</body>
</html>
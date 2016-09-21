<?php
require_once("config.php");
require_once($wolf_path."check.php");

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
		$req=mysql_query("Select place from categories where parent_id='0' order by place desc Limit 0, 1");
		$roq=mysql_fetch_array($req);
		$place=$roq["place"];
		$place++;
		if(empty($place)){$place=1;}
		
		$rakstam=mysql_query("update categories set parent_id='$sadala', place='$place' where id='$id'");
		$links ="index.php".$li;
		header("Location: $links");
		exit;
	}
	
	if($error == "")
	{
		$req=mysql_query("Select place from categories where parent_id='$sadala' order by place desc Limit 0, 1");
		$roq=mysql_fetch_array($req);
		$place=$roq["place"];
		$place++;
		if(empty($place)){$place=1;}
		
		$rakstam=mysql_query("update categories set parent_id='$sadala', place='$place' where id='$id'");
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
				
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
                  <tr>
                     <td height="30" valign="top" class="sad"><a href="parvietot.php<?php echo $li; ?>" class="sad_link"><?php echo $categories[5]; ?></a></td>
                  </tr>
               </table>
               <form name="prece" enctype="multipart/form-data" action="parvietot.php<?php echo $li; ?>" method="post">
					<table cellpadding="5" cellspacing="1" border="0" style="border: 1px solid #d0d2dd" width="100%">
               <tr>
	  					<td class="standart" bgcolor="#f2f3f7" colspan="9"><b><?php echo $categories[6]; ?></b></td>
	  				</tr>
					<?php 
											
					$krasa=array("#ffffff","#f4f5f8");
					
					$kr=0;
					
					$tabula="categories";
					function sad($parent_id,$indent,$tabula,$ver,$kr)
					{
						$indent=$indent."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						$r1=mysql_query("Select * from $tabula where parent_id='$parent_id' order by place asc");
							
						while($f1=mysql_fetch_array($r1))
						{
							echo "$indent<input type=\"radio\" name=\"sadala\" value=\"$f1[id]\"> <b>$f1[name_lv]</b><br>\n";
						
							sad($f1["id"],$indent,$tabula,$ver,$kr);
						}
					}
					
					$indent="&nbsp;&nbsp;&nbsp;&nbsp;";
					$r=mysql_query("Select * from categories where parent_id='0' order by place asc");
					while($f=mysql_fetch_array($r))
					{
						echo "<tr bgcolor=\"$krasa[$kr]\"><td class=\"standart\" width=\"300\"><input type=\"radio\" name=\"sadala\" value=\"$f[id]\"> <b>$f[name_lv]</b><br>\n";
													
						sad($f["id"],$indent,$tabula,$ver,$kr);
						echo "</td></tr>";
						if($kr==0){	$kr=1;}
						elseif($kr==1){	$kr=0;}
					}
					?>
  						
					</table>
               
               <table cellpadding="0" cellspacing="0" border="0" width="100%">
               	<tr>
                  	<td>&nbsp;</td>
                  </tr>
               	<tr>
							<td><INPUT TYPE="Submit" VALUE="<?php echo $categories[7]; ?>" class="button" name="submit"></td>
						</tr>
               </table>
					</form>
					
				</td>
			</tr>
		</table>
	</body>
</html>


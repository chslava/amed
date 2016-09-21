<?php
//iel�d�jam funkcijas
require_once("config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");
$interval="25";
if(empty($_GET["page"]))
{
	$_GET["page"] = 1;
}
$begin = $_GET["page"] * $interval - $interval;

$select1 = "select id from branches_items where branche_id = '$id' group by group_type";
$select2 = "select * from branches_items where  branche_id = '$id' group by group_type order by place asc LIMIT $begin, $interval";
$name_lang = "name_".$ver;
$text_lang = "text_".$ver;
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
			
			function ChangePlace(address,item_id)
			{
				
				var vieta = document.getElementById(item_id).value;
				var url = 'bidit-nozares.php' + address + '&name=' + vieta;
				
				window.location.href = url;
								
			}
			
			var xmlhttp

			
			function GetXmlHttpObject()
			{
				if (window.XMLHttpRequest)
				{
					// code for IE7+, Firefox, Chrome, Opera, Safari
					return new XMLHttpRequest();
				}
				if (window.ActiveXObject)
				{
					// code for IE6, IE5
					return new ActiveXObject("Microsoft.XMLHTTP");
				}
				return null;
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
				<td colspan="2" height="20" bgcolor="d0d2dd">&nbsp;</td>
			</tr>
			<tr>
				<td bgcolor="#ffffff" width="100%" valign="top" class="text">
				<?php
				$nos = "branches";
				$ren=mysqli_query($result_db,"Select * from $nos where id='$id'");
				$rop=mysqli_fetch_array($ren);
				mysqli_free_result($ren);
				?>
				<table cellpadding="0" cellspacing="0" border="0" width="100%">
					<tr>
		 				  <td height="30" valign="top" class="sad"><a href="index.php<?php echo $li1; ?>" class="sad_link"><?php echo $pr[0]; ?></a> <img src="<?php echo $wolf_path; ?>img/next.gif" align="absmiddle"><a href="branch.php<?php echo $li1; ?>" class="sad_link"><?php echo $pr[93]; ?></a> <img src="<?php echo $wolf_path; ?>img/next.gif" align="absmiddle"><a href="branches_items.php<?php echo $li; ?>" class="sad_link"><?php echo $rop["name_lv"]; ?></a></td>
	   				</tr>
	  	    	
						<tr>
		 				  <td height="10"></td>
	   				</tr>
	
			    </table>
                <form >
           	 
					
					<?php 
					
					$r = mysqli_query($result_db,$select1);
					$pavisam = mysqli_num_rows($r);
					$pages = ceil($pavisam/$interval);
					$page = "";
					$echo_pages = "";
					
					for($i=1;$i<=$pages;$i++)
					{
						if($i == $_GET["page"])
						{
							$page .= "<div class=\"page_on\"><a href=\"".$li."&page=$i\" class=\"page_number\"><b>$i</b></a></div><div class=\"atstarpe\"></div>\n";
						}
						else
						{
							$page .= "<div class=\"page\"><a href=\"".$li."&page=$i\" class=\"page_number\"><b>$i</b></a></div><div class=\"atstarpe\"></div>\n";
						}
					}
				
				
					
					if($pages > 1)
					{
						$echo_pages = "
						<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\">
							<tr>
								<td align=\"center\"><div id=\"page_content\">".$page."</div></td>
							</tr>
						</table>";
						
						echo $echo_pages;
					}
					?>
					
                    
	 				<table cellpadding="3" cellspacing="2" width="100%" style="border: 1px solid #d0d2dd">
	 					<tr>
	  					<td class="standart" bgcolor="#f2f3f7" colspan="9"><b><?php echo $pr[3]; ?></b></td>
	  				</tr>
	  				<?php
						
	  				$rep=mysqli_query($result_db,$select2);
	  				$a=1;
	 					while($rop=mysqli_fetch_array($rep))
						{
	 						$items = mysqli_query($result_db,"select * from items where id = '$rop[item_id]'");
	 						$item = mysqli_fetch_array($items);
	 						mysqli_free_result($items);
						
							$dala = strip_tags($item["text_lv"]);
							$dala = mb_substr($dala,0,200,"utf-8");
							$cik_dala = mb_strlen($dala,"utf-8");
							if($cik_dala>=200)
							{
								$dala = $dala."...";
							}
							
	  						echo "
							<tr>
								<td class=st1 valign=top><b>$item[id]</b> ($rop[group_type])</td>
								<td class=st1 valign=top align=left>
		
								<div style=\"width: 100px;\">
								<input type=\"text\" name=\"vieta\" style=\"width: 30px\" value=\"$rop[place]\" class=\"input\" id=\"vieta_$a\">&nbsp;<INPUT TYPE=\"button\" VALUE=\"$pr[54]\" class=\"button1\" onclick=\"ChangePlace('$li&k=$rop[id]&page=$_GET[page]','vieta_$a');\"></div>
								</td>
								<td class=st1 valign=top>";
								
								if(!empty($item["picture"]))
								{
								echo "
									<div><img src=\"../../pictures/items/small/$item[picture]?v=".time()."\" vspace=\"5\"></div>";
								}
								else
								{
									echo "&nbsp;";
								}								
								
								echo "
										
								</td>
								<td class=st1 valign=top width=100%>
								
								
								<div><b>$item[$name_lang]</b></div>
								<div>$dala</div>
								
								
						
								</td>
								<td class=st1 valign=top>
								
								<div><b>$item[price]&nbsp;$pr[59]</b></div>
								</td>
															</tr>";
							$a++;
						}
	  					mysqli_free_result($rep);
	 					if($a==1)
						{
							echo "<tr><td class=\"st1\">$pr[4]</td></tr>";
						}
	   				?>
						
	 				</table>
                    </form>
					<?php echo $echo_pages; ?>
				</td>
			</tr>
		</table>
	</body>
</html>


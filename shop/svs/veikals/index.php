<?php
//ielâdçjam funkcijas
require_once("config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");
$interval="25";
if(empty($_GET["page"]))
{
	$_GET["page"] = 1;
}
$begin = $_GET["page"] * $interval - $interval;

$select1 = "select id from items where parent_id='$id'";
$select2 = "select * from items where  parent_id='$id' order by place asc LIMIT $begin, $interval";
$name_lang = "name_".$ver;
$slogan_lang = "slogan_".$ver;
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
				var url = 'bidit.php' + address + '&name=' + vieta;
				
				window.location.href = url;
								
			}
			
			var xmlhttp

			function ChangeStatuss(content_id,item_id)
			{	
				xmlhttp=GetXmlHttpObject();
				if (xmlhttp==null)
				{
					alert ("Your browser does not support AJAX!");
					return;
				}
								
				var url= "publicet.php";
				url=url+"?k="+item_id;
				url=url+"&r="+Math.random();
				xmlhttp.onreadystatechange=stateChanged;
				xmlhttp.open("GET",url,true);
				xmlhttp.send(null);
			
				function stateChanged()
				{
					if (xmlhttp.readyState==4)
					{
						document.getElementById(content_id).innerHTML=xmlhttp.responseText;
					}
				}
			
			}
			
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
		 				  <td height="30" valign="top" class="sad"><a href="index.php<?php echo $li1; ?>" class="sad_link"><?php echo $item[0]; ?></a></td>
	   				</tr>
	  	    	<tr>
		 				  <td valign="middle" height="20">
							<INPUT TYPE="Button" VALUE="<?php echo $pr[2]; ?>" class="button" onclick='go("p_pievienot.php<?php echo $li1."&id=$id&limit=$limit"; ?>")'>&nbsp;&nbsp;&nbsp;&nbsp;<a href="speciality.php<?php echo $li1; ?>" class="menu2"><b>&raquo; <?php echo $pr[85]; ?></b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="branch.php<?php echo $li1; ?>" class="menu2"><b>&raquo; <?php echo $pr[93]; ?></b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="rate.php<?php echo $li1; ?>" class="menu2"><b>&raquo; <?php echo $pr[120]; ?></b></a></td>
	   				</tr>
						<tr>
		 				  <td height="10"></td>
	   				</tr>
	
			    </table>
                <form method="post" action="cita-sadala.php<?php echo $li."&page=$_GET[page]"; ?>">
           	 	<table cellpadding="0" cellspacing="0" border="0" width="100%">             
                	<tr>
		 				<td align="right"><input type="submit" value="<?php echo $pr[110]; ?>" name="parvietot" class="button"></td>
	   				</tr><tr>
		 				  <td height="10"></td>
	   				</tr>
                 </table>
					
					<?php 
					
					$r = mysql_query($select1);
					$pavisam = mysql_num_rows($r);
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
						
	  				$rep=mysql_query($select2);
	  				$a=1;
	 					while($rop=mysql_fetch_array($rep))
						{
	 						if($rop["statuss"]==1)
							{
								$publicet=$pr[57];
							}
							else
							{
								$publicet=$pr[58];
							}
							
							if($rop['copy'] > 0)
							{
								$query = mysql_query("select * from items where id='$rop[copy]'");
								$mysql = mysql_fetch_array($query);
								$nosaukums = $mysql[$name_lang];
								$dala = strip_tags($mysql[$text_lang]);
								$attels = $mysql["picture"];
								$cena = $mysql["price"];
								$real_item_id = $rop['copy'];
							}
							else
							{
								$nosaukums = $rop[$name_lang];
								$dala = strip_tags($rop[$text_lang]);
								$attels = $rop["picture"];
								$cena = $rop["price"];
								$real_item_id = $rop['id'];
							}
						
							
							$dala = mb_substr($dala,0,200,"utf-8");
							$cik_dala = mb_strlen($dala,"utf-8");
							if($cik_dala>=200)
							{
								$dala = $dala."...";
							}
							
							
							
	  						echo "
							<tr>
								<td class=st1 valign=top><b>$rop[id]</b></td>
								<td class=st1 valign=top align=left>
		
								
								<input type=\"text\" name=\"vieta\" style=\"width: 30px\" value=\"$rop[place]\" class=\"input\" id=\"vieta_$a\">&nbsp;<INPUT TYPE=\"button\" VALUE=\"$pr[54]\" class=\"button1\" onclick=\"ChangePlace('$li&k=$rop[id]&page=$_GET[page]','vieta_$a');\">
								</td>
								<td class=st1 valign=top>";
								
								if(!empty($attels))
								{
								echo "
									<div><img src=\"../../pictures/items/small/$attels?v=".time()."\" vspace=\"5\"></div>
									<div><a href=\"p_atteli.php$li&name=$real_item_id&page=$_GET[page]\" class=\"standart_link_11\"><b>&raquo; $item[43]</b></a></div>";
								}
								else
								{
									echo "&nbsp;";
								}								
								
								if($rop['copy'] > 0){$copy = '<span style="color: red;"><b>&nbsp;KOPIJA!!!</b></span>';}else{$copy = '';}
								
								echo "
										
								</td>
								<td class=st1 valign=top width=100%>
								
								
								<div><input type=\"checkbox\" name=\"ppp[]\" value=\"$rop[id]\">$copy&nbsp; <b>$nosaukums</b></div>
								<div>$dala</div>
								
								
						
								</td>
								<td class=st1 valign=top>
								
								<div><b>$cena&nbsp;$pr[59]</b></div>
								</td>
								<!--<td class=st1 valign=top><INPUT TYPE=Button VALUE=\"$pr[109]\" class=button1 onclick='go(\"p_kopet.php$li&name=$rop[id]&page=$_GET[page]\")'></td>-->";
								if($rop['copy'] == 0)
								{
									echo "<td class=st1 valign=top><INPUT TYPE=Button VALUE=\"$item[91]\" class=button1 onclick='go(\"p_related.php$li&name=$rop[id]&page=$_GET[page]\")'></td>";
								}
								else
								{
									echo "<td class=st1 valign=top>&nbsp;</td>";
								}
								echo "
								<td class=st1 valign=top><INPUT TYPE=Button VALUE=\"$pr[55]\" class=button1 onclick='go(\"p_mainit.php$li&name=$real_item_id&page=$_GET[page]\")'></td>
								<td class=st1 valign=top><INPUT TYPE=Button VALUE=\"$pr[56]\" class=button1 onclick='go(\"p_dzest.php$li&name=$rop[id]&page=$_GET[page]\")'></td>
								<td class=st1 valign=top id=\"statuss_$rop[id]\"><INPUT TYPE=\"Button\" VALUE=\"$publicet\" class=\"button1\" onclick=\"ChangeStatuss('statuss_$rop[id]','$rop[id]')\">
							</tr>";
							$a++;
						}
	  					mysql_free_result($rep);
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


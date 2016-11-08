<?php
//iel�d�jam funkcijas
require_once("config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");
$interval="20";
$select1 = "select id from preces where akcija='1'";
$select2 = "select * from preces where  akcija='1' order by place asc LIMIT $limit, $interval";
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
		 				  <td height="30" valign="top" class="sad"><a href="akcijas.php<?php echo $li1; ?>" class="sad_link"><?php echo $menu_it[10]; ?></a></td>
	   				</tr>
	  	    	
						<tr>
		 				  <td height="10"></td>
	   				</tr>
	
			    </table>
            
					
					<?php 
					
					$echo_pogas="";
					
					$begin=$limit;
					$zi=mysqli_query($result_db,$select1);
	  			$cik_tab = mysqli_num_rows($zi);
					mysqli_query($result_db,$zi);
	 				if($cik_tab>0)
					{
						$echo_pogas=$echo_pogas."
					<table cellpadding=\"0\" cellspacing=\"5\" border=\"0\" align=\"center\">
						<tr>";

							$pogas = $cik_tab / $interval;
							$pogas = ceil($pogas);
							$p=1; $lim=0; 
							while($p<=$pogas)
							{
								if($lim == $limit){$po = "button_dark";} else{$po="button1";}
								$echo_pogas=$echo_pogas."<td><INPUT TYPE=Button VALUE=\"$p\" class=\"$po\" onclick='go(\"akcijas.php$li1&limit=$lim\")' style=\"width: 20px\"></td>";
								$lim = $lim + $interval;
								$p++;
							}
							$echo_pogas = $echo_pogas."</tr>
					</table>";
							echo $echo_pogas;
					}
					?>
				
					
	 				<table cellpadding="3" cellspacing="2" width="100%" style="border: 1px solid #d0d2dd">
	 					<tr>
	  					<td class="standart" bgcolor="#f2f3f7" colspan="8"><b><?php echo $pr[3]; ?></b></td>
	  				</tr>
	  				<?php
						
	  				$rep=mysqli_query($result_db,$select2);
	  				$a=1;
	 					while($rop=mysqli_fetch_array($rep))
						{
	 						if($rop["publish"]==1)
							{
								$publicet=$pr[57];
							}
							else
							{
								$publicet=$pr[58];
							}
							if($rop["first"] == "on"){$left = "<div><img src=\"../img/first.gif\"></div>";}else{$left="";}
	  					echo "<tr>
							<td class=st1 valign=top><b>$a</b></td>
							<td class=st1 valign=top align=left>
							<form method=\"post\" action=\"parvietot.php$li1&k=$rop[id]&limit=$$limit\">
							<input type=\"text\" name=\"vieta\" style=\"width: 30px\" value=\"$rop[place]\" class=\"input\">&nbsp;<INPUT TYPE=\"submit\" VALUE=\"$pr[54]\" class=\"button1\">
							</form></td>
							<td class=st1 valign=top>";
					
							$bi=mysqli_query($result_db,"select * from preces_f where parent_id='$rop[id]' order by id asc");
							$cik=mysqli_num_rows($bi);
	 												
							if($cik>0)
							{
								$bil=mysqli_fetch_array($bi);
								
								if(file_exists("../../preces/small/$bil[filename]"))
								{
									echo "<img src=\"../../preces/small/$bil[filename]\">";
								}
								else
								{
									echo "&nbsp;";
								}
							}
							else
							{
								echo "&nbsp;";
							}
							mysqli_free_result($bi);
                     
                     echo "</td>
							<td class=st1 valign=top width=100%>
							<div><b>$rop[name_lv]</b></div>
							<div>$rop[apraksts_lv]</div>
							<div>&nbsp;</div>
							<div>$rop[piegade_lv]</div>
					
							</td>
							<td class=st1 valign=top>
							
							<div><b>$rop[prise]&nbsp;$pr[59]</b></div>
							</td>
							<td class=st1 valign=top><INPUT TYPE=Button VALUE=\"$pr[55]\" class=button1 onclick='go(\"p_mainit.php$li&name=$rop[id]&limit=$limit\")'></td>
							<td class=st1 valign=top><INPUT TYPE=Button VALUE=\"$pr[56]\" class=button1 onclick='go(\"p_dzest.php$li&name=$rop[id]&limit=$limit\")'></td>
							<td class=st1 valign=top><INPUT TYPE=Button VALUE=\"$publicet\" class=button1 onclick='go(\"publicet.php$li&k=$rop[id]&limit=$limit\")'></td>
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
					<?php echo $echo_pogas; ?>
				</td>
			</tr>
		</table>
	</body>
</html>


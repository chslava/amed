<?php
global $result_db;
//iel�d�jam funkcijas
require_once("../config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");

$interval="25";
if(empty($_GET["page"]))
{
	$_GET["page"] = 1;
}
$begin = $_GET["page"] * $interval - $interval;

$select1 = "select id from clients ";
$select2 = "select * from clients order by id desc LIMIT $begin, $interval";
	
?>

<html>
	<head>
		<title><?php echo $head[0]; ?></title>
		<meta http-equiv="Content-Type" content="text/html; <?php echo $head[1]; ?>">
		<link rel="stylesheet" href="<?php echo $wolf_path; ?>style.css" type="text/css">
		<script language="JavaScript" src="calendar1.js"></script>
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
				<td colspan="2" height="20" bgcolor="d0d2dd">&nbsp;</td>
			</tr>
			<tr>
				
				<td bgcolor="#ffffff" width="100%" valign="top" class="text">
				
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
						<tr>
		 				  <td height="30" valign="top" class="sad">
								<a href="index.php<?php echo $li1; ?>" class="sad_link"><?php echo $menu_it[29]; ?></a></td>
										
									
	   				</tr>
	  	    			
						
			    </table>
					
					
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
							$page .= "<div class=\"page_on\"><a href=\"$li"."&page=$i\" class=\"page_number\"><b>$i</b></a></div><div class=\"atstarpe\"></div>\n";
						}
						else
						{
							$page .= "<div class=\"page\"><a href=\"$li"."&page=$i\" class=\"page_number\"><b>$i</b></a></div><div class=\"atstarpe\"></div>\n";
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
							<td class="standart" bgcolor="#f2f3f7" valign="top"><b><?php echo $orders[147]; ?></b></td>
							<td class="standart" bgcolor="#f2f3f7" valign="top"><b><?php echo $orders[148]; ?></b></td>
							<td class="standart" bgcolor="#f2f3f7" valign="top"><b><?php echo $orders[149]; ?></b></td>
							<td class="standart" bgcolor="#f2f3f7" valign="top"><b><?php echo $clients[65]; ?></b></td>
                            <td class="standart" bgcolor="#f2f3f7" valign="top"><b><?php echo $orders[150]; ?></b></td>
                            <td class="standart" bgcolor="#f2f3f7" valign="top"><b><?php echo $orders[13]; ?></b></td>
	  				</tr>
	  				<?php
						$nos = "orders";
						$statuss_text = array("1"=>$orders[151], "2"=>$orders[152]);
						$time = time();
	  				 	$today = mktime(0,0,0,date("n",$time),date("j",$time),date("Y",$time));
						$rep=mysqli_query($result_db,$select2);
						echo mysqli_error($result_db);
	  					$a=1;
	 					while($rop=mysqli_fetch_array($rep))
						{
							
							$datums = str_replace(" ","&nbsp;",date("d.m.Y H:i:s",$rop["reg_time"]));
							$stat = $rop["statuss"];													
							$derg = "bgcolor=\"#ffffff\"";
							
							if($rop["person"] == 1)
							{
								$client_name = "$rop[company_name]";
							}
							else
							{
								$client_name = "$rop[person_name]";
							}
							
							$user_points = 0;
							$query = mysqli_query($result_db,"select * from points where client_id = '$rop[id]'");
							while($mysql = mysqli_fetch_array($query))
							{
								$user_points = $user_points + $mysql["value"];
							}
							mysqli_free_result($query);
							$user_points = number_format(round($user_points,2),2,".","");
														
	  						echo "
							<tr $derg onmouseover=\"this.style.backgroundColor='#FFFCAE'\" onmouseout=\"this.style.backgroundColor=''\">
								<td class=st1 valign=top>$rop[id]</td>
								<td class=st1 valign=top width=\"100%\">$client_name</td>
								<td class=st1 valign=top>$rop[email]</td>
								<td class=st1 valign=top>$user_points Ls</td>
								<td class=st1 valign=top>$statuss_text[$stat]</td>								
								<td class=st1 valign=top><INPUT TYPE=Button VALUE=\"$orders[24]\" class=button1 onclick='go(\"mainit.php$li1&id=$rop[id]&limit=$limit\")'></td>
							</tr>";
							$a++;
						}
	  					mysqli_free_result($rep);
	 					if($a==1)
						{
	  						echo "<tr><td class=\"st1\" colspan=\"7\">$orders[32]</td></tr>";
	  					}
	   				?>
						
	 				</table>
				</td>
			</tr>
		</table>
	</body>
</html>


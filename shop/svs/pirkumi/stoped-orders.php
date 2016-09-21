<?php
global $result_db;
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

$interval="100";
if(empty($_GET["page"]))
{
	$_GET["page"] = 1;
}
$begin = $_GET["page"] * $interval - $interval;

if($k > 0)
{
	$rows = mysqli_query($result_db,"select * from user_statistic where id = '$k'");
	$row = mysqli_fetch_array($rows);
	mysqli_free_result($rows);

	$select1 = "select id from user_statistic where id > '0' and ip = '$row[ip]' and session_id = '$row[session_id]'";
	$select2 = "select * from user_statistic where id > '0' and ip = '$row[ip]' and session_id = '$row[session_id]' order by time asc LIMIT $begin, $interval";
	if($row["user_id"] == 0)
	{
	    $user_name = $orders[173];
	}
	else
	{
	    $users = mysqli_query($result_db,"select * from clients where id = '$row[user_id]'");
	    $user = mysqli_fetch_array($users);
	    mysqli_free_result($users);
	    $user_name = "$user[email]";
	}
	$izv = ' <img src="'.$wolf_path.'img/next.gif" align="absmiddle"><a href="stoped-orders.php'.$li.'&k='.$k.'" class="sad_link">'.$user_name.'</a>';
}
else
{
	$select1 = "select id from user_statistic where id > '0' group by session_id, ip";
	$select2 = "select * from user_statistic where id > '0' group by session_id, ip order by time desc LIMIT $begin, $interval";
	$izv = '';
}
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
								<table width="100%" cellspacing="0" cellpadding="0" border="0">
									<tr>
										<td class="sad"><a href="delet_session.php<?php echo $li1; ?>" class="sad_link"><?php echo $menu_it[24]; ?></a> <img src="<?php echo $wolf_path; ?>img/next.gif" align="absmiddle"><a href="stoped-orders.php<?php echo $li1; ?>" class="sad_link"><?php echo $orders[169]; ?></a><?php echo $izv; ?></td>
										
									</tr>
								</table>
							</td>
	   					</tr>
	  	    			<tr>
							<td>
                     
                     
                     
                     
                     
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
							<td class="standart" bgcolor="#f2f3f7" valign="top"><b><?php echo $orders[170]; ?></b></td>
							<?php
							if($k > 0)
							{
							?>
								<td class="standart" bgcolor="#f2f3f7" valign="top"><b><?php echo $orders[175]; ?></b></td>
								<td class="standart" bgcolor="#f2f3f7" valign="top"><b><?php echo $orders[176]; ?></b></td>
							<?php
							}
							else
							{
							?>
								<td class="standart" bgcolor="#f2f3f7" valign="top"><b><?php echo $orders[171]; ?></b></td>
							<?php
							}
							?>
	  				</tr>
	  				<?php
						$nos = "orders";
						$statuss_text = array(0 => $or_st[0], 1 => $or_st[1], 2 => $or_st[2], 3 => $or_st[3], 4 => $or_st[4], 5 => $or_st[5], 6 => $or_st[6], 7 => $or_st[7], 8 => $or_st[8]);
	  				
						$rep=mysqli_query($result_db,$select2);
						echo mysqli_error($result_db);
	  					$a=1;
	 					while($rop=mysqli_fetch_array($rep))
						{
							$datums = str_replace(" ","&nbsp;",date("d.m.Y H:i:s",$rop["time"]));
							if($rop["user_id"] == 0)
							{
								$user_name = $orders[173];
							}
							else
							{
								$users = mysqli_query($result_db,"select * from clients where id = '$rop[user_id]'");
								$user = mysqli_fetch_array($users);
								mysqli_free_result($users);
								$user_name = "$user[email]";
							}
							
							$st = $rop["status"];
							
							if($k > 0)
							{
								echo "
								<tr onmouseover=\"this.style.backgroundColor='#FFFCAE'\" onmouseout=\"this.style.backgroundColor=''\">
									<td class=st1 valign=top width=\"130\">$datums</td>
									<td class=st1 valign=top>$or_st[$st]</td>
									<td class=st1 valign=top>$rop[comments]</td>
								</tr>";
							}
							else
							{
	  							echo "
								<tr onmouseover=\"this.style.backgroundColor='#FFFCAE'\" onmouseout=\"this.style.backgroundColor=''\">
									<td class=st1 valign=top width=\"130\">$datums</td>
									<td class=st1 valign=top><a href=\"?k=$rop[id]&page=$_GET[page]\" class=\"standart_link_11\"><b>$user_name - $rop[ip]</b></a></td>
								</tr>";
							}
							$a++;
						}
	  					mysqli_free_result($rep);
	 					if($a==1)
						{
	  						echo "<tr><td class=\"st1\" colspan=\"7\">$orders[32]</td></tr>";
	  					}
	   				?>
						
	 				</table>
	 				<?php
	 				if($k > 0)
					{
					?>
	 				 <table cellpadding="0" cellspacing="0" border="0"> 
              		<tr>
                  	<td valign="middle" height="30"><input type="Button" value="<?php echo $orders[174]; ?>" class="button" onclick='go("stoped-orders.php<?php echo $li1."&page=$_GET[page]"; ?>")'></td>
						</tr>						
					</table>
					<?php
					}
					?>
				</td>
			</tr>
		</table>
	</body>
</html>


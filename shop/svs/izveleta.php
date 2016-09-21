<?php if($frkohgb!="ok"){header("Location: index.php");	exit;}?>
<?php if($id != 0){?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td height="20">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="izveleta">
					<?php
					$row=mysql_query("Select * from $tabula where id='$id'");
					$fer=mysql_fetch_array($row);
					$teksts=$fer["text"];
					$izveleta = $fer["url"];
					
					$url = 'http://';
					if($_SERVER['HTTP_HOST'] == "webstyle")
					{
						$url .= $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF'])."/";
						$root_dir =  str_replace("svs/","",$url);
					
					}
					else
					{
						$url .= $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
						$root_dir =  str_replace("svs","",$url);
					}
					

					
					mysql_free_result($row);
					echo $teksti[19]."<b>".$fer["name"]."</b>";
					?>
					</td>
					<td height="20" class="izveleta">
					<?php
					if($fer["publish"]=="on"){$st=$teksti[26];}else{$st=$teksti[25];}
					echo $teksti[24]."<b>".$st."</b> ";
					
					if($us=="no" && $ar > 0){}
					else{
					echo "<a href=\"".$wolf_path."sadalas/statuss.php$li\" class=\"standart_link_11\">[".$teksti[29]."]</a>";
					}
					?>
					</td>
				</tr>
			</table>
		</td>
		<td align="right"> <?php 
			if($us=="no" && $ar > 0){}
					else{?>
			<table cellpadding="1" cellspacing="0" border="0">
				<tr>
					<td height="20"><a href="<?php echo $wolf_path; ?>sadalas/up.php<?php echo $li."&iz=$fer[place]"; ?>"><img src="<?php echo $wolf_path; ?>img/up.gif" border="0"></a></td>
					<td height="20"><a href="<?php echo $wolf_path; ?>sadalas/down.php<?php echo $li."&iz=$fer[place]"; ?>"><img src="<?php echo $wolf_path; ?>img/down.gif" border="0"></a></td>
					
					<td height="20"><input type="Button" value="<?php echo $teksti[20]; ?>" class="button1" onclick='go("<?php echo $wolf_path; ?>sadalas/mainit.php<?php echo $li; ?>")'></td>
                    <td height="20"><input type="Button" value="<?php echo $teksti[22]; ?>" class="button1" onclick='go("<?php echo $wolf_path; ?>sadalas/apakssadala.php<?php echo $li; ?>")'></td>
               
					<td height="20"><input type="Button" value="<?php echo $teksti[23]; ?>" class="button1" onclick='go("<?php echo $wolf_path; ?>sadalas/dzest.php<?php echo $li; ?>")'></td>
				</tr>
			</table>
			<?php 
			}
			?>
		</td>
	</tr>
</table>
<?php 
}
?>
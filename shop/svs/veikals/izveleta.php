<?php if($frkohgb!="ok"){header("Location: index.php");	exit;}?>
<?php
if (!isset($id)) {
	$id = 0;
};
?>
<?php if($id != 0){?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td height="20">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="izveleta">
					<?php
					$row=mysqli_query($result_db,"Select * from $tabula where id='$id'");
					$fer=mysqli_fetch_array($row);
					$group_type = $fer["group_type"];
					
					mysqli_free_result($row);
					echo $teksti[19]."<b>".$fer["name_lv"]."</b>";
					?>
					</td>
					<td height="20" class="izveleta">
					<?php
					if($fer["statuss"]=="2"){$st=$teksti[26];}else{$st=$teksti[25];}
					echo $teksti[24]."<b>".$st."</b> ";
					
					if($us=="no" && $ar > 0){}
					else{
					echo "<a href=\"statuss.php$li\" class=\"standart_link_11\">[".$teksti[29]."]</a>";
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
					<td height="20"><a href="up.php<?php echo $li."&iz=$fer[place]"; ?>"><img src="<?php echo $wolf_path; ?>img/up.gif" border="0"></a></td>
					<td height="20"><a href="down.php<?php echo $li."&iz=$fer[place]"; ?>"><img src="<?php echo $wolf_path; ?>img/down.gif" border="0"></a></td>
					
					<td height="20"><input type="Button" value="<?php echo $teksti[20]; ?>" class="button1" onclick='go("mainit.php<?php echo $li; ?>")'></td>
					<td height="20"><input type="Button" value="<?php echo $teksti[22]; ?>" class="button1" onclick='go("apakssadala.php<?php echo $li; ?>")'></td>
					<td height="20"><input type="Button" value="<?php echo $teksti[169]; ?>" class="button1" onclick='go("parvietot.php<?php echo $li; ?>")'></td>
					<td height="20"><input type="Button" value="<?php echo $teksti[23]; ?>" class="button1" onclick='go("dzest.php<?php echo $li; ?>")'></td>
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
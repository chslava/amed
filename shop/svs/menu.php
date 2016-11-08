<?php if($frkohgb!="ok"){header("Location: index.php");	exit;}?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" background="<?php echo $wolf_path; ?>img/menu.gif" height="25">
						<tr>
							<td valign="middle" width="100%">
								<table cellpadding="0" cellspacing="0" border="0">
									<tr>
<td valign="middle" width="30" align="center"><a href="<?php echo $wolf_path; ?>member.php?lang=<?php echo $lang."&ver=".$ver; ?>"><img src="<?php echo $wolf_path; ?>img/majas.gif" border="0" align="middle" hspace="5"></a></td>

<?php if($module_1 == "on"){?>
<td valign="middle"><img src="<?php echo $wolf_path; ?>img/starp.gif" hspace="5"></td> 
<td valign="middle" align="center"><a href="<?php echo $wolf_path; ?>teksti/index.php?lang=<?php echo $lang."&ver=".$ver; ?>" class="menu"><?php echo $menu_it[3]; ?></a></td>
<?php } ?>
<?php if($module_2 == "on"){?>
<td valign="middle"><img src="<?php echo $wolf_path; ?>img/starp.gif" hspace="5"></td> 
<td valign="middle" align="center"><a href="<?php echo $wolf_path; ?>veikals/index.php?lang=<?php echo $lang."&ver=".$ver; ?>" class="menu"><?php echo $menu_it[7]; ?></a></td>
<?php } ?>
<?php if($module_3 == "on"){?>
<td valign="middle"><img src="<?php echo $wolf_path; ?>img/starp.gif" hspace="5"></td> 
<td valign="middle" align="center"><a href="<?php echo $wolf_path; ?>persons/index.php?lang=<?php echo $lang."&ver=".$ver; ?>" class="menu"><?php echo $menu_it[8]; ?></a></td>
<?php } ?>
<?php if($module_4 == "on"){?>
<td valign="middle"><img src="<?php echo $wolf_path; ?>img/starp.gif" hspace="5"></td> 
<td valign="middle" align="center"><a href="<?php echo $wolf_path; ?>anketas/index.php?lang=<?php echo $lang."&ver=".$ver; ?>" class="menu"><?php echo $menu_it[14]; ?></a></td>
<?php } ?>
<?php if($module_5 == "on"){?>
<td valign="middle"><img src="<?php echo $wolf_path; ?>img/starp.gif" hspace="5"></td> 
<td valign="middle" align="center"><a href="<?php echo $wolf_path; ?>klienti/index.php?lang=<?php echo $lang."&ver=".$ver; ?>" class="menu"><?php echo $menu_it[29]; ?></a></td>
<?php } ?>
<?php if($module_6 == "on"){?>
<td valign="middle"><img src="<?php echo $wolf_path; ?>img/starp.gif" hspace="5"></td>
<td valign="middle" align="center"><a href="<?php echo $wolf_path; ?>pirkumi/delet_session.php?lang=<?php echo $lang."&ver=".$ver; ?>" class="menu"><?php echo $menu_it[24]; ?></a></td>
<?php } ?>
<?php if($module_7 == "on"){?>
<td valign="middle"><img src="<?php echo $wolf_path; ?>img/starp.gif" hspace="5"></td>  
<td valign="middle" align="center"><a href="<?php echo $wolf_path; ?>titulpage.php?lang=<?php echo $lang."&ver=".$ver; ?>" class="menu"><?php echo $menu_it[23]; ?></a></td>
<?php } ?>

<?php if($module_8 == "on"){?>
<td valign="middle"><img src="<?php echo $wolf_path; ?>img/starp.gif" hspace="5"></td>  
<td valign="middle" align="center"><a href="<?php echo $wolf_path; ?>banneri/index.php?lang=<?php echo $lang."&ver=".$ver; ?>" class="menu"><?php echo $menu_it[12]; ?></a></td>
<?php } ?>

<?php if($module_9 == "on"){?>
<td valign="middle"><img src="<?php echo $wolf_path; ?>img/starp.gif" hspace="5"></td>  
<td valign="middle" align="center"><a href="<?php echo $wolf_path; ?>foto/index.php?lang=<?php echo $lang."&ver=".$ver; ?>" class="menu"><?php echo $menu_it[13]; ?></a></td>
<?php } ?>

<?php if($module_10 == "on"){?>
<td valign="middle"><img src="<?php echo $wolf_path; ?>img/starp.gif" hspace="5"></td>  
<td valign="middle" align="center"><a href="<?php echo $wolf_path; ?>discounts/index.php?lang=<?php echo $lang."&ver=".$ver; ?>" class="menu"><?php echo $menu_it[21]; ?></a></td>
<?php } ?>

<td valign="middle"><img src="<?php echo $wolf_path; ?>img/starp.gif" hspace="5"></td>  
  

									</tr>
								</table>
							</td>
							
						</tr>
					</table>
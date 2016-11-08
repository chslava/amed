<?php if($frkohgb!="ok"){header("Location: index.php");	exit;}?>
			<tr>
				<td background="<?php echo $wolf_path; ?>img/ena_kreisa.gif" rowspan="4" width="42">
					<table width="42" height="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table>
				</td>
				<td width="100%" bgcolor="#d0d2dd" valign="top" colspan="2" height="25">
					<table cellpadding="0" cellspacing="0" border="0" width="100%" background="<?php echo $wolf_path; ?>img/augsa.gif" height="70">
						<tr>
							<td><iframe scrolling="No" width="236" height="70" src="<?php echo $wolf_path; ?>refresh.php" frameborder="0"></iframe></td>
							<td align="right" valign="bottom">
								<table cellpadding="0" cellspacing="0" border="0">
                       		<tr>
                           	<td height="25" align="right">
                              	<table cellpadding="5" cellspacing="0" border="0">
                                 	<tr>
                                    
                                    <?php 
													if($us == "yes")
													{
													
												?>
                                    	<td valign="middle" align="center" class="standart"><a href="<?php echo $wolf_path; ?>users/index.php?lang=<?php echo $lang."&ver=".$ver; ?>" class="sub_menu"><?php echo $menu_it[2]; ?></a></td>
                                       <td valign="middle" align="center" class="standart" ><a href="<?php echo $wolf_path; ?>users/dati.php<?php echo $li1; ?>" class="sub_menu"><?php echo $menu_it[5]; ?></a></td>
                                       <?php 
													}
													?>
                                      <td valign="middle" align="center" class="standart" ><a href="<?php echo $wolf_path; ?>keywords/index.php" class="sub_menu"><?php echo $menu_it[41]; ?></a></td>
                                      <td valign="middle" align="center" class="standart" ><a href="<?php echo $wolf_path; ?>icons/index.php" class="sub_menu"><?php echo $menu_it[42]; ?></a></td>


                                       <td valign="middle" align="center" class="standart" ><a href="<?php echo $wolf_path; ?>logout.php" class="sub_menu"><?php echo $menu_it[1]; ?></a></td>
                                    </tr>
                                 </table>
                              </td>
                           </tr>
                        	<tr>
                           	<td height="20"></td>
                           </tr>
									<tr>
                           	<td align="right">
                              	<table cellpadding="5" cellspacing="0" border="0">
                                 	<tr>
													
                                       <td class="standart"><?php echo $nosaukumi[$ver]; ?></td>
                                       <td><a href="<?php echo $wolf_path; ?>member.php?lang=<?php echo $lang."&ver=lv"; ?>"><img src="<?php echo $wolf_path; ?>img/lv.gif" border="0"></td>
                                       
                                      	<td><a href="<?php echo $wolf_path; ?>member.php?lang=<?php echo $lang."&ver=ru"; ?>"><img src="<?php echo $wolf_path; ?>img/ru.gif" border="0"></td>
                                      	
                                       <td><a href="<?php echo $wolf_path; ?>member.php?lang=<?php echo $lang."&ver=en"; ?>"><img src="<?php echo $wolf_path; ?>img/en.gif" border="0"></td>
                                       
                                      
                                       <td class="standart"><?php datums(); ?></td>
                                    </tr>
                                  </table>
                               </td>

											
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
				<td background="<?php echo $wolf_path; ?>img/ena.gif" rowspan="4" width="42">
					<table width="42" height="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
			
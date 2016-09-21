<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

$row=mysqli_query($result_db,"Select * from $tabula where id='$id'");
$fer=mysqli_fetch_array($row);
mysqli_free_result($row);
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
			function change (target)
			{	
				var element = document.getElementById(target);
				<?php
				if(empty($fer["name"]))
				{
				?>
					var url_text = element.value;
					var title_text  = element.value + "<?php echo " | $e[4]"; ?>";
					var description_text  = element.value + "<?php echo ". $e[5]"; ?>";
					var keywords_text  = element.value;
				<?php
				}
				else
				{
				?>
					var url_text = "<?php echo $fer["url"]."/"; ?>" + element.value;
					var title_text  = element.value + "<?php echo " | ".$fer["name"]." | $e[4]"; ?>";
					var description_text  = element.value + "<?php echo ". ".$fer["name"].". $e[5]"; ?>";
					var keywords_text  = element.value + "<?php echo ", ",$fer["name"]; ?>";
				<?php
				}
				?>
				
				
				
				
				var replace = new Array(/A/g,/B/g,/C/g,/D/g,/E/g,/F/g,/G/g,/H/g,/I/g,/J/g,/K/g,/L/g,/M/g,/N/g,/O/g,/P/g,/R/g,/S/g,/T/g,/U/g,/V/g,/Z/g,/Q/g,/W/g,/Y/g,/Ā/g,/Č/g,/Ē/g,/Ģ/g,/Ī/g,/Ķ/g,/Ļ/g,/Ņ/g,/Š/g,/Ū/g,/Ž/g,/ā/g,/č/g,/ē/g,/ģ/g,/ī/g,/ķ/g,/ļ/g,/ņ/g,/š/g,/ū/g,/ž/g,/ /g); 
				var by = new Array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","r","s","t","u","v","z","q","w","y","a","c","e","g","i","k","l","n","s","u","z","a","c","e","g","i","k","l","n","s","u","z","-"); 
				for (var i=0; i<replace.length; i++)
				{ 
					url_text = url_text.replace(replace[i], by[i]); 
				} 
				
				var replace1 = new Array(/A/g,/B/g,/C/g,/D/g,/E/g,/F/g,/G/g,/H/g,/I/g,/J/g,/K/g,/L/g,/M/g,/N/g,/O/g,/P/g,/R/g,/S/g,/T/g,/U/g,/V/g,/Z/g,/Q/g,/W/g,/Y/g,/ /g,/,,/g); 
				var by1 = new Array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","r","s","t","u","v","z","q","w","y",", ",","); 
				for (var i=0; i<replace1.length; i++)
				{ 
					keywords_text = keywords_text.replace(replace1[i], by1[i]); 
				} 
								
				

			  function filterUrl(str1) {
					 re = /\$|,|@|#|~|`|\%|\*|\^|\&|\(|\)|\+|\=|\[|\\_|\]|\[|\}|\{|\;|\:|\'|\"|\<|\>|\?|\||\\|\!|\$|\./g;
					 // remove special characters like "$" and "," etc...
					 return str1.replace(re, "");
			  }
			  
			 	function filterText(str1) {
					 re = /\$|,|@|#|~|`|\%|\*|\^|\&|\(|\)|\+|\=|\[|\\_|\]|\[|\}|\{|\;|\:|\'|\"|\<|\>|\?|\|\|\!|\$|/g;
					 // remove special characters like "$" and "," etc...
					 return str1.replace(re, "");
			  }
			  
			  function filterKeywords(str1) {
					 re = /\$|@|#|~|`|\%|\*|\^|\&|\(|\)|\+|\=|\[|\\_|\]|\[|\}|\{|\;|\:|\'|\"|\<|\>|\?|\|\|\!|\$|\./g;
					 // remove special characters like "$" and "," etc...
					 return str1.replace(re, "");
			  }
			  
			  document.jaunumi.url.value= filterUrl(url_text);
			  document.jaunumi.title.value = filterText(title_text);
			  document.jaunumi.description.value = filterText(description_text);
			  document.jaunumi.keywords.value = filterKeywords(keywords_text);
			  
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
				<?php require_once($wolf_path."izveleta.php"); ?>
				</td>
			</tr>
			<tr>
				<td width="250" valign="top" bgcolor="#f2f3f7">
				<?php require_once($wolf_path."page_menu.php"); ?>
				</td>
				<td bgcolor="#ffffff" width="100%" valign="top" class="text">
				
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
                  <tr>
                     <td height="30" valign="top" class="sad"><a href="apakssadala.php<?php echo $li; ?>" class="sad_link"><?php echo $categories[3]; ?></a></td>
                  </tr>
               </table>
					<table cellpadding="5" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd">
               	<tr>
                     <td class="standart" bgcolor="#f2f3f7" colspan="8"><b><?php echo $categories[1]; ?></b></td>
                  </tr>
						<form action="apakssadala_ok.php<?php echo $li; ?>" method="post" name="jaunumi">
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $teksti[2]; ?></b></td>
							<td valign="middle"><input type="text" name="name" class="input" style="width: 270px" onKeyUp="change('name')" id="name"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $teksti[4]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="title" value="<?php echo $e[4]; ?>" style="width: 270px" id="title"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $teksti[5]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="description" style="width:400px" value="<?php echo $e[5]; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $teksti[46]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="keywords" style="width: 270px"></td>
						</tr>
                  <tr>
							<td valign="middle" align="right" class="standart" width="200"><div><b><?php echo $teksti[81]; ?></b></div><div class="mazais"><?php echo $teksti[83]; ?></div></td>
							<td valign="middle"><input type="text" name="url" class="input" style="width: 270px"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $teksti[85]; ?></b></td>
							<td valign="middle">
                     
							<select class="input" name="template">
                                <option value="0"></option>                                
                              	<option value="1"><?php echo $menu_it[30]; ?></option>
                                <option value="2"><?php echo $menu_it[31]; ?></option>
                                <option value="3"><?php echo $menu_it[36]; ?></option>
                                <option value="4"><?php echo $menu_it[43]; ?></option>
                            </select>
							</td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $teksti[89]; ?></b></td>
							<td valign="middle">
                     		<select class="input" name="anketa">
                   				<option value="0"></option>
                     			<?php
									$ren=mysqli_query($result_db,"Select * from anketas where value='1' order by id asc");
									while($row=mysqli_fetch_array($ren))
									{
										echo "<option value=\"$row[id]\">$row[name]</option>";							
                     				}
									mysqli_free_result($ren);
								?>
                        	</select>
							</td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart"><b><?php echo $teksti[154]; ?></b></td>
							<td valign="middle">
                     	<select class="input" name="album">
                   			<option value="0"></option>
                     		<?php
									$name_lang = "name_".$ver;
									$a = 1;
									$ren=mysqli_query($result_db,"Select * from albums where parent_id = '0' order by place asc");
									while($row=mysqli_fetch_array($ren))
									{
										echo "<option value=\"$row[id]\">$a. $row[$name_lang]</option>";
										$b = 1;
										$ren1=mysqli_query($result_db,"Select * from albums where parent_id = '$row[id]' order by place asc");
										while($row1=mysqli_fetch_array($ren1))
										{
											echo "<option value=\"$row1[id]\">&nbsp;&nbsp;&nbsp;&nbsp;$a.$b. $row1[$name_lang]</option>";
											$b++;
										}
										mysqli_free_result($ren1);
										$a++;							
                     		}
                     		mysqli_free_result($ren);
                     		?>
                        </select>
							</td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><div><b><?php echo $categories[4]; ?></b></div></td>
							<td valign="middle" class="standart">
								<input type="radio" name="type" value="1" checked><?php echo $teksti[149]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
								<input type="radio" name="type" value="2"><?php echo $teksti[138]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
								<input type="radio" name="type" value="3"><?php echo $teksti[152]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
								<input type="radio" name="type" value="4"><?php echo $teksti[158]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
							</td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $teksti[6]; ?></b></td>
							<td valign="middle"><input type="text" name="link" class="input" style="width: 270px"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $teksti[7]; ?></b></td>
							<td valign="middle">
							<select class="input" name="target">
								<option value="_top"><?php echo $teksti[8]; ?></option>
								<option value="_blank"><?php echo $teksti[9]; ?></option>
							</select>
							</td>
						</tr>
						
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $teksti[151]; ?></b></td>
							<td valign="middle">
						<?php 
						
						$direk="../../images/icons/";
	  					$d=opendir($direk);
						$s=1;
	  					while(($files=readdir($d))!==false)
						{
	  						$filename=$direk.$files;
	   					if($files=="."||$files==".." || $files=="Thumbs.db" || $files==".DS_Store"){}
	  						else{
							if($s==1){$ch = " checked";}else{$ch="";}
	  						echo "
							
									<div style=\"float:left; text-align:center; padding: 5px;\">
										
										<img  src=\"../../images/icons/$files\" width=\"25\" height=\"25\" /><br /><input type=\"Radio\" class=\"ch\" name=\"icon\" value=\"$files\" $ch>
									</div>
								";$s++;
							}
							
						}
						?>
                  	</td>
						</tr>
						
						<tr>
							<td valign="middle" width="200">&nbsp;</td>
							<td valign="middle"><input type="submit" name="submit" class="button" value="<?php echo $teksti[3]; ?>"></td>
						</tr>
						</form>
					</table>
					
				</td>
			</tr>
		</table>
	</body>
</html>


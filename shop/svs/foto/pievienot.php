<?php
//ielâdçjam funkcijas
require_once("../config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

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
						
				
				var url_text = "foto/" + element.value;
				var title_text  = element.value + "<?php echo " | $e[1]"; ?>";
				var description_text  = element.value + "<?php echo ". $e[2]"; ?>";
				var keywords_text  = element.value;
				
				
				
				
				var replace = new Array(/A/g,/B/g,/C/g,/D/g,/E/g,/F/g,/G/g,/H/g,/I/g,/J/g,/K/g,/L/g,/M/g,/N/g,/O/g,/P/g,/R/g,/S/g,/T/g,/U/g,/V/g,/Z/g,/Q/g,/W/g,/Y/g,/Ā/g,/Č/g,/Ē/g,/Ģ/g,/Ī/g,/Ķ/g,/Ļ/g,/Ņ/g,/Š/g,/Ū/g,/Ž/g,/ā/g,/č/g,/ē/g,/ģ/g,/ī/g,/ķ/g,/ļ/g,/ņ/g,/š/g,/ū/g,/ž/g,/ /g,/А/g,/а/g,/Б/g,/б/g,/В/g,/в/g,/Г/g,/г/g,/Д/g,/д/g,/Е/g,/е/g,/Ё/g,/ё/g,/Ж/g,/ж/g,/З/g,/з/g,/І/g,/і/g,/Й/g,/й/g,/К/g,/к/g,/Л/g,/л/g,/М/g,/м/g,/Н/g,/н/g,/О/g,/о/g,/П/g,/п/g,/Р/g,/р/g,/С/g,/с/g,/Т/g,/т/g,/У/g,/у/g,/Ф/g,/ф/g,/Х/g,/х/g,/Ц/g,/ц/g,/Ч/g,/ч/g,/Ш/g,/ш/g,/Ы/g,/ы/g,/Ь/g,/ь/g,/Э/g,/э/g,/Ю/g,/ю/g,/Я/g,/я/g,/Щ/g,/щ/g,/Ъ/g,/ъ/g,/И/g,/и/g); 
				var by = new Array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","r","s","t","u","v","z","q","w","y","a","c","e","g","i","k","l","n","s","u","z","a","c","e","g","i","k","l","n","s","u","z","-","a","a","b","b","v","v","g,","g,","d","d","je","je","jo","jo","zh","zh","z","z","i","i","j","j","k","k","l","l","m","m","n","n","o","o","p","p","r","r","s","s","t","t","u","u","f","f","h","h","c","c","ch","ch","sh","sh","i","i","","","e","e","ju","ju","ja","ja","shch","shch","","","i","i"); 
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
			  
			  
				if(target == "name_lv")
			  	{
					document.jaunumi.url_lv.value= filterUrl(url_text);
				 	document.jaunumi.title_lv.value = filterText(title_text);
				  	document.jaunumi.description_lv.value = filterText(description_text);
				  	document.jaunumi.keywords_lv.value = filterKeywords(keywords_text);
				}
				
				if(target == "name_ru")
				{
					document.jaunumi.url_ru.value= filterUrl(url_text);
				 	document.jaunumi.title_ru.value = filterText(title_text);
				  	document.jaunumi.description_ru.value = filterText(description_text);
				  	document.jaunumi.keywords_ru.value = filterKeywords(keywords_text);
				}
				
				if(target == "name_en")
				{
					document.jaunumi.url_en.value= filterUrl(url_text);
				 	document.jaunumi.title_en.value = filterText(title_text);
				  	document.jaunumi.description_en.value = filterText(description_text);
				  	document.jaunumi.keywords_en.value = filterKeywords(keywords_text);
				}
				
				if(target == "name_ee")
				{
					document.jaunumi.url_ee.value= filterUrl(url_text);
				 	document.jaunumi.title_ee.value = filterText(title_text);
				  	document.jaunumi.description_ee.value = filterText(description_text);
				  	document.jaunumi.keywords_ee.value = filterKeywords(keywords_text);
				}
				
				if(target == "name_lt")
				{
					document.jaunumi.url_lt.value= filterUrl(url_text);
				 	document.jaunumi.title_lt.value = filterText(title_text);
				  	document.jaunumi.description_lt.value = filterText(description_text);
				  	document.jaunumi.keywords_lt.value = filterKeywords(keywords_text);
				}
			  
			}
			
			function changeLanguageLV() {
				document.getElementById('lv').className = 'select-on';
				document.getElementById('ru').className = 'select';
				document.getElementById('en').className = 'select';
				document.getElementById('ee').className = 'select';
				document.getElementById('lt').className = 'select';
				document.getElementById('lv-content').style.display = "block";
				document.getElementById('ru-content').style.display = "none";
				document.getElementById('en-content').style.display = "none";
				document.getElementById('ee-content').style.display = "none";
				document.getElementById('lt-content').style.display = "none";
			}
			
			function changeLanguageRU() {
				document.getElementById('lv').className = 'select';
				document.getElementById('ru').className = 'select-on';
				document.getElementById('en').className = 'select';
				document.getElementById('ee').className = 'select';
				document.getElementById('lt').className = 'select';
				document.getElementById('lv-content').style.display = "none";
				document.getElementById('ru-content').style.display = "block";
				document.getElementById('en-content').style.display = "none";
				document.getElementById('ee-content').style.display = "none";
				document.getElementById('lt-content').style.display = "none";
			}
			
			function changeLanguageEN() {
				document.getElementById('lv').className = 'select';
				document.getElementById('ru').className = 'select';
				document.getElementById('en').className = 'select-on';
				document.getElementById('ee').className = 'select';
				document.getElementById('lt').className = 'select';
				document.getElementById('lv-content').style.display = "none";
				document.getElementById('ru-content').style.display = "none";
				document.getElementById('en-content').style.display = "block";
				document.getElementById('ee-content').style.display = "none";
				document.getElementById('lt-content').style.display = "none";
			}
			
			function changeLanguageEE() {
				document.getElementById('lv').className = 'select';
				document.getElementById('ru').className = 'select';
				document.getElementById('en').className = 'select';
				document.getElementById('ee').className = 'select-on';
				document.getElementById('lt').className = 'select';
				document.getElementById('lv-content').style.display = "none";
				document.getElementById('ru-content').style.display = "none";
				document.getElementById('en-content').style.display = "none";
				document.getElementById('ee-content').style.display = "block";
				document.getElementById('lt-content').style.display = "none";
			}
			
			function changeLanguageLT() {
				document.getElementById('lv').className = 'select';
				document.getElementById('ru').className = 'select';
				document.getElementById('en').className = 'select';
				document.getElementById('ee').className = 'select';
				document.getElementById('lt').className = 'select-on';
				document.getElementById('lv-content').style.display = "none";
				document.getElementById('ru-content').style.display = "none";
				document.getElementById('en-content').style.display = "none";
				document.getElementById('ee-content').style.display = "none";
				document.getElementById('lt-content').style.display = "block";
			}
		</script>
      
      <style>
			#lv-content {
				display:block;
			}
			
			#ru-content {
				display:none;
			}
			
			#en-content {
				display:none;
			}
			
			#ee-content {
				display:none;
			}
			
			#lt-content {
				display:none;
			}

		</style>
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
                     <td valign="top" class="sad"><a href="index.php<?php echo $li1; ?>" class="sad_link"><?php echo $menu_it[13]; ?></a> <img src="<?php echo $wolf_path; ?>img/next.gif" align="absmiddle"> <a href="pievienot.php<?php echo $li1; ?>" class="sad_link"><?php echo $foto[51]; ?></a></td>
                  </tr>
                  <tr>
                     <td height="10" ></td>
                  </tr>
               </table>
					
               <table cellpadding="0" cellspacing="0" border="0" width="100%" >
               			<tr>
               		 		<td class="standart" style="border-bottom: 1px solid #d0d2dd;">&nbsp;</td>
                     		<td id="lv" class="select-on"><a href="javascript: void(0)" onClick="changeLanguageLV()"><?php echo $head[2]; ?></a></td>               		                    
                     		<td width="5" style="border-bottom: 1px solid #d0d2dd;">&nbsp;</td>
                     		<td id="ru" class="select"><a href="javascript: void(0)" onClick="changeLanguageRU()"><?php echo $head[3]; ?></a></td>
                     		<td width="5" style="border-bottom: 1px solid #d0d2dd;">&nbsp;</td>
                     		<td id="en" class="select"><a href="javascript: void(0)" onClick="changeLanguageEN()"><?php echo $head[4]; ?></a></td>
                     		<td width="5" style="border-bottom: 1px solid #d0d2dd;">&nbsp;</td>
                     		<td id="ee" class="select"><a href="javascript: void(0)" onClick="changeLanguageEE()"><?php echo $head[5]; ?></a></td>
                     		<td width="5" style="border-bottom: 1px solid #d0d2dd;">&nbsp;</td>
                     		<td id="lt" class="select"><a href="javascript: void(0)" onClick="changeLanguageLT()"><?php echo $head[6]; ?></a></td>  
                 		</tr>
               		</table>
               
               <form action="pievienot_ok.php<?php echo $li; ?>" method="post" name="jaunumi" style="margin:0px;">
               
					<table cellpadding="5" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd; border-top:none;" id="lv-content">
               	<tr>
                     <td class="standart" bgcolor="#f2f3f7" colspan="2"><b><?php echo $foto[52]; ?></b></td>
                  </tr>
						
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $foto[31]; ?>:</b></td>
							<td valign="middle"><input type="text" name="name_lv" class="input" style="width: 270px" onKeyUp="change('name_lv')" id="name_lv"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart"><b><?php echo $teksti[4]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="title_lv" value="<?php echo $e[1]; ?>" style="width: 270px" id="title"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart"><b><?php echo $teksti[5]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="description_lv" style="width:400px" value="<?php echo $e[2]; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart"><b><?php echo $teksti[46]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="keywords_lv" style="width: 270px"></td>
						</tr>
                  <tr>
							<td valign="middle" align="right" class="standart"><div><b><?php echo $teksti[81]; ?></b></div><div class="mazais"><?php echo $teksti[83]; ?></div></td>
							<td valign="middle"><input type="text" name="url_lv" class="input" style="width: 270px"></td>
						</tr>
                  <tr>
							<td valign="top" align="right" class="standart"><b><?php echo $foto[34]; ?>:</b></td>
							<td valign="middle"><textarea name="text_lv" class="input" rows="10" cols="70"></textarea></td>
						</tr>
                  
						
									
					</table>
               
               <table cellpadding="5" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd; border-top:none;" id="ru-content">
               	<tr>
                     <td class="standart" bgcolor="#f2f3f7" colspan="2"><b><?php echo $foto[52]; ?></b></td>
                  </tr>
						
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $foto[31]; ?>:</b></td>
							<td valign="middle"><input type="text" name="name_ru" class="input" style="width: 270px" onKeyUp="change('name_ru')" id="name_ru"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart"><b><?php echo $teksti[4]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="title_ru" value="<?php echo $e[4]; ?>" style="width: 270px" id="title"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart"><b><?php echo $teksti[5]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="description_ru" style="width:400px" value="<?php echo $e[5]; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart"><b><?php echo $teksti[46]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="keywords_ru" style="width: 270px"></td>
						</tr>
                  <tr>
							<td valign="middle" align="right" class="standart"><div><b><?php echo $teksti[81]; ?></b></div><div class="mazais"><?php echo $teksti[83]; ?></div></td>
							<td valign="middle"><input type="text" name="url_ru" class="input" style="width: 270px"></td>
						</tr>
                  <tr>
							<td valign="top" align="right" class="standart"><b><?php echo $foto[34]; ?>:</b></td>
							<td valign="middle"><textarea name="text_ru" class="input" rows="10" cols="70"></textarea></td>
						</tr>
						
									
					</table>
               
               <table cellpadding="5" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd; border-top:none;" id="en-content">
               	<tr>
                     <td class="standart" bgcolor="#f2f3f7" colspan="2"><b><?php echo $foto[52]; ?></b></td>
                  </tr>
						
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $foto[31]; ?>:</b></td>
							<td valign="middle"><input type="text" name="name_en" class="input" style="width: 270px" onKeyUp="change('name_en')" id="name_en"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart"><b><?php echo $teksti[4]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="title_en" value="<?php echo $e[4]; ?>" style="width: 270px" id="title"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart"><b><?php echo $teksti[5]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="description_en" style="width:400px" value="<?php echo $e[5]; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart"><b><?php echo $teksti[46]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="keywords_en" style="width: 270px"></td>
						</tr>
                  <tr>
							<td valign="middle" align="right" class="standart"><div><b><?php echo $teksti[81]; ?></b></div><div class="mazais"><?php echo $teksti[83]; ?></div></td>
							<td valign="middle"><input type="text" name="url_en" class="input" style="width: 270px"></td>
						</tr>
                  <tr>
							<td valign="top" align="right" class="standart"><b><?php echo $foto[34]; ?>:</b></td>
							<td valign="middle"><textarea name="text_en" class="input" rows="10" cols="70"></textarea></td>
						</tr>
						
								
					</table>
              
               <table cellpadding="5" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd; border-top:none;" id="ee-content">
               	<tr>
                     <td class="standart" bgcolor="#f2f3f7" colspan="2"><b><?php echo $foto[52]; ?></b></td>
                  </tr>
						
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $foto[31]; ?>:</b></td>
							<td valign="middle"><input type="text" name="name_ee" class="input" style="width: 270px" onKeyUp="change('name_ee')" id="name_ee"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart"><b><?php echo $teksti[4]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="title_ee" value="<?php echo $e[4]; ?>" style="width: 270px" id="title"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart"><b><?php echo $teksti[5]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="description_ee" style="width:400px" value="<?php echo $e[5]; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart"><b><?php echo $teksti[46]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="keywords_ee" style="width: 270px"></td>
						</tr>
                  <tr>
							<td valign="middle" align="right" class="standart"><div><b><?php echo $teksti[81]; ?></b></div><div class="mazais"><?php echo $teksti[83]; ?></div></td>
							<td valign="middle"><input type="text" name="url_ee" class="input" style="width: 270px"></td>
						</tr>
                  <tr>
							<td valign="top" align="right" class="standart"><b><?php echo $foto[34]; ?>:</b></td>
							<td valign="middle"><textarea name="text_ee" class="input" rows="10" cols="70"></textarea></td>
						</tr>
						
									
					</table>
					<table cellpadding="5" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd; border-top:none;" id="lt-content">
               	<tr>
                     <td class="standart" bgcolor="#f2f3f7" colspan="2"><b><?php echo $foto[52]; ?></b></td>
                  </tr>
						
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $foto[31]; ?>:</b></td>
							<td valign="middle"><input type="text" name="name_lt" class="input" style="width: 270px" onKeyUp="change('name_lt')" id="name_lt"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart"><b><?php echo $teksti[4]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="title_lt" value="<?php echo $e[4]; ?>" style="width: 270px" id="title"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart"><b><?php echo $teksti[5]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="description_lt" style="width:400px" value="<?php echo $e[5]; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart"><b><?php echo $teksti[46]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="keywords_lt" style="width: 270px"></td>
						</tr>
                  <tr>
							<td valign="middle" align="right" class="standart"><div><b><?php echo $teksti[81]; ?></b></div><div class="mazais"><?php echo $teksti[83]; ?></div></td>
							<td valign="middle"><input type="text" name="url_lt" class="input" style="width: 270px"></td>
						</tr>
                  <tr>
							<td valign="top" align="right" class="standart"><b><?php echo $foto[34]; ?>:</b></td>
							<td valign="middle"><textarea name="text_lt" class="input" rows="10" cols="70"></textarea></td>
						</tr>
						
									
					</table>
               
               <table cellpadding="0" cellspacing="0" border="0"> 
              		<tr>
                  	<td valign="middle" height="30"><input type="submit" name="submit" class="button" value="<?php echo $foto[35]; ?>"></td>
						</tr>						
					</table>
					</form>
               
               
               
               
               
               
               
               
               
               
					
				</td>
			</tr>
		</table>
	</body>
</html>


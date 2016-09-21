<?php
require_once("config.php");
require_once($wolf_path."check.php");

if(isset($_POST["submit"]))
{
	$change_from=array("'","\\","\"");
	$change_to=array("`","","&quot;");	
	
	if(!empty($_POST["sadala"]))
	{
		$sadala=str_replace($change_from,$change_to,$_POST["sadala"]);
		$sadala=trim($sadala);
		
		$req=mysqli_query($result_db,"Select place from items where parent_id='$sadala' order by place desc limit 0,1");echo mysqli_error();
		if($roq=mysqli_fetch_array($req))
		{
			$place=$roq["place"];
			$place++;
		}
		else
		{
			$place = 1;
		}		
		
		$r=mysqli_query($result_db,"Select * from items where id='$name'");
		$f=mysqli_fetch_array($r);
			
		if (!empty($f["picture"]))
		{
			$file = trim(str_replace("/","-",$f["url_lv"]));
			$name_file = $file.".jpg";
			$picture = $file."-".time().".jpg";
			
			copy("../../pictures/items/small/$f[picture]","../../pictures/items/small/$picture");			
			copy("../../pictures/items/big/$f[picture]","../../pictures/items/big/$picture");						
		}
		else
		{
			$picture = "";
		}
	 			
		$rakstam=mysqli_query($result_db,"insert into items (
		`parent_id`, `place`, `statuss`, `picture`, `title_ee`, `title_lv`, `title_lt`, `title_ru`, `title_en`, `description_ee`,
		`description_lv`, `description_lt`, `description_ru`, `description_en`, `keywords_ee`, `keywords_lv`, `keywords_lt`, 
		`keywords_ru`, `keywords_en`, `url_ee`, `url_lv`, `url_lt`, `url_ru`, `url_en`, `name_ee`, `name_lv`, `name_lt`,
		`name_ru`, `name_en`, `text_ee`, `text_lv`, `text_lt`, `text_ru`, `text_en`, `code`, 
		`price`, `discount`, `discount_price`, `new`, `storage`, `speciality`, `items`, `person`, `branch`, 
		`rate`, `buy`, `discount_percent`, `copy`
		) 
			values 
		(
		'$sadala', '$place', '$f[statuss]', '$picture', '$f[title_ee]', '$f[title_lv]', '$f[title_lt]', '$f[title_ru]', '$f[title_en]', '$f[description_ee]',
		'$f[description_lv]', '$f[description_lt]', '$f[description_ru]', '$f[description_en]', '$f[keywords_ee]', '$f[keywords_lv]', '$f[keywords_lt]', 
		'$f[keywords_ru]', '$f[keywords_en]', '$f[url_ee]', '$f[url_lv]', '$f[url_lt]', '$f[url_ru]', '$f[url_en]', '$f[name_ee]', '$f[name_lv]', '$f[name_lt]',
		'$f[name_ru]', '$f[name_en]', '$f[text_ee]', '$f[text_lv]', '$f[text_lt]', '$f[text_ru]', '$f[text_en]', '$f[code]', 
		'$f[price]', '$f[discount]', '$f[discount_price]', '$f[new]', '$f[storage]', '$f[speciality]', '$f[items]', '$f[person]', '$f[branch]', 
		'$f[rate]', '$f[buy]', '$f[discount_percent]', '$name'	
		)
		"); echo mysqli_error();
		
		$last_id = mysqli_insert_id();
		
		$url_lv_n = str_replace('-'.$name,'',$f['url_lv']);
		$url_ru_n = str_replace('-'.$name,'',$f['url_ru']);
		$url_en_n = str_replace('-'.$name,'',$f['url_en']);
		$url_ee_n = str_replace('-'.$name,'',$f['url_ee']);
		$url_lt_n = str_replace('-'.$name,'',$f['url_lt']);
		
		$url_lv_n = $url_lv_n.'-'.$last_id;
		$url_ru_n = $url_ru_n.'-'.$last_id;
		$url_en_n = $url_en_n.'-'.$last_id;
		$url_ee_n = $url_ee_n.'-'.$last_id;
		$url_lt_n = $url_lt_n.'-'.$last_id;
		
		$result = mysqli_query($result_db,"update items set 
	
		url_lv = '$url_lv_n,
		url_ru = '$url_ru_n',
		url_en = '$url_en_n',
		url_ee = '$url_ee_n',
		url_lt = '$url_lt_n'
		
		where id = '$last_id'");
		
		$query1 = mysqli_query($result_db,"select * from branches_items where item_id = '$name'");
		while($mysql1 = mysqli_fetch_array($query1))
		{
			$result = mysqli_query($result_db,"insert into branches_items (`branche_id`,`item_id`,`place`,`group_type`,`category_id`) values ('$mysql1[branche_id]','$last_id','$mysql1[place]','$mysql1[group_type]','$mysql1[category_id]')");
		}
		
		$links ="index.php".$li1.'&id='.$sadala;
	}
	else
	{
		$links ="index.php".$li;
	}

	header("Location: $links");
	exit;
}
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
                     <td height="30" valign="top" class="sad"><a href="parvietot.php<?php echo $li; ?>" class="sad_link"><?php echo $item[0]; ?></a></td>
                  </tr>
               </table>
               <form name="prece" enctype="multipart/form-data" action="p_related.php<?php echo $li.'&name='.$name; ?>" method="post">
					<table cellpadding="5" cellspacing="1" border="0" style="border: 1px solid #d0d2dd" width="100%">
					<tr>
	  					<td class="standart" bgcolor="#f2f3f7" colspan="9"><b><?php echo $item[93]; ?></b></td>
	  				</tr>
					<?php 
											
					$krasa=array("#ffffff","#f4f5f8");
					
					$kr=0;
					
					$tabula="categories";
					function sad($parent_id,$indent,$tabula,$ver,$kr)
					{
						$indent=$indent."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						$r1=mysqli_query($result_db,"Select * from $tabula where parent_id='$parent_id' order by place asc");
							
						while($f1=mysqli_fetch_array($r1))
						{
							echo "$indent<input type=\"radio\" name=\"sadala\" value=\"$f1[id]\"> <b>$f1[name_lv]</b><br>\n";
						
							sad($f1["id"],$indent,$tabula,$ver,$kr);
						}
					}
					
					$indent="&nbsp;&nbsp;&nbsp;&nbsp;";
					$r=mysqli_query($result_db,"Select * from categories where parent_id='0' order by place asc");
					while($f=mysqli_fetch_array($r))
					{
						echo "<tr bgcolor=\"$krasa[$kr]\"><td class=\"standart\" width=\"300\"><input type=\"radio\" name=\"sadala\" value=\"$f[id]\"> <b>$f[name_lv]</b><br>\n";
													
						sad($f["id"],$indent,$tabula,$ver,$kr);
						echo "</td></tr>";
						if($kr==0){	$kr=1;}
						elseif($kr==1){	$kr=0;}
					}
					?>
  						
					</table>
               
               <table cellpadding="0" cellspacing="0" border="0" width="100%">
               	<tr>
                  	<td>&nbsp;</td>
                  </tr>
               	<tr>
							<td><INPUT TYPE=Button VALUE="<?php echo $text[5];?>" class=button onclick='go("index.php<?php echo $li."&page=$_GET[page]"; ?>")' style="margin:0px;"> <INPUT TYPE="Submit" VALUE="<?php echo $item[94]; ?>" class="button" name="submit"></td>
						</tr>
               </table>
					</form>
					
				</td>
			</tr>
		</table>
	</body>
</html>


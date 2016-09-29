<?php
//ielâdçjam funkcijas
require_once("config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");

$ren=mysqli_query($result_db,"Select * from items where id='$name'");
$row=mysqli_fetch_array($ren);
mysqli_free_result($ren);

$picture = $row["picture"];
$current_picture = $picture;
$error = "";

if(isset($_POST["submit"]))
{
	$change_from=array("\"","\'","'","\n","\\");
	$change_to=array("&quot;","","","<br />","");
	
	$change_from1=array("\\r","\\n","\\","'");
	$change_to1=array("","","","&lsquo;");
	
	$name_lv = trim(str_replace($change_from,$change_to,$_POST["name_lv"]));
	$name_ru = trim(str_replace($change_from,$change_to,$_POST["name_ru"]));
	$name_en = trim(str_replace($change_from,$change_to,$_POST["name_en"]));
	$name_ee = trim(str_replace($change_from,$change_to,$_POST["name_ee"]));
	$name_lt = trim(str_replace($change_from,$change_to,$_POST["name_lt"]));
	
	$title_lv = trim(str_replace($change_from,$change_to,$_POST["title_lv"]));
	$title_ru = trim(str_replace($change_from,$change_to,$_POST["title_ru"]));
	$title_en = trim(str_replace($change_from,$change_to,$_POST["title_en"]));
	$title_ee = trim(str_replace($change_from,$change_to,$_POST["title_ee"]));
	$title_lt = trim(str_replace($change_from,$change_to,$_POST["title_lt"]));
	
	$description_lv = trim(str_replace($change_from,$change_to,$_POST["description_lv"]));
	$description_ru = trim(str_replace($change_from,$change_to,$_POST["description_ru"]));
	$description_en = trim(str_replace($change_from,$change_to,$_POST["description_en"]));
	$description_ee = trim(str_replace($change_from,$change_to,$_POST["description_ee"]));
	$description_lt = trim(str_replace($change_from,$change_to,$_POST["description_lt"]));
	
	$keywords_lv = trim(str_replace($change_from,$change_to,$_POST["keywords_lv"]));
	$keywords_ru = trim(str_replace($change_from,$change_to,$_POST["keywords_ru"]));
	$keywords_en = trim(str_replace($change_from,$change_to,$_POST["keywords_en"]));
	$keywords_ee = trim(str_replace($change_from,$change_to,$_POST["keywords_ee"]));
	$keywords_lt = trim(str_replace($change_from,$change_to,$_POST["keywords_lt"]));
	
	$url_lv = trim(str_replace($change_from,$change_to,$_POST["url_lv"]));
	$url_ru = trim(str_replace($change_from,$change_to,$_POST["url_ru"]));
	$url_en = trim(str_replace($change_from,$change_to,$_POST["url_en"]));
	$url_ee = trim(str_replace($change_from,$change_to,$_POST["url_ee"]));
	$url_lt = trim(str_replace($change_from,$change_to,$_POST["url_lt"]));
	
	$text_lv = mysqli_real_escape_string($result_db, trim(preg_replace('#<\?xml[^(/>)]*/>#m','',$_POST["text_lv"])));
	$text_ru = mysqli_real_escape_string($result_db, trim(preg_replace('#<\?xml[^(/>)]*/>#m','',$_POST["text_ru"])));
	$text_en = mysqli_real_escape_string($result_db, trim(preg_replace('#<\?xml[^(/>)]*/>#m','',$_POST["text_en"])));
	$text_ee = mysqli_real_escape_string($result_db, trim(preg_replace('#<\?xml[^(/>)]*/>#m','',$_POST["text_ee"])));
	$text_lt = mysqli_real_escape_string($result_db, trim(preg_replace('#<\?xml[^(/>)]*/>#m','',$_POST["text_lt"])));
	
	$text_lv = str_replace($change_from1,$change_to1,$text_lv);
	$text_ru = str_replace($change_from1,$change_to1,$text_ru);
	$text_en = str_replace($change_from1,$change_to1,$text_en);
	$text_ee = str_replace($change_from1,$change_to1,$text_ee);
	$text_lt = str_replace($change_from1,$change_to1,$text_lt);
		
	$code=trim(str_replace($change_from,$change_to,$_POST["code"]));
	$person=trim(str_replace($change_from,$change_to,$_POST["person"]));
	
	$price=trim(str_replace($change_from,$change_to,$_POST["price"]));
	$price = str_replace(",",".",$price);
	$discount_price=trim(str_replace($change_from,$change_to,$_POST["discount_price"]));
	$discount_percent=trim(str_replace($change_from,$change_to,$_POST["discount_percent"]));
	
	$buy=trim(str_replace($change_from,$change_to,$_POST["buy"]));
	
	$rate=trim(str_replace($change_from,$change_to,$_POST["rate"]));
	
	
	if(isset($_POST["discount"]))
	{
		$discount = 2;
	}
	else
	{
		$discount = 1;
	}
	
	
	if(isset($_POST["new"]))
	{
		$new = 2;
	}
	else
	{
		$new = 1;
	}
	
	$items="";$ite=array();
	if(isset($_POST["items"]))
	{
		foreach($_POST["items"] as $key => $value)
		{
			$items=$items."*".$value."*";
			$ite[$value]=$value;
		}
	}
	
	$items="";$ite=array();
	if(isset($_POST["items"]))
	{
		foreach($_POST["items"] as $key => $value)
		{
			$items=$items."*".$value."*";
			$ite[$value]=$value;
		}
	}
	
	$specs="";$specialities=array();
	if(isset($_POST["specialities"]))
	{
		foreach($_POST["specialities"] as $key => $value)
		{
			$specs=$specs."*".$value."*";
			$specialities[$value]=$value;
		}
	}
	
	$branch="";$branches=array();
	if(isset($_POST["branches"]))
	{
		foreach($_POST["branches"] as $key => $value)
		{
			$branch=$branch."*".$value."*";
			$branches[$value]=$value;
		}
	}
	
	$laiks=time();		
	
	if (!empty($_FILES["picture"]["name"]))
	{
		$file = trim(str_replace("/","-",$url_lv));
		$name_file = $file.".jpg";
		if($picture != $name_file)
		{
			if(file_exists("../../pictures/items/small/$name_file"))
			{
				$name_file = $file."-".time().".jpg";			
			}
		}
		
		$picture = $name_file;
		
		$filename=$_FILES["picture"]["tmp_name"];
		$source = $filename;
		
		$size = getimagesize($source);
		$w = $size[0];
		$h = $size[1];		
		$stype = $size[2];	
				
		switch($stype)
		{
			case 1:
			$simg = imagecreatefromgif($source);
			break;
			
			case 2:
			$simg = imagecreatefromjpeg($source);
			break;
			
			case 3:
			$simg = imagecreatefrompng($source);
			break;
		}
		
				
		 
		
		$nw = 170;
		$nh = 170;		
		$dest = "../../pictures/items/small/$name_file";		
		 
		if($w >= $nw)
		{
			$newwidth = $nw;
			$percent = $newwidth/$w;
			$newheight = round($h * $percent);
					
			if($newheight>$nh)
			{
				$newheight = $nh;
				$percent = $newheight/$h;
				$newwidth = round($w * $percent);			
			}
		}
		else
		{
			$newwidth = $w;
			$percent = $newwidth/$w;
			$newheight = round($h * $percent);
					
			if($newheight>$nh)
			{
				$newheight = $nh;
				$percent = $newheight/$h;
				$newwidth = round($w * $percent);			
			}
		}
				
		$dimg = imagecreatetruecolor($newwidth, $newheight);
		$white = imagecolorallocate($dimg, 255, 255, 255);
		imagefilledrectangle($dimg, 0, 0, $newheight, $newheight, $white);
		imagecopyresampled ($dimg, $simg, 0, 0, 0, 0, $newwidth, $newheight, $w, $h);	 
		imagejpeg($dimg,$dest,90);
		chmod($dest, 0777); 
		
		
		$nw = 480;
		$nh = 320;		
		$dest = "../../pictures/items/big/$name_file";
		$dimg = imagecreatetruecolor($nw, $nh);
		 
		if($w >= $nw)
		{
			$newwidth = $nw;
			$percent = $newwidth/$w;
			$newheight = round($h * $percent);
					
			if($newheight>$nh)
			{
				$newheight = $nh;
				$percent = $newheight/$h;
				$newwidth = round($w * $percent);			
			}
		}
		else
		{
			$newwidth = $w;
			$percent = $newwidth/$w;
			$newheight = round($h * $percent);
					
			if($newheight>$nh)
			{
				$newheight = $nh;
				$percent = $newheight/$h;
				$newwidth = round($w * $percent);			
			}
		}
		
		$dimg = imagecreatetruecolor($newwidth, $newheight);
		$white = imagecolorallocate($dimg, 255, 255, 255);
		imagefilledrectangle($dimg, 0, 0, $newheight, $newheight, $white);
		imagecopyresampled ($dimg, $simg, 0, 0, 0, 0, $newwidth, $newheight, $w, $h);	 
		imagejpeg($dimg,$dest,90);
		chmod($dest, 0777); 		
	}
	else
	{
		if(!empty($picture))
		{
			$file = trim(str_replace("/","-",$url_lv));
			$name_file = $file.".jpg";
			if($picture != $name_file)
			{
				if(file_exists("../../pictures/items/small/$name_file"))
				{
					$name_file = $file."-".time().".jpg";			
				}
			}
			
			$picture = $name_file;		
			$old_file = $current_picture;	
				
			$old_dest = "../../pictures/items/big/$old_file";
			$new_dest = "../../pictures/items/big/$picture";						
			rename($old_dest,$new_dest);
			chmod($new_dest, 0777);
			
			$old_dest = "../../pictures/items/small/$old_file";
			$new_dest = "../../pictures/items/small/$picture";						
			rename($old_dest,$new_dest);
			chmod($new_dest, 0777);		
		}
	}
			
	$rakstam=mysqli_query($result_db,"update items set 
	
	title_lv = '$title_lv',
	title_ru = '$title_ru',
	title_en  = '$title_en',
	title_ee  = '$title_ee',
	title_lt  = '$title_lt',
	
	description_lv = '$description_lv',
	description_ru = '$description_ru',
	description_en = '$description_en',
	description_ee = '$description_ee',
	description_lt = '$description_lt',
	
	keywords_lv = '$keywords_lv',
	keywords_ru = '$keywords_ru',
	keywords_en = '$keywords_en',
	keywords_ee = '$keywords_ee',
	keywords_lt = '$keywords_lt',
	
	url_lv = '$url_lv',
	url_ru = '$url_ru',
	url_en = '$url_en',
	url_ee = '$url_ee',
	url_lt = '$url_lt',
	
	name_lv = '$name_lv',
	name_ru = '$name_ru',
	name_en = '$name_en',
	name_ee = '$name_ee',
	name_lt = '$name_lt',
	
	text_lv = '$text_lv',
	text_ru = '$text_ru',
	text_en = '$text_en',
	text_ee = '$text_ee',
	text_lt = '$text_lt',
			
	code = '$code',

	price = '$price',
	discount_price = '$discount_price',
	discount = '$discount',
	picture = '$picture',
	new ='$new',
	items = '$items',
	person = $person,
	speciality = '$specs',
	branch = '$branch',
	rate = '$rate',
	discount_percent = '$discount_percent',
	buy = '$buy'
		
	where id='$name'");
		
	$all_current_items = array();
	$te = mysqli_query($result_db,"select * from branches_items where item_id = '$name'");
	while($tes = mysqli_fetch_array($te))
	{
		$br_id = $tes["branche_id"];
		$all_current_items[$br_id] = $br_id;
		#echo "$all_current_items[$br_id]<br />";
	}
	
	$br = explode("*",$branch);
	for($i = 0; $i < count($br); $i++)
	{
	    $branch = str_replace("*","",$br[$i]);
	    if(!empty($branch))
	    {
	    	$te = mysqli_query($result_db,"select * from branches_items where item_id = '$name' and branche_id = '$branch'");
	    	if($tes = mysqli_fetch_array($te))
	    	{
	    	
	    	}
	    	else
	    	{
	    		$pl = mysqli_query($result_db,"select * from branches_items where branche_id = '$branch' order by place desc limit 0,1");
	    		if($pla = mysqli_fetch_array($pl))
	    		{
	    			$place = $pla["place"] + 1;
	    		}
	    		else
	    		{
	    			$place = 1;
	    		}
	    		$result = mysqli_query($result_db,"insert into branches_items values ('','$branch','$name','$place','$group_type','$id')");
	    		
	    	}
	    	unset($all_current_items[$branch]);
	    }
	}
	
	foreach($all_current_items as $key => $value)
	{
		$result = mysqli_query($result_db,"delete from branches_items where item_id = '$name' and branche_id = '$all_current_items[$key]'");
	}
	
	
	#Sakopējam informāciju saistītajās precēs
	$query = mysqli_query($result_db,"select id, picture from items where `copy` = '$name'");
	while($mysql = mysqli_fetch_array($query))
	{
		$url_lv_n = str_replace('-'.$name,'',$url_lv);
		$url_ru_n = str_replace('-'.$name,'',$url_ru);
		$url_en_n = str_replace('-'.$name,'',$url_en);
		$url_ee_n = str_replace('-'.$name,'',$url_ee);
		$url_lt_n = str_replace('-'.$name,'',$url_lt);
		
		$url_lv_n = $url_lv.'-'.$mysql['id'];
		$url_ru_n = $url_ru.'-'.$mysql['id'];
		$url_en_n = $url_en.'-'.$mysql['id'];
		$url_ee_n = $url_ee.'-'.$mysql['id'];
		$url_lt_n = $url_lt.'-'.$mysql['id'];
		
		if (!empty($picture))
		{
			$file = trim(str_replace("/","-",$url_lv_n));
			$picture_n = $file.".jpg";
			
			if(file_exists("../../pictures/items/small/$mysql[picture]"))
			{
				unlink("../../pictures/items/small/$mysql[picture]");
				unlink("../../pictures/items/big/$mysql[picture]");	
			}

			copy("../../pictures/items/small/$picture","../../pictures/items/small/$picture_n");			
			copy("../../pictures/items/big/$picture","../../pictures/items/big/$picture_n");						
		}
		else
		{
			$picture_n = "";
		}
		
		
		$rakstam=mysqli_query($result_db,"update items set 
			
		title_lv = '$title_lv',
		title_ru = '$title_ru',
		title_en  = '$title_en',
		title_ee  = '$title_ee',
		title_lt  = '$title_lt',
		
		description_lv = '$description_lv',
		description_ru = '$description_ru',
		description_en = '$description_en',
		description_ee = '$description_ee',
		description_lt = '$description_lt',
		
		keywords_lv = '$keywords_lv',
		keywords_ru = '$keywords_ru',
		keywords_en = '$keywords_en',
		keywords_ee = '$keywords_ee',
		keywords_lt = '$keywords_lt',
		
		url_lv = '$url_lv_n',
		url_ru = '$url_ru_n',
		url_en = '$url_en_n',
		url_ee = '$url_ee_n',
		url_lt = '$url_lt_n',
		
		name_lv = '$name_lv',
		name_ru = '$name_ru',
		name_en = '$name_en',
		name_ee = '$name_ee',
		name_lt = '$name_lt',
		
		text_lv = '$text_lv',
		text_ru = '$text_ru',
		text_en = '$text_en',
		text_ee = '$text_ee',
		text_lt = '$text_lt',
		    	
		code = '$code',
		
		picture = '$picture_n',
		price = '$price',
		discount_price = '$discount_price',
		discount = '$discount',
		new ='$new',
		items = '$items',
		person = $person,
		speciality = '$specs',
		branch = '$branch',
		rate = '$rate',
		discount_percent = '$discount_percent',
		buy = '$buy'
		    
		where id='$mysql[id]'");
		
		$result = mysqli_query($result_db,"delete from branches_items where item_id = '$mysql[id]'");
		
		$query1 = mysqli_query($result_db,"select * from branches_items where item_id = '$name'");
		while($mysql1 = mysqli_fetch_array($query1))
		{
			$result = mysqli_query($result_db,"insert into branches_items (`branche_id`,`item_id`,`place`,`group_type`,`category_id`) values ('$mysql1[branche_id]','$mysql[id]','$mysql1[place]','$mysql1[group_type]','$mysql1[category_id]')");
		}
	}
	
	$links = "index.php".$li."&page=$_GET[page]";
	header("Location: $links");
	exit;
	
}
else
{
	$ren=mysqli_query($result_db,"Select * from items where id='$name'");
	$row=mysqli_fetch_array($ren);
	
	$name_lv=$row["name_lv"];
	$name_ru=$row["name_ru"];
	$name_en=$row["name_en"];
	$name_ee=$row["name_ee"];
	$name_lt=$row["name_lt"];	
	
	$text_lv=$row["text_lv"];
	$text_ru=$row["text_ru"];
	$text_en=$row["text_en"];
	$text_ee=$row["text_ee"];
	$text_lt=$row["text_lt"];
	
	$title_lv=$row["title_lv"];
	$title_ru=$row["title_ru"];
	$title_en=$row["title_en"];
	$title_ee=$row["title_ee"];
	$title_lt=$row["title_lt"];
	
	$description_lv=$row["description_lv"];
	$description_ru=$row["description_ru"];
	$description_en=$row["description_en"];
	$description_ee=$row["description_ee"];
	$description_lt=$row["description_lt"];
	
	$keywords_lv=$row["keywords_lv"];
	$keywords_ru=$row["keywords_ru"];
	$keywords_en=$row["keywords_en"];
	$keywords_ee=$row["keywords_ee"];
	$keywords_lt=$row["keywords_lt"];
	
	$url_lv=$row["url_lv"];
	$url_ru=$row["url_ru"];
	$url_en=$row["url_en"];
	$url_ee=$row["url_ee"];
	$url_lt=$row["url_lt"];	
	
	$code=$row["code"];
	$price=$row["price"];
	$discount_price = $row["discount_price"];
	$discount_percent = $row["discount_percent"];
	$discount = $row["discount"];
		
	$picture=$row["picture"];
	$new = $row["new"];
	
	$items = explode("*",$row["items"]);
	$ite=array();
	$c=count($items);
	
	for($v=0;$v<$c;$v++)
	{	
		$k = $items[$v];
		$ite[$k] = $k;
	}
	
	$specs = explode("*",$row["speciality"]);
	$specialities=array();
	$c=count($specs);
	
	for($v=0;$v<$c;$v++)
	{	
		$k = $specs[$v];
		$specialities[$k] = $k;
	}
	
	$branch = explode("*",$row["branch"]);
	$branches=array();
	$c=count($branch);
	
	for($v=0;$v<$c;$v++)
	{	
		$k = $branch[$v];
		$branches[$k] = $k;
	}
	
	$person = $row["person"];
	$rate = $row["rate"];
	$buy = $row["buy"];
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
			
			function change (target)
			{	
				var element = document.getElementById(target);
						
				<?php
				
					$row1=mysqli_query($result_db,"Select * from $tabula where id='$id'");
					$fer1=mysqli_fetch_array($row1);
					mysqli_free_result($row1);
				?>
					
				
				if(target == "name_lv")
			  	{
					var url_text = "<?php echo $fer1["url_lv"]."/"; ?>" + element.value;
					var title_text  = element.value + "<?php echo " | ".str_replace("\"","",$fer1["name_lv"])." | $e[4]"; ?>";
					var description_text  = element.value + "<?php echo ". ".str_replace("\"","",$fer1["name_lv"]).". $e[5]"; ?>";
					var keywords_text  = element.value + "<?php echo ", ".str_replace("\"","",$fer1["name_lv"]); ?>";
					
				}
				
				if(target == "name_ru")
				{
					var url_text = "<?php echo $fer1["url_ru"]."/"; ?>" + element.value;
					var title_text  = element.value + "<?php echo " | ".str_replace("\"","",$fer1["name_ru"])." | $e[4]"; ?>";
					var description_text  = element.value + "<?php echo ". ".str_replace("\"","",$fer1["name_ru"]).". $e[5]"; ?>";
					var keywords_text  = element.value + "<?php echo ", ".str_replace("\"","",$fer1["name_ru"]); ?>";
				}
				
				if(target == "name_en")
				{
					var url_text = "<?php echo $fer1["url_en"]."/"; ?>" + element.value;
					var title_text  = element.value + "<?php echo " | ".str_replace("\"","",$fer1["name_en"])." | $e[4]"; ?>";
					var description_text  = element.value + "<?php echo ". ".str_replace("\"","",$fer1["name_en"]).". $e[5]"; ?>";
					var keywords_text  = element.value + "<?php echo ", ".str_replace("\"","",$fer1["name_en"]); ?>";
				}
				
				if(target == "name_ee")
				{
					var url_text = "<?php echo $fer1["url_ee"]."/"; ?>" + element.value;
					var title_text  = element.value + "<?php echo " | ".str_replace("\"","",$fer1["name_ee"])." | $e[4]"; ?>";
					var description_text  = element.value + "<?php echo ". ".str_replace("\"","",$fer1["name_ee"]).". $e[5]"; ?>";
					var keywords_text  = element.value + "<?php echo ", ".str_replace("\"","",$fer1["name_ee"]); ?>";
				}
				
				if(target == "name_lt")
				{
					var url_text = "<?php echo $fer1["url_lt"]."/"; ?>" + element.value;
					var title_text  = element.value + "<?php echo " | ".str_replace("\"","",$fer1["name_lt"])." | $e[4]"; ?>";
					var description_text  = element.value + "<?php echo ". ".str_replace("\"","",$fer1["name_lt"]).". $e[5]"; ?>";
					var keywords_text  = element.value + "<?php echo ", ".str_replace("\"","",$fer1["name_lt"]); ?>";
				}
				
				
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
      <script type="text/javascript" src="../tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
		<script type="text/javascript" src="../tinymce/jscripts/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>
		<script type="text/javascript">
		tinyMCE.init({
		        // General options
		       mode : "exact",
				theme : "advanced",
				elements : "text_lv, text_ru, text_en, text_lt, text_ee",
				file_browser_callback : "tinyBrowser",
				content_css : '../editor_style.css',    
   				relative_urls : false, 
        		remove_script_host : false,
		        theme_advanced_blockformats : 'partners-border',
				theme_advanced_styles : "<?php echo $teksti[153]; ?>=partners-border",
				entity_encoding : "raw",
		        plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
		        
		
		        // Theme options
		        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",	        theme_advanced_toolbar_location : "top",
						        theme_advanced_toolbar_align : "left",
		        theme_advanced_statusbar_location : "bottom",
		        theme_advanced_resizing : true,

		
		        // Skin options
		        skin : "o2k7",
		        skin_variant : "silver",
		
		        // Example content CSS (should be your site CSS)
		        content_css : "../editor_style.css",
		
		        // Drop lists for link/image/media/template dialogs
		        template_external_list_url : "tinymce/js/template_list.js",
		        external_link_list_url : "tinymce/js/link_list.js",
		        external_image_list_url : "tinymce/js/image_list.js",
		        media_external_list_url : "tinymce/js/media_list.js",
		
		        // Replace values for the template plugin
		        template_replace_values : {
		            username : "<?php echo $_SESSION['valid_user']; ?>",
					staffid : "<?php echo $sess_id; ?>"
		        }
		});
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
		 					<td height="30" valign="top" class="sad"><a href="index.php<?php echo $li; ?>" class="sad_link"><?php echo $item[0]; ?></a></td>
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
               
               		<form action="p_mainit.php<?php echo $li."&name=$name&page=$_GET[page]"; ?>" method="post" name="jaunumi" enctype="multipart/form-data" style="margin:0px;">
               
					<table cellpadding="5" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd; border-top:none; border-bottom:none;" id="lv-content">
               			<tr>
                     		<td class="standart" bgcolor="#f2f3f7" colspan="8"><b><?php echo $item[1]; ?></b></td>
                  		</tr>						
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[2]; ?></b></td>
							<td valign="middle"><input type="text" name="name_lv" class="input" style="width: 270px" onKeyUp="change('name_lv')" id="name_lv" value="<?php echo $name_lv; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[3]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="title_lv" value="<?php echo $title_lv; ?>" style="width: 270px"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[4]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="description_lv" style="width:400px" value="<?php echo $description_lv; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[5]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="keywords_lv" style="width: 270px" value="<?php echo $keywords_lv; ?>"></td>
						</tr>
                  		<tr>
							<td valign="top" align="right" class="standart" width="200"><b><?php echo $item[6]; ?></b></td>
							<td valign="middle"><input type="text" name="url_lv" class="input" style="width: 270px" value="<?php echo $url_lv; ?>"><br /><span class="mazais" style="color:#999999;"><i><?php echo $item[7]; ?></i></span></td>
						</tr>
                  		<tr>
							<td valign="top" align="right" class="standart" width="200"><b><?php echo $item[8]; ?></b></td>
							<td valign="middle"><textarea name="text_lv" style="width:300px; height:250px;"><?php echo $text_lv; ?></textarea></td>
						</tr>
					</table>
               
               		<table cellpadding="5" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd; border-top:none; border-bottom:none;" id="ru-content">
               			<tr>
                     		<td class="standart" bgcolor="#f2f3f7" colspan="8"><b><?php echo $item[1]; ?></b></td>
                  		</tr>						
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[2]; ?></b></td>
							<td valign="middle"><input type="text" name="name_ru" class="input" style="width: 270px" onKeyUp="change('name_ru')" id="name_ru" value="<?php echo $name_ru; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[3]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="title_ru" value="<?php echo $title_ru; ?>" style="width: 270px"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[4]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="description_ru" style="width:400px" value="<?php echo $description_ru; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[5]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="keywords_ru" style="width: 270px" value="<?php echo $keywords_ru; ?>"></td>
						</tr>
                  		<tr>
							<td valign="top" align="right" class="standart" width="200"><b><?php echo $item[6]; ?></b></td>
							<td valign="middle"><input type="text" name="url_ru" class="input" style="width: 270px" value="<?php echo $url_ru; ?>"><br /><span class="mazais" style="color:#999999;"><i><?php echo $item[7]; ?></i></span></td>
						</tr>
                  		<tr>
							<td valign="top" align="right" class="standart" width="200"><b><?php echo $item[8]; ?></b></td>
							<td valign="middle"><textarea name="text_ru" style="width:300px; height:250px;"><?php echo $text_ru; ?></textarea></td>
						</tr>
					</table>
               
               		<table cellpadding="5" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd; border-top:none; border-bottom:none;" id="en-content">
               			<tr>
                    		<td class="standart" bgcolor="#f2f3f7" colspan="8"><b><?php echo $item[1]; ?></b></td>
                  		</tr>						
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[2]; ?></b></td>
							<td valign="middle"><input type="text" name="name_en" class="input" style="width: 270px" onKeyUp="change('name_en')" id="name_en" value="<?php echo $name_en; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[3]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="title_en" value="<?php echo $title_en; ?>" style="width: 270px"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[4]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="description_en" style="width:400px" value="<?php echo $description_en; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[5]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="keywords_en" style="width: 270px" value="<?php echo $keywords_en; ?>"></td>
						</tr>
                  		<tr>
							<td valign="top" align="right" class="standart" width="200"><b><?php echo $item[6]; ?></b></td>
							<td valign="middle"><input type="text" name="url_en" class="input" style="width: 270px" value="<?php echo $url_en; ?>"><br /><span class="mazais" style="color:#999999;"><i><?php echo $item[7]; ?></i></span></td>
						</tr>
                  		<tr>
							<td valign="top" align="right" class="standart" width="200"><b><?php echo $item[8]; ?></b></td>
							<td valign="middle"><textarea name="text_en" style="width:300px; height:250px;"><?php echo $text_en; ?></textarea></td>
						</tr>                 
					</table>
					
					<table cellpadding="5" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd; border-top:none; border-bottom:none;" id="ee-content">
               			<tr>
                    		<td class="standart" bgcolor="#f2f3f7" colspan="8"><b><?php echo $item[1]; ?></b></td>
                  		</tr>						
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[2]; ?></b></td>
							<td valign="middle"><input type="text" name="name_ee" class="input" style="width: 270px" onKeyUp="change('name_ee')" id="name_ee" value="<?php echo $name_ee; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[3]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="title_ee" value="<?php echo $title_ee; ?>" style="width: 270px"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[4]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="description_ee" style="width:400px" value="<?php echo $description_ee; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[5]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="keywords_ee" style="width: 270px" value="<?php echo $keywords_ee; ?>"></td>
						</tr>
                  		<tr>
							<td valign="top" align="right" class="standart" width="200"><b><?php echo $item[6]; ?></b></td>
							<td valign="middle"><input type="text" name="url_ee" class="input" style="width: 270px" value="<?php echo $url_ee; ?>"><br /><span class="mazais" style="color:#999999;"><i><?php echo $item[7]; ?></i></span></td>
						</tr>
                  		<tr>
							<td valign="top" align="right" class="standart" width="200"><b><?php echo $item[8]; ?></b></td>
							<td valign="middle"><textarea name="text_ee" style="width:300px; height:250px;"><?php echo $text_ee; ?></textarea></td>
						</tr>                 
					</table>
					
					<table cellpadding="5" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd; border-top:none; border-bottom:none;" id="lt-content">
               			<tr>
                    		<td class="standart" bgcolor="#f2f3f7" colspan="8"><b><?php echo $item[1]; ?></b></td>
                  		</tr>						
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[2]; ?></b></td>
							<td valign="middle"><input type="text" name="name_lt" class="input" style="width: 270px" onKeyUp="change('name_lt')" id="name_lt" value="<?php echo $name_lt; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[3]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="title_lt" value="<?php echo $title_lt; ?>" style="width: 270px"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[4]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="description_lt" style="width:400px" value="<?php echo $description_lt; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[5]; ?></b></td>
							<td valign="middle"><input type="text" class="input" name="keywords_lt" style="width: 270px" value="<?php echo $keywords_lt; ?>"></td>
						</tr>
                  		<tr>
							<td valign="top" align="right" class="standart" width="200"><b><?php echo $item[6]; ?></b></td>
							<td valign="middle"><input type="text" name="url_lt" class="input" style="width: 270px" value="<?php echo $url_lt; ?>"><br /><span class="mazais" style="color:#999999;"><i><?php echo $item[7]; ?></i></span></td>
						</tr>
                  		<tr>
							<td valign="top" align="right" class="standart" width="200"><b><?php echo $item[8]; ?></b></td>
							<td valign="middle"><textarea name="text_lt" style="width:300px; height:250px;"><?php echo $text_lt; ?></textarea></td>
						</tr>                 
					</table>
               
               
               		<table cellpadding="5" cellspacing="0" border="0" width="100%" style="border: 1px solid #d0d2dd; border-top:none;" >  
               			<tr>
                     		<td class="standart" bgcolor="#f2f3f7" colspan="8"><b><?php echo $item[66]; ?></b></td>
                  		</tr>	           	
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[14]; ?></b></td>
							<td valign="middle"><input type="text" name="code" class="input" style="width: 270px" value="<?php echo $code; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[17]; ?></b></td>
							<td valign="middle"><input type="text" name="price" class="input" style="width: 50px" value="<?php echo $price; ?>"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart"><b><?php echo $item[87]; ?></b></td>
							<td valign="middle">
							<select class="input" name="rate">
                     			<option value="0" <?php if($rate == 0){echo " selected";} ?>></option>
								<?php 
								$rep=mysqli_query($result_db,"Select * from rates order by name asc");
								$a=0;
								while($rop=mysqli_fetch_array($rep))
								{
									$k = $rop["id"];
									echo "<option value=\"$rop[id]\""; if($rate == $k){echo " selected";} echo ">$rop[name]%</option>";
									$a++;
								}
								mysqli_free_result($rep);
							?>
							</select>
							</td>
						</tr>
                  		<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[67]; ?></b></td>
							<td valign="middle"><input type="checkbox" name="new" <?php if($new == 2) {echo "checked";} ?>></td>
						</tr>	
                  			
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[88]; ?></b></td>
							<td valign="middle" class="standart">
								<input type="radio" name="buy" value="1" <?php if($buy == 1) {echo "checked";} ?>> <?php echo $item[89]; ?>&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" name="buy" value="2" <?php if($buy == 2) {echo "checked";} ?>> <?php echo $item[90]; ?>&nbsp;&nbsp;&nbsp;&nbsp;
							</td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[25]; ?></b></td>
							<td valign="middle"><input type="checkbox" name="discount" <?php if($discount == 2) {echo "checked";} ?>></td>
						</tr>
                  		<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[18]; ?></b></td>
							<td valign="middle" class="standart">
								<input type="text" name="discount_price" class="input" style="width: 50px" value="<?php echo $discount_price; ?>"> <?php echo $e[13]; ?> &nbsp;&nbsp;&nbsp;&nbsp;
								<input type="text" name="discount_percent" class="input" style="width: 50px" value="<?php echo $discount_percent; ?>"> %
							</td>
						</tr>
                  		<?php
						if(!empty($picture))
						{
						?>
                  		<tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[26]; ?></b></td>
							<td valign="middle"><img src="../../pictures/items/small/<?php echo $picture; ?>?v=<?php echo time(); ?>" style="border: 1px solid #d0d2dd;"></td>
						</tr>
                  		<?php
						}
						?>		
                        <tr>
							<td valign="middle" align="right" class="standart" width="200"><b><?php echo $item[26]; ?></b></td>
							<td valign="middle"><input type="file" name="picture" class="input"></td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart"><b><?php echo $pr[118]; ?></b></td>
							<td valign="middle">
							<select class="input" name="specialities[]" multiple="multiple" size="20" style="width: 500px">
                     			<option value="0" <?php if($person == 0){echo " selected";} ?>></option>
								<?php 
								$rep=mysqli_query($result_db,"Select * from specialities order by name_lv asc");
								$a=0;
								while($rop=mysqli_fetch_array($rep))
								{
									$c_id = $rop["id"];
									if(isset($specialities[$c_id]))
									{
										$se = " selected";
									}
									else
									{
										$se = "";
									}
									echo "<option value=\"$rop[id]\"$se>$rop[name_lv]</option>";
									$a++;
								}
								mysqli_free_result($rep);
							?>
							</select>
							</td>
						</tr>
						<tr>
							<td valign="middle" align="right" class="standart"><b><?php echo $pr[119]; ?></b></td>
							<td valign="middle">
							<select class="input" name="branches[]" multiple="multiple" size="20" style="width: 500px">
                     			<option value="0" <?php if($person == 0){echo " selected";} ?>></option>
								<?php 
								$rep=mysqli_query($result_db,"Select * from branches order by name_lv asc");
								$a=0;
								while($rop=mysqli_fetch_array($rep))
								{
									$c_id = $rop["id"];
									if(isset($branches[$c_id]))
									{
										$se = " selected";
									}
									else
									{
										$se = "";
									}
									echo "<option value=\"$rop[id]\"$se>$rop[name_lv]</option>";
									$a++;
								}
								mysqli_free_result($rep);
							?>
							</select>
							</td>
						</tr> 
						<tr>
							<td valign="middle" align="right" class="standart"><b><?php echo $brokers[62]; ?></b></td>
							<td valign="middle">
							<select class="input" name="person">
                     			<option value="0" <?php if($person == 0){echo " selected";} ?>></option>
								<?php 
								$rep=mysqli_query($result_db,"Select * from persons order by name_lv asc");
								$a=0;
								while($rop=mysqli_fetch_array($rep))
								{
									$k = $rop["id"];
									echo "<option value=\"$rop[id]\""; if($person == $k){echo " selected";} echo ">$rop[name_lv]</option>";
									$a++;
								}
								mysqli_free_result($rep);
							?>
							</select>
							</td>
						</tr>
						<tr>
                     		<td valign="middle" align="right" class="standart"><b><?php echo $item[62]; ?></b></div></td>
                     		<td valign="middle">
                     			<select class="input" name="items[]" multiple size="20" style="width: 500px">
                     				<option value="0"></option>
                        			<?php
                     				$mysql = mysqli_query($result_db,"select * from items where id <> '$name' order by name_lv asc");
									while($cat = mysqli_fetch_array($mysql))
									{	
										$c_id = $cat["id"];
										if(isset($ite[$c_id]))
										{
											$se = " selected";
										}
										else
										{
											$se = "";
										}
										echo "<option value=\"$cat[id]\"$se>$cat[name_lv]</option>\n";				
									}
									mysqli_free_result($mysql);
									?>
                     			</select>
                     		</td>
                  		</tr>        
					</table>
               		<table cellpadding="0" cellspacing="0" border="0"> 
              			<tr>
                  			<td valign="middle" height="30"><INPUT TYPE=Button VALUE="<?php echo $text[5];?>" class=button onclick='go("index.php<?php echo $li."&limit=$limit"; ?>")' style="margin:0px;"> <input type="submit" name="submit" class="button" value="<?php echo $item[28]; ?>"></td>
						</tr>						
					</table>
					</form>
					
				</td>
			</tr>
		</table>
	</body>
</html>


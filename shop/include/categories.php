<?php 
$indent=20;
$limenis=array();

global $result_db;


$row=mysqli_query($result_db,"Select * from categories where id='$catalog_id' and statuss = '2' and (type = 0 or type = '$_SESSION[t]') order by place asc");
$fe=mysqli_fetch_array($row);

if(!empty($fe))
{
	$limenis[]=$fe["id"];
	while($fe["parent_id"]!=$parent_category_id)
	{	
		if($fe["parent_id"]!=$parent_category_id)
		{
			$row=mysqli_query($result_db,"Select * from categories where id='$fe[parent_id]' and statuss = '2' and (type = 0 or type = '$_SESSION[t]') order by place asc");
			$fe=mysqli_fetch_array($row);
			$limenis[]=$fe["id"];
		}
	}		
}
else
{
	$limenis[]=0;
}
$cik=count($limenis);	
	
	
function izvelnes($parent_id,$atstarpe,$cik,$limenis,$ver,$root_dir)
{
	global $result_db;
	$cik--;
	$r1=mysqli_query($result_db,"Select * from categories where parent_id='$parent_id' and statuss='2' and (type = 0 or type = '$_SESSION[t]') order by place asc");
	while($f1=mysqli_fetch_array($r1))
	{
			
		$name_lang = "name_".$ver;
		$url_lang = "url_".$ver;
		$link_lang = "link_".$ver;
		$target_lang = "target_".$ver;
		
		$item_url = $ver."/".$f1[$url_lang];
		if(empty($f1[$url_lang]))
		{
			$item_url = $ver."/".$f1["url_lv"];
		}
		
		if($f1[$link_lang]==""){$linc=$root_dir.$item_url;}
  		else{$linc="$f1[$link_lang]";}
  		if($f1[$target_lang]==""){$tar="";}
  		else{$tar=" target=\"$f1[$target_lang]\"";}  
	
		$platums = 190 - $atstarpe;	
		
		$acl = '';
		if(!empty($limenis[$cik]))
		{
			if($f1["id"] == $limenis[$cik])
			{
				$acl = ' class="active"';
			}	
		}
		
		$izveleta1 = $f1[$name_lang];
		if(empty($f1[$name_lang]))
		{
			$izveleta1 = $f1["name_lv"];
		}
		
		
		
						
		echo "<li style=\"padding: 5px 0 0 ".$atstarpe."px;\"><a href=\"$linc\"$tar$acl>".$izveleta1."&nbsp;</a></li>";
		$indent = $atstarpe + 10;
			
			
		if(!empty($limenis[$cik]))
		{
			if($f1["id"] == $limenis[$cik])
			{
				global $choosen;
				$choosen .= "&nbsp;&gt;&nbsp;<a href=\"$linc\" title=\"$izveleta1\">$izveleta1</a>";
				izvelnes($f1["id"],$indent,$cik,$limenis,$ver,$root_dir);
			}
		}
	}
}
	
if(!empty($limenis[$cik]))
{
	if($limenis[$cik]==0)
	{
		$r=mysqli_query($result_db,"Select id from categories where parent_id='$parent_category_id' and statuss='2' and (type = 0 or type = '$_SESSION[t]') order by place asc limit 0,1");
		$f=mysqli_fetch_array($r);
		$ko=$f["id"];
	}
	else
	{
		$ko=$limenis[$cik];
	}
}

$r=mysqli_query($result_db,"Select * from categories where parent_id='$parent_category_id' and statuss='2' and (type = 0 or type = '$_SESSION[t]') order by place asc");
$cik--;

while($f=mysqli_fetch_array($r))
{
	$item_url = $_GET["lang"]."/".$f[$url_lang];
	if(empty($f[$url_lang]))
	{
		$item_url = $_GET["lang"]."/".$f["url_lv"];
	}
	
	if($f[$link_lang]==""){$linc=$root_dir.$item_url;}
   	else{$linc="$f[$link_lang]";}
   	if($f[$target_lang]==""){$tar="";}
   	else{$tar=" target=\"$f[$target_lang]\"";}  
	
	if($f["id"] == $limenis[$cik] && $search_on == 0)
	{
		if($f["style"] == 2)
		{
			$cl = " class=\"cat1d-on\"";
		}
		else
		{
			$cl = " class=\"cat1-on\"";
		}
	}
	else
	{
		if($f["style"] == 2)
		{
			$cl = " class=\"cat1d\"";
		}
		else
		{
			$cl = " class=\"cat1\"";
		}
	}
	
	$izveleta1 = $f[$name_lang];
	if(empty($f[$name_lang]))
	{
		$izveleta1 = $f["name_lv"];
	}
	
	
		
	if($f["style"] == 2)
	{
		echo '<li class="cat-dot">&nbsp;</li>';
	}
	echo "<li$cl><a href=\"$linc\" title=\"$izveleta1\">$izveleta1&nbsp;</a>";
	
	
	if($f["id"] == $limenis[$cik] && $search_on == 0)
	{
		
		$choosen .= "<a href=\"$linc\" title=\"$izveleta1\">$izveleta1</a>";
		$st = " ";
		echo "<ul>";
		izvelnes($f["id"],$indent,$cik,$limenis,$_GET["lang"],$root_dir);
		echo "</ul></li>\n";
	}	
	else
	{
		$st = " ";
	}	
}
?>
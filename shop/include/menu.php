<?php 
global $result_db;
$indent=20;
$limenis=array();

$row=mysqli_query($result_db,"Select * from $tabula where id='$id' and publish = 'on' and lang = '$_GET[lang]' order by place asc");
$fe=mysqli_fetch_array($row);
mysqli_free_result($row);

if(!empty($fe))
{
	$limenis[]=$fe["id"];
	while($fe["parent_id"]!=0)
	{	
		if($fe["parent_id"]!=0)
		{
			$row=mysqli_query($result_db,"Select * from $tabula where id='$fe[parent_id]' and publish = 'on' and lang = '$_GET[lang]' order by place asc");
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
	$r1=mysqli_query($result_db,"Select * from content where parent_id='$parent_id' and publish='on' and type <> '2' order by place asc");
	while($f1=mysqli_fetch_array($r1))
	{
			
			
		
		if($f1["link"]=="null"){$linc=$root_dir.$ver."/".$f1["url"];}
  		else{$linc="$f1[link]";}
  		if($f1["target"]=="null"){$tar="";}
  		else{$tar=" target=\"$f1[target]\"";}  
	
		$platums = 190 - $atstarpe;	
						
		echo "<li style=\"padding: 5px 0 0 ".$atstarpe."px;\"><a href=\"$linc\"$tar>".$f1["name"]."&nbsp;</a></li>";
		$indent = $atstarpe + 10;
			
		if(!empty($limenis[$cik]))
		{
			if($f1["id"] == $limenis[$cik])
			{
				global $choosen;
				$choosen .= "&nbsp;&gt;&nbsp;<a href=\"$linc\" title=\"$f1[name]\">$f1[name]</a>";
				izvelnes($f1["id"],$indent,$cik,$limenis,$ver,$root_dir);
			}
		}
	}
}
	
if(!empty($limenis[$cik]))
{
	if($limenis[$cik]==0)
	{
		$r=mysqli_query($result_db,"Select id from $tabula where parent_id='0' and publish='on' and lang = '$_GET[lang]' order by place asc limit 0,1");
		$f=mysqli_fetch_array($r);
		$ko=$f["id"];
	}
	else
	{
		$ko=$limenis[$cik];
	}
}

$cik--;
$r=mysqli_query($result_db,"Select * from $tabula where parent_id='$izv_id' and publish='on' and lang = '$_GET[lang]' and (type <> '2' or type <> '3') order by place asc");
$cik--;

while($f=mysqli_fetch_array($r))
{
	if($f["link"]=="null"){$linc=$root_dir.$_GET["lang"]."/".$f["url"];}
   	else{$linc="$f[link]";}
   	if($f["target"]=="null"){$tar="";}
   	else{$tar=" target=\"$f[target]\"";}  
	
	
	$cl = " class=\"mcat1\"";
	if($cik >= 0)
	{
		if($f["id"] == $limenis[$cik])
		{
			$cl = " class=\"mcat1-on\"";
		}
	}

	if(!empty($f["icon"]))
	{
		$icon = '<img src="'.$root_dir.'images/icons/'.$f["icon"].'" width="25" height="25" alt="'.$f["name"].'" />';
	}
	else
	{
		$icon = '';
	}
	
	echo "<li$cl><a href=\"$linc\" title=\"$f[name]\">$icon$f[name]&nbsp;</a>";
	
	$st = " ";
	if($cik >= 0)
	{
		if($f["id"] == $limenis[$cik])
		{
			$choosen .= "<a href=\"$linc\" title=\"$f[name]\">$f[name]</a>";
			$st = " ";
			echo "<ul>";
			izvelnes($f["id"],$indent,$cik,$limenis,$_GET["lang"],$root_dir);
			echo "</ul></li>\n";
		}		
	}
}
mysqli_free_result($r);

?>


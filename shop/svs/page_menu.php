<?php if($frkohgb!="ok"){header("Location: index.php");	exit;}?>
<table cellpadding="7" cellspacing="0" width="230">
	<tr>
		<td>
			<table cellpadding="2" cellspacing="1" border="0" width="216">			
<?php 
$indent=10;
$row=mysqli_query($result_db,"Select id,parent_id from $tabula where id='$id' and lang='$ver' order by place asc");
$fe=mysqli_fetch_array($row);
mysqli_free_result($row);
if(!empty($fe)){

$limenis=array();
$limenis[]=$fe["id"];
while($fe["parent_id"]!=0)
{	
	if($fe["parent_id"]!=0)
	{
		$row=mysqli_query($result_db,"Select id,parent_id from $tabula where id='$fe[parent_id]' and lang='$ver' order by place asc");
		$fe=mysqli_fetch_array($row);
		$limenis[]=$fe["id"];
	}
}

$cik=count($limenis);



function izvelnes($parent_id,$atstarpe,$cik,$limenis,$li1,$tabula,$wolf_path,$ver,$id)
{
	global $result_db;
	$cik--;
	$r1=mysqli_query($result_db,"Select link,id,target,name,parent_id from $tabula where parent_id='$parent_id' and lang='$ver' order by place asc");
	while($f1=mysqli_fetch_array($r1))
	{
		
		$linc=$wolf_path."member.php$li1&id=$f1[id]";
		$platums = 180 - $atstarpe;	
		
		
		$tcl1 = " class=\"menu2\"";
		
		if($f1["id"] == $id)
		{
			$b1 = "<b>"; $b2 = "</b>";
		}
		else
		{
			$b1 = "";$b2 = "";
		}

		
		echo "<div style=\"padding-left:$atstarpe;\">
					<div style=\"float:left;\"><img src=\"".$wolf_path."img/next.gif\" border=\"0\">&nbsp;</div>
					<div style=\"float:left; width:$platums"."px; padding-top:5px;\"><a href=\"$linc\" $tcl1>$b1".$f1["name"]."&nbsp;$b2</a></div>
				</div>
				<div style=\"clear:both;height:0px;\"><!-- ff --></div>\n";
		$indent = $atstarpe + 10;
		
		if(!empty($limenis[$cik])){
		if($f1["id"] == $limenis[$cik])
		{
			izvelnes($f1["id"],$indent,$cik,$limenis,$li1,$tabula,$wolf_path,$ver,$id);
		}
		}
	}
}

if(!empty($limenis[$cik])){
if($limenis[$cik]==0)
{
	$r=mysqli_query($result_db,"Select id from $tabula where parent_id='0' and lang='$ver' order by place asc limit 0,1");
	$f=mysqli_fetch_array($r);
	$ko=$f["id"];
}
else
{
	$ko=$limenis[$cik];
}
}
	$r=mysqli_query($result_db,"Select link,id,target,name,parent_id, type from $tabula where parent_id='0' and lang='$ver' order by place asc");
	$cik--;
	while($f=mysqli_fetch_array($r))
	{
	
		$linc=$wolf_path."member.php$li1&id=$f[id]";
		
		
		$bg = "";
		$tcl = " class=\"menu1\"";
		
		if($f["type"] == 2)
		{
			$bg = " bgcolor=\"#ffffff\"";
			$tcl = " class=\"menu3\"";
		}
		if($f["type"] == 3)
		{
			$bg = " bgcolor=\"#d0d2dd\"";
			$tcl = " class=\"menu1\"";
		}
		
		
		
		echo "<tr><td class=\"mm\"$bg><a href=\"$linc\" $tcl>$f[name]&nbsp;</a>\n";
		if($f["id"] == $limenis[$cik])
		{
			izvelnes($f["id"],$indent,$cik,$limenis,$li1,$tabula,$wolf_path,$ver,$id);
		}
		echo "</td></tr>\n";
	}
mysqli_free_result($r);
}
else{
echo "<tr><td>".$teksti[0]."</td></tr>";
}
?>
</table>
<?php 

if($us == "no" && $ar > 0 ){}
else{?>
<table cellpadding="0" cellspacing="0" border="0" align="center" height="30">
<tr><td align="center"><input type="Button" value="<?php echo $teksti[27]; ?>" class="button1" onclick='go("<?php echo $wolf_path; ?>sadalas/pievienot.php<?php echo $li; ?>")'></td></tr>
</table>
<?php 
}
?>
</td>
</tr>
</table>
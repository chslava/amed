<?php if($frkohgb!="ok"){header("Location: index.php");	exit;}?>
<table cellpadding="7" cellspacing="0" width="230">
	<tr>
		<td>
			<table cellpadding="2" cellspacing="1" border="0" width="216">			
<?php 
$indent="";
$row=mysqli_query($result_db,"Select id,parent_id from $tabula where id='$id' order by place asc");
$fe=mysqli_fetch_array($row);
mysqli_free_result($row);
if(!empty($fe)){

$limenis=array();
$limenis[]=$fe["id"];
while($fe["parent_id"]!=0)
{	
	if($fe["parent_id"]!=0)
	{
		$row=mysqli_query($result_db,"Select id,parent_id from $tabula where id='$fe[parent_id]' order by place asc");
		$fe=mysqli_fetch_array($row);
		$limenis[]=$fe["id"];
	}
}

$cik=count($limenis);

$nam = "name_".$ver;

function izvelnes($parent_id,$atstarpe,$cik,$limenis,$li1,$tabula,$wolf_path,$ver,$id)
{
	$nam = "name_".$ver;
	$cik--;
	$r1=mysqli_query($result_db,"Select * from $tabula where parent_id='$parent_id' order by place asc");
	while($f1=mysqli_fetch_array($r1))
	{
		
		$linc="index.php$li1&id=$f1[id]";
		
		
			$bg = " background:#d8dbe6";
			$tcl = " class=\"menu2\"";
		if($f1["id"] == $id)
		{
			$b1 = "<b>"; $b2 = "</b>";
		}
		else
		{
			$b1 = "";$b2 = "";
		}


		$platums = 180 - $atstarpe;	
		echo "<div style=\"padding-left:$atstarpe;$bg\">
					<div style=\"float:left;\"><img src=\"".$wolf_path."img/next.gif\" border=\"0\">&nbsp;</div>
					<div style=\"float:left; width:$platums"."px; padding-top:2px;\"><a href=\"$linc\"$tcl>$b1".$f1["name_lv"]."&nbsp;$b2</a></div>
				</div>
				<div style=\"clear:both;height:3px;\"><!-- ff --></div>\n";
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
	$r=mysqli_query($result_db,"Select * from $tabula where parent_id='0' order by place asc");
	$cik--;
	while($f=mysqli_fetch_array($r))
	{
	
		$linc="index.php$li1&id=$f[id]";
		
				
		echo "<tr><td class=\"mm11\"><a href=\"$linc\" class=\"menu11\">$f[$nam]</a>\n";
		if($f["id"] == $limenis[$cik])
		{
			izvelnes($f["id"],$indent,$cik,$limenis,$li1,$tabula,$wolf_path,$ver,$id);
		}
		echo "</td></tr>\n";
	}
mysqli_free_result($r);
}
else{
echo "<tr><td class=\"standart\">".$teksti[0]."</td></tr>";
}
?>
</table>
<?php 

if($us == "no" && $ar > 0 ){}
else{?>
<table cellpadding="0" cellspacing="0" border="0" align="center" height="30">
<tr><td align="center"><input type="Button" value="<?php echo $teksti[27]; ?>" class="button1" onclick='go("pievienot.php<?php echo $li; ?>")'></td></tr>
</table>
<?php 
}
?>
</td>
</tr>
</table>
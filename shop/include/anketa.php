<form name="anketa" action="#action" method="post" id="introduction">
<?php
	echo "<div>".$anket["before_text"]."</div>";
	echo "<a name=\"action\"></a>";
	if($check>0)
	{
		echo "<p><h3 class=\"red\">$e[32]</h3><p>";
	}
	if($correct>0)
	{
		echo "<p>$error</p>";
	}
	$o=0;$a=1;
	$lauki=mysql_query("Select * from anketas where parent_id='$anketa' order by place asc");
	$cik = mysql_num_rows($lauki);
	while($lauks=mysql_fetch_array($lauki))
	{			
		$value=$lauks["id"];
		$v_nos=str_replace($change_from,$change_to,$_POST[$value]); 
									
		if($lauks["field_type"]==1)
		{
			if($lauks["field_fill"]==2){$obligati=" <span class=\"star\">*</span>";$o++;}else{$obligati="";}
			if($lauks["field_width"]!="") {$wid = "style=\"width:$lauks[field_width]px;\"";}else{$wid = "";}
			echo "<p class=\"ou\"><label for=\"a$lauks[id]\">$lauks[field_name]</label><select name=\"$lauks[id]\">";
										
			$list=explode("\n",$lauks["field_value"]);
			for($i=0; $i<count($list);$i++)
			{
				if($v_nos == $i){$sel = "selected";}else{$sel="";}
				echo "<option value=\"$i\" $sel>$list[$i]</option>";
			}
			echo "</select>$obligati</p>";
		}
		if($lauks["field_type"]==2)
		{
			if($lauks["field_fill"]==2){$obligati=" <span class=\"star\">*</span>";$o++;}else{$obligati="";}
			if($v_nos == "on") { $ch = "checked";}else{ $ch = "";}
			echo "<p class=\"ou\"><input type=\"checkbox\" name=\"$lauks[id]\" id=\"$lauks[id]\" $ch /> $lauks[field_name]$obligati</p>";
		}
		if($lauks["field_type"]==3)
		{
			if($lauks["field_fill"]==2){$obligati=" <span class=\"star\">*</span>";$o++;}else{$obligati="";}
			if($lauks["field_width"]!="") {$wid = "style=\"width:$lauks[field_width]px;\"";}else{$wid = "";}
			if($lauks["field_length"]!="") {$le = "maxlength=\"$lauks[field_length]\"";}else{$le = "";}
			echo "<p class=\"ou\"><label for=\"a$lauks[id]\">$lauks[field_name]</label><input type=\"text\" class=\"input1\"  name=\"$lauks[id]\" $wid $le id=\"$lauks[id]\" value=\"$v_nos\" />$obligati</p>";
		}
		if($lauks["field_type"]==4)
		{
			if($lauks["field_fill"]==2){$obligati=" <span class=\"star\">*</span>";$o++;}else{$obligati="";}
			if($lauks["field_width"]!="") {$wid = "style=\"width:$lauks[field_width]px;\"";}else{$wid = "";}
			echo "<p class=\"ou\"><label for=\"a$lauks[id]\">$lauks[field_name]</label><textarea class=\"input-textarea\"  name=\"$lauks[id]\" $wid id=\"$lauks[id]\" rows=\"6\">$v_nos</textarea>$obligati</p>";
		}
		if($lauks["field_type"]==5)
		{
			if(!empty($lauks["field_name"]))
			{
				echo "<p class=\"ou\"><label>&nbsp;</label><strong>$lauks[field_name]</strong></p>";
			}
			else
			{
				echo "<p class=\"ou\">&nbsp;</p>";
			}
		}
		$a++;
	}	
	mysql_free_result($lauki);		
								
	
	
	?>
    
    <p class="ou"><label for="dointroduction">&nbsp;</label> <input type="submit" name="submit" id="submit" value="<?php echo $e[36]; ?>" class="button" style="width:120px;"></p>
   
    <?php
    if($show_check>0)
	{
		echo "<p class=\"ou\"><label for=\"dointroduction\">&nbsp;</label>$e[31]</p>";
	}
	?>
    
</form>
\<?php
//ielâdçjam funkcijas
require_once("config.php");
//pârbaudam, vai lietotâjs ir reìistrçjies
require_once($wolf_path."check.php");


		
$p_cipari="^([0-9]+)$";
$place_new=$name;

$nos="branches_items";
if(eregi($p_cipari,$place_new))
{
// ja jaunâ vieta ir tâda pati kâ esoðâ, neko nemainam
$rep0=mysql_query("Select * from $nos where id='$k'");
$rop0=mysql_fetch_array($rep0);
$place_old = $rop0["place"];
if($place_new!=$place_old)
{

	
	// ja tâda vieta ir brîva, tad ierakstam jauno vietu
	$rep=mysql_query("Select * from $nos where place='$place_new' and branche_id='$id'");
	if(!$rop=mysql_fetch_array($rep))
	{
		$result = mysql_query("update $nos set place='$place_new' where id='$k'"); 
	}
	// ja tâda vieta ir aizòemta, pârbîdam attiecîgos ierakstus
	else
	{
		// nomainam vçrtîbas tiem, ierakstiem, kam place ir lielaaks par veco un mazaaks par jauno
		if($place_new>$place_old)
		{
			$rep2=mysql_query("Select * from $nos where place>'$place_old' and place<='$place_new' and id!='k' and branche_id='$id'");
			while($rop2=mysql_fetch_array($rep2))
			{
				$pla = $rop2["place"];
				$pla--;
				$result = mysql_query("update $nos set place='$pla' where id='$rop2[id]'"); 
			}
			mysql_free_result($rep2);
		}
		elseif($place_new<$place_old)
		{
			$rep2=mysql_query("Select * from $nos where place<'$place_old' and place>='$place_new' and id!='k' and branche_id='$id'");
			while($rop2=mysql_fetch_array($rep2))
			{
				$pla = $rop2["place"];
				$pla++;
				$result = mysql_query("update $nos set place='$pla' where id='$rop2[id]'"); 
			}
			mysql_free_result($rep2);
		}
		
	}
	
mysql_free_result($rep);
$result = mysql_query("update $nos set place='$place_new' where id='$k'"); 
}
mysql_free_result($rep0);
}

$links = "branches_items.php".$li."&page=$_GET[page]";
header("Location: $links");
exit;
?>
<?php
//iel�d�jam funkcijas
require_once("config.php");
//p�rbaudam, vai lietot�js ir re�istr�jies
require_once($wolf_path."check.php");


		
$p_cipari="^([0-9]+)$";
$place_new=$name;

$nos="items";
if(is_numeric($place_new))
{
	$place_new = (int)$place_new;
// ja jaun� vieta ir t�da pati k� eso��, neko nemainam
$rep0=mysqli_query($result_db,"Select * from $nos where id='$k'");
$rop0=mysqli_fetch_array($rep0);
$place_old = $rop0["place"];
if($place_new!=$place_old)
{

	
	// ja t�da vieta ir br�va, tad ierakstam jauno vietu
	$rep=mysqli_query($result_db,"Select * from $nos where place='$place_new' and parent_id='$id'");
	if(!$rop=mysqli_fetch_array($rep))
	{
		$result = mysqli_query($result_db,"update $nos set place='$place_new' where id='$k'"); 
	}
	// ja t�da vieta ir aiz�emta, p�rb�dam attiec�gos ierakstus
	else
	{
		// nomainam v�rt�bas tiem, ierakstiem, kam place ir lielaaks par veco un mazaaks par jauno
		if($place_new>$place_old)
		{
			$rep2=mysqli_query($result_db,"Select id,place from $nos where place>'$place_old' and place<='$place_new' and id!='k' and parent_id='$id'");
			while($rop2=mysqli_fetch_array($rep2))
			{
				$pla = $rop2["place"];
				$pla--;
				$result = mysqli_query($result_db,"update $nos set place='$pla' where id='$rop2[id]'"); 
			}
			mysqli_free_result($rep2);
		}
		elseif($place_new<$place_old)
		{
			$rep2=mysqli_query($result_db,"Select id,place from $nos where place<'$place_old' and place>='$place_new' and id!='k' and parent_id='$id'");
			while($rop2=mysqli_fetch_array($rep2))
			{
				$pla = $rop2["place"];
				$pla++;
				$result = mysqli_query($result_db,"update $nos set place='$pla' where id='$rop2[id]'"); 
			}
			mysqli_free_result($rep2);
		}
		
	}
	
mysqli_free_result($rep);
$result = mysqli_query($result_db,"update $nos set place='$place_new' where id='$k'"); 
}
mysqli_free_result($rep0);
}

$links = "index.php".$li."&limit=$limit";
header("Location: $links");
exit;
?>
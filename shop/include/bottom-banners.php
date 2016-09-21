<?php

	$saite_lang = "saite";
	$data=time();
	$end_data = mktime(0,0,0,date("n"),date("j"),date("Y"));
	if($content_change > 0)
	{
		$cats = " and category like '%*$id*%'";
	}	
	else
	{	
		$cats = "";
	}
	$resb=mysql_query("SELECT * FROM banners where bdat>='$end_data' and sdat<='$data' and lang like '%*$_GET[lang]*%' and novietojums='2' and formats < '3' $cats order by rand()");

	$buttons = "";
	if($rowb=mysql_fetch_array($resb))
	{
		$ww = 1000;
		$hh = 130;
				
		if($rowb["formats"]=="2")
		{
			echo "
			<div id=\"banner-1\"></div>
      	<script type=\"text/javascript\">
         // <![CDATA[         
         var so = new SWFObject(\"".$root_dir."banners/$rowb[datne]?clickTAG=".$root_dir."include/ads.php?id=$_GET[lang]/$rowb[id]\", \"banner-1\", \"$ww\", \"$hh\", \"9\", \"#ffffff\");
         so.addParam(\"scale\", \"noscale\");
         so.addParam(\"wmode\", \"transparent\");
         so.write(\"banner-1\");		
         // ]]>
      	</script>\n";
		}
		else
		{
			echo "<div id=\"banner-1\" ><a href=\"".$root_dir."include/ads.php?id=$_GET[lang]/$rowb[id]\" target=\"_blank\"><img src=\"".$root_dir."banners/$rowb[datne]\" border=\"0\" width=\"$ww\" height=\"$hh\" /></a></div>\n";
		}		
	}
	mysql_free_result($resb);
	
?>
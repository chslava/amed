<?php
	$echo_banners = '';
	$saite_lang = "saite";
	$data=time();
	$end_data = mktime(0,0,0,date("m"),date("d"),date("Y"));
	if($content_change > 0 && $content_change < 4)
	{
		$cats = " and category like '%*$id*%'";
	}	
	else
	{	
		$cats = "";
	}
	$resb=mysql_query("SELECT * FROM banners where bdat>='$end_data' and sdat<='$data' and lang like '%*$_GET[lang]*%' and novietojums='1' and formats < '3' $cats order by rand()");
	$resb=mysql_query("SELECT * FROM banners where bdat>='$end_data' and sdat<='$data' and lang like '%*$_GET[lang]*%' and novietojums='1' and formats < '3' $cats order by place desc limit 0,1");

	$buttons = "";
	if($rowb=mysql_fetch_array($resb))
	{
		
		$echo_banners .= "<div id=\"itemid\">$id||$rowb[id]</div>";
		$ww = 1000;
		$hh = 150;
				
		if($rowb["formats"]=="2")
		{
			$echo_banners .= "
			<div id=\"banner-2\"></div>
      	<script type=\"text/javascript\">
         // <![CDATA[         
         var so = new SWFObject(\"".$root_dir."banners/$rowb[datne]?clickTAG=".$root_dir."include/ads.php?id=$_GET[lang]/$rowb[id]\", \"banner-2\", \"$ww\", \"$hh\", \"9\", \"#ffffff\");
         so.addParam(\"scale\", \"noscale\");
         so.addParam(\"wmode\", \"transparent\");
         so.write(\"banner-2\");		
         // ]]>
      	</script>\n";
		}
		else
		{
			$echo_banners .= "<div id=\"banner-2\" ><a href=\"".$root_dir."include/ads.php?id=$_GET[lang]/$rowb[id]\" target=\"_blank\"><img src=\"".$root_dir."banners/$rowb[datne]\" border=\"0\" width=\"$ww\" height=\"$hh\" /></a></div>\n";
		}		
	}
	
?>
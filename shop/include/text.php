<?php
	$count = 0; $class = "text-container"; $content = "text"; $content_top = "text-top"; $content_bottom = "text-bottom";
	$query = mysql_query("select * from content where parent_id = '$izv_id' and lang ='$_GET[lang]'");
	if($mysql = mysql_fetch_array($query))
	{
		$count = 1; $class = "item-container"; $content = "content";  $content_top = "content-top"; $content_bottom = "content-bottom";
	}
	mysql_free_result($query);
?>

<div id="<?php echo $content_top; ?>"></div>
<div id="<?php echo $content; ?>">
	<?php
	if($count == 1)
	{
	?>
	<div id="categories">
		<ul><?php require_once("include/menu.php"); ?></ul>
		<?php
		/*
		include("include/operating_system_detect.php");
		$operating_system = os_info($_SERVER['HTTP_USER_AGENT']);
		if($operating_system == 'MacOS')
		{
			$teamviewer_file = 'teamviewer.dmg';
		}
		else
		{
			$teamviewer_file = 'teamviewer_setup.exe';
		}*/
		$teamviewer_file = 'a-medical-it-atbalsts.exe';
		?>
		<div class="atbalsts"><a href="<?php echo $root_dir; ?>teamviewer/<?php echo $teamviewer_file; ?>" onclick="OpenServicePopup();" title=""><img src="<?php echo $img_dir; ?>atbalsts-<?php echo $_GET['lang']; ?>.png" width="221" height="42" alt="" /></a></div>
		<?php
		if($rezultats > 0)
		{
			
		}
		else
		{	
			if($anketa > 0)
			{
				if($anketa_type == 2)
				{
					require_once("include/anketa-small.php");
				}
			}
		}		
		?>
		
	</div>
	<?php
	}
	?>
	<div id="<?php echo $class; ?>">
		<h1><?php echo $izveleta; ?></h1>
		<div id="items">
			
			<?php 
			if($rezultats > 0)
			{
				echo "<div>".$anket["sent_text"]."</div>";
			}
			else
			{		
				echo '<div>';
				$teksts=str_replace("`","'",$teksts);
				$teksts=str_replace("onclick=\"ShowText(","onclick=\"ShowText(this,",$teksts);
				
				#Sameklējam, vai nav pievienota kāda fotogalerija
				$pattern = "/{FOTO}(.*?){\/FOTO}/";
				if (preg_match_all($pattern, $teksts, $matches))
				{
				    foreach ($matches[1] as $_match)
				    {     
				    	$this_album = '';
				    	$query = mysql_query("select * from albums where id = '$_match'");
				    	if($mysql = mysql_fetch_array($query))
				    	{
				    		$this_album .= '<div id="album">';
				    		
				    		$query1 = mysql_query("select * from pictures where parent_id = '$mysql[id]'");
				    		while($mysql1 = mysql_fetch_array($query1))
				    		{
				    			$this_album .= '
				    			<div class="album-thumb"><a href="'.$root_dir.'pictures/albums/big/'.$mysql1["file_name"].'.jpg" rel="lightbox[items-'.$mysql['id'].']" title=""><img src="'.$root_dir.'pictures/albums/small/'.$mysql1["file_name"].'.jpg" alt="" /></a></div>
				    			';
				    		}	
				    							
				    		$this_album .= '
				    		<div class="clear"></div>
				    		</div>';
				    	}
				        $teksts = str_replace('{FOTO}'.$_match.'{/FOTO}', $this_album, $teksts);
				    }
				}

				echo $teksts; 
				echo '</div>';
				if($anketa > 0 && $anketa_type == 1)
				{ 
					require_once("include/anketa.php"); 
				}	
				if($album > 0)
				{
				    $query = mysql_query("select * from albums where id = '$album'");
				    if($mysql = mysql_fetch_array($query))
				    {
				    	echo '
				    	<div id="album">
				    		<h2>'.$mysql[$name_lang].'</h2>
				    		<div id="album-text">'.$mysql[$text_lang].'</div>';
				    	
				    	$query1 = mysql_query("select * from pictures where parent_id = '$mysql[id]'");
				    	while($mysql1 = mysql_fetch_array($query1))
				    	{
				    		echo '
				    		<div class="album-thumb"><a href="'.$root_dir.'pictures/albums/big/'.$mysql1["file_name"].'.jpg" rel="lightbox[items]" title=""><img src="'.$root_dir.'pictures/albums/small/'.$mysql1["file_name"].'.jpg" alt="" /></a></div>
				    		';
				    	}
				    	mysql_free_result($query1);							
				    	echo '
				    	<div class="clear"></div>
				    	</div>';
				    }
				    mysql_free_result($query);
				}								
			}	
			
			
			
			
					
			?> 
			
		</div>
	</div>
	<div class="clear"></div>
</div>
<div id="<?php echo $content_bottom; ?>"></div>
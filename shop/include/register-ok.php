<div id="text-top"></div>
<div id="text">
		
	<div id="text-container">
		<h1><?php echo $e[95]; ?></h1>
		<div id="items">
		<?php 
		if(isset($_GET["code"]))
		{		    
		    if(count($error) == 0)
		    {
		    	echo '<div id="error">'.$e[112].'</div>';
		    }
		    else
		    {
		    	echo '<div id="error">'.$e[113].'</div>';
		    }		    
		}
		else
		{
		    echo '<div id="error">'.$e[102].'</div>';
		}
		?>		
		</div>
	</div>
	<div class="clear"></div>
	
</div>
<div id="text-bottom"></div>
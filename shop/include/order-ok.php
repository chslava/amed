<div id="text-top"></div>
<div id="text">
		
	<div id="text-container">
		<h1><?php echo $e[65]; ?></h1>
		<div id="items">
			
				<div id="error">
				<?php 
					echo '<p style="color: black;">'.$e[93].'</p>';
					if($_GET["gift"] > 0)
					{
						if($_GET["gift"] == 1)
						{
							$gift_msg = $e[158];
						}
						if($_GET["gift"] == 2)
						{
							$gift_msg = $e[159];
						}
						if($_GET["gift"] == 3)
						{
							$gift_msg = $e[160];
						}
						
						echo '<p>'.$gift_msg.'</p>';
					}
				?>
				</div>
			
		</div>
	</div>
	<div class="clear"></div>
	
</div>
<div id="text-bottom"></div>
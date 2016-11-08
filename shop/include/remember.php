<div id="text-top"></div>
<div id="text">
		
	<div id="text-container">
		<h1><?php echo $e[115]; ?></h1>
		<div id="items">
			
			<?php		
		echo '
			<form name="create-order" method="post" action="#action">';
			if(count($error) > 0)
			{
				echo '
				<div id="error">';
				if(isset($error[0]))
				{
					echo '<div>'.$e[118].'</div>';
				}
				if(isset($error[1]))
				{
					echo '<div>'.$e[119].'</div>';
				}
					
				echo '</div>';
			}
								
			echo '
			    			    
			    <div>
			    	<table cellpadding="5" cellspacing="2" border="0" width="100%" style="padding: 10px 0 0 0;">
			    		<tr>
			    			<td class="basket-td" colspan="2" style="font-size:15px;"><b>'.$e[117].'</b></td>
			    		</tr>
			    		
			     		<tr>
			    			<td>'.$e[69].' <input type="text" class="order-input-3"  name="email" value="'.$_POST["email"].'" /></td>
			    		</tr>
			    		
			    	</table>
			    	
			    </div>
			    
			    <div class="order-continue-left">
			    	 
			    	<input type="submit" value="'.$e[116].'" class="order-continue" name="remember">
			    </div>
			</form>';
					
			?>
			
		</div>
	</div>
	<div class="clear"></div>
	
</div>
<div id="text-bottom"></div>
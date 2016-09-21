<div id="text-top"></div>
<div id="text">
		
	<div id="text-container">
		<h1><?php echo $e[95]; ?></h1>
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
					echo '<div>'.$e[94].'</div>';
				}
				if(isset($error[1]))
				{
					echo '<div>'.$e[99].'</div>';
				}
				if(isset($error[2]))
				{
					echo '<div>'.$e[100].'</div>';
				}	
				if(isset($error[3]))
				{
					echo '<div>'.$e[101].'</div>';
				}		
				echo '</div>';
			}
								
			echo '
			    <table cellpadding="5" cellspacing="2" border="0">
			    	<tr>
			    		<td>
			    			<br />
			    			<input type="radio" name="person" value="1" ';	if($_POST["person"] == 1) echo 'checked="checked"'; echo ' onclick="ShowElement(\'1\');" /> '.$e[78].' &nbsp;&nbsp;&nbsp;&nbsp;
			    			<input type="radio" name="person" value="2" ';	if($_POST["person"] == 2) echo 'checked="checked"'; echo ' onclick="ShowElement(\'2\');" /> '.$e[79].'
			    		</td>
			    	</tr>
			    </table>
			    
			    <div id="order-company"'; if($_POST["person"] == 2) echo ' class="not-visible"'; echo '>
			    	<table cellpadding="5" cellspacing="2" border="0" width="100%">
			    		<tr>
			    			<td class="basket-th-1" colspan="2">'.$e[77].'</td>
			    		</tr>
			    		<tr>
			    			<td class="basket-td-left">'.$e[80].'</td>
			    			<td class="basket-td-1"><input type="text" class="order-input-1"  name="company_name" value="'.$_POST["company_name"].'" /></td>
			    		</tr>
			    		<tr>
			    			<td class="basket-td-left">'.$e[81].'</td>
			    			<td class="basket-td-1"><input type="text" class="order-input-1"  name="company_code" value="'.$_POST["company_code"].'" /></td>
			    		</tr>
			    		<tr>
			    			<td class="basket-td-left">'.$e[82].'</td>
			    			<td class="basket-td-1"><input type="text" class="order-input-1"  name="company_address" value="'.$_POST["company_address"].'" /></td>
			    		</tr>
			    		<tr>
			    			<td class="basket-td-left">'.$e[83].'</td>
			    			<td class="basket-td-1"><input type="text" class="order-input-2"  name="company_bank" value="'.$_POST["company_bank"].'" /></td>
			    		</tr>
			    		<tr>
			    			<td class="basket-td-left">'.$e[85].'</td>
			    			<td class="basket-td-1"><input type="text" class="order-input-2"  name="company_account" value="'.$_POST["company_account"].'" /></td>
			    		</tr>
			    		<tr>
			    			<td class="basket-th-1" colspan="2">'.$e[86].'</td>
			    		</tr>
			    		<tr>
			    			<td class="basket-td-left">'.$e[91].'</td>
			    			<td class="basket-td-1"><input type="text" class="order-input-2"  name="company_person" value="'.$_POST["company_person"].'" /></td>
			    		</tr>
			    		<tr>
			    			<td class="basket-td-left">'.$e[138].'</td>
			    			<td class="basket-td-1"><input type="text" class="order-input-2"  name="company_position" value="'.$_POST["company_position"].'" /></td>
			    		</tr>
			    		<tr>
			    			<td class="basket-td-left">'.$e[87].'</td>
			    			<td class="basket-td-1"><input type="text" class="order-input-2"  name="company_phone" value="'.$_POST["company_phone"].'" /></td>
			    		</tr>
			    		<tr>
			    			<td class="basket-td-left">'.$e[89].'</td>
			    			<td class="basket-td1-"><input type="text" class="order-input-1"  name="company_deliver" value="'.$_POST["company_deliver"].'" /></td>
			    		</tr>
			    		<tr>
			     			<td class="basket-th-1" colspan="2">'.$e[123].'</td>
			     		</tr>
			     		<tr>
			     			<td class="basket-td-1" colspan="2">'.$e[124].' <a href="'.$e[127].'" target="_blank" title="">('.$e[126].')</a></td>
			     		</tr>
			     		
			    		<tr>
			    			<td class="basket-th-1" colspan="2">'.$e[96].'</td>
			    		</tr>
			    		<tr>
			    			<td class="basket-td-left">'.$e[69].'</td>
			    			<td class="basket-td-1"><input type="text" class="order-input-2"  name="company_user_email" value="'.$_POST["company_user_email"].'" /></td>
			    		</tr>
			    		<tr>
			    			<td class="basket-td-left">'.$e[68].'</td>
			    			<td class="basket-td-1"><input type="password" class="order-input-2"  name="company_user_password1" value="'.$_POST["company_user_password1"].'" /></td>
			    		</tr>
			    		<tr>
			    			<td class="basket-td-left">'.$e[97].'</td>
			    			<td class="basket-td1-"><input type="password" class="order-input-2"  name="company_user_password2" value="'.$_POST["company_user_password2"].'" /></td>
			    		</tr>
			    	</table>
			    	
			    </div>
			    
			    <div id="order-person"'; if($_POST["person"] == 1) echo ' class="not-visible"'; echo '>
			    	<table cellpadding="5" cellspacing="2" border="0" width="100%">
			     		<tr>
			     			<td class="basket-th-1" colspan="2">'.$e[77].'</td>
			     		</tr>
			     		<tr>
			     			<td class="basket-td-left">'.$e[91].'</td>
			     			<td class="basket-td-1"><input type="text" class="order-input-1"  name="person_name" value="'.$_POST["person_name"].'" /></td>
			     		</tr>
			     		<tr>
			     			<td class="basket-td-left">'.$e[92].'</td>
			     			<td class="basket-td-1"><input type="text" class="order-input-1"  name="person_code" value="'.$_POST["person_code"].'" /></td>
			     		</tr>
			     		
			     		<tr>
			     			<td class="basket-th-1" colspan="2">'.$e[86].'</td>
			     		</tr>
			     		<tr>
			     			<td class="basket-td-left">'.$e[87].'</td>
			     			<td class="basket-td-1"><input type="text" class="order-input-2"  name="person_phone" value="'.$_POST["person_phone"].'" /></td>
			     		</tr>
			     		<tr>
			     			<td class="basket-td-left">'.$e[89].'</td>
			     			<td class="basket-td1-"><input type="text" class="order-input-1"  name="person_deliver" value="'.$_POST["person_deliver"].'" /></td>
			     		</tr>
			     		<!--
			     		<tr>
			     			<td class="basket-th-1" colspan="2">'.$e[123].'</td>
			     		</tr>
			     		<tr>
			     			<td class="basket-td-1" colspan="2">'.$e[124].' <a href="'.$e[127].'" target="_blank" title="">('.$e[126].')</a></td>
			    		</tr>-->
			     		<tr>
			     			<td class="basket-th-1" colspan="2">'.$e[96].'</td>
			     		</tr>
			     		<tr>
			    			<td class="basket-td-left">'.$e[69].'</td>
			    			<td class="basket-td-1"><input type="text" class="order-input-2"  name="person_user_email" value="'.$_POST["person_user_email"].'" /></td>
			    		</tr>
			    		<tr>
			    			<td class="basket-td-left">'.$e[68].'</td>
			    			<td class="basket-td-1"><input type="password" class="order-input-2"  name="person_user_password1" value="'.$_POST["person_user_password1"].'" /></td>
			    		</tr>
			    		<tr>
			    			<td class="basket-td-left">'.$e[97].'</td>
			    			<td class="basket-td1-"><input type="password" class="order-input-2"  name="person_user_password2" value="'.$_POST["person_user_password2"].'" /></td>
			    		</tr>
						
			    	</table>
			    	
			    </div>
			    
			    <div class="order-continue-left">
			    	 
			    	<input type="submit" value="'.$e[98].'" class="order-continue" name="register">
			    </div>
			</form>';
					
			?>
		</div>
	</div>
	<div class="clear"></div>
	
</div>
<div id="text-bottom"></div>
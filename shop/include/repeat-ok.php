<div id="text-top"></div>
<div id="text">
		
	<div id="text-container">
		<h1><?php echo $e[65]; ?></h1>
		<div id="items">
			<div id="error"><?php echo $e[178]; ?></div>
			<div class="order-continue">
				<?php	
				$query = mysqli_query($result_db,"select * from $tabula where template = '3' and lang = '$_GET[lang]' and publish = 'on'");
				$mysql = mysqli_fetch_array($query);
				mysqli_free_result($query);		
				?>		
				<input type="button" value="<?php echo $e[179]; ?>" class="order-continue" onclick="go('<?php echo $root_dir.$_GET["lang"].'/'.$mysql["url"]; ?>');">
			</div>
		</div>
	</div>
	<div class="clear"></div>
	
</div>
<div id="text-bottom"></div>
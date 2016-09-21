<div class="titul-container">
	<div id="titul"><img src="<?php echo $img_dir; ?>titul-background.png"></div>
    	
    <div class="left-h1"><a href="<?php echo $root_dir.$_GET['lang'].'/industry' ?>" title="<?php echo $mysql[$name_lang]; ?>">
	    <?php
	    $query = mysql_query("select * from categories where parent_id = '0' and industry = '1'");
	    $mysql = mysql_fetch_array($query);
	    echo $mysql[$name_lang];
	    ?>
    </a></div>
    <div class="right-h1"><a href="<?php echo $root_dir.$_GET['lang'].'/medicine' ?>" title="<?php echo $mysql[$name_lang]; ?>">
	    <?php
	    $query = mysql_query("select * from categories where parent_id = '0' and industry = '2'");
	    $mysql = mysql_fetch_array($query);
	    echo $mysql[$name_lang];
	    ?>
    </a></div>
    <script type="text/javascript">
     // <![CDATA[         
     var so = new SWFObject("<?php echo $img_dir; ?>titul-new-1.swf?clickTAG1=<?php echo $root_dir.$_GET['lang'];?>/industry&clickTAG2=<?php echo $root_dir.$_GET['lang']; ?>/medicine", "banner-2", "1058", "439", "8", "#ffffff");
     so.addParam("scale", "noscale");
     so.addParam("wmode", "transparent");
     so.write("titul");		
     // ]]>
    </script>
</div>

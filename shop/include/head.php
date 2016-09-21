<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
	$query = mysqli_query($result_db,"select * from keywords order by rand() limit 0,3");
	while($mysql = mysqli_fetch_array($query))
	{
		$keywords .= ", ".$mysql["name"];
	}
	mysqli_free_result($query);
	?>
	<title><?php echo $title; ?></title>
	<meta name="description" content="<?php echo $description; ?>" />
	<meta name="keywords" content="<?php echo $keywords; ?>" />
	<meta http-equiv="Content-Type" content="text/html; <?php echo $encoding; ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">


	<link type="text/css" rel="stylesheet" href="<?php echo $css_dir; ?>style.css?version=<?php echo date ("YmdHis", filemtime($css_file)); ?>" />
  	<link rel="shortcut icon" href="<?php echo $root_dir; ?>include/favicon.ico" />

    <script language="javascript" type="text/javascript">
	//<![CDATA[
		var root_url = "<?php echo $root_dir; ?>";
		var lang = "<?php echo $_GET["lang"]; ?>";
		var lvl = "<?php echo $e[13]; ?>";
		var d1 = "<?php echo $e[144]; ?>";
		var d2 = "<?php echo $e[145]; ?>";
		var d3 = "<?php echo number_format(round($e[144] / $e[201],2),2,'.',''); ?>";
		var d4 = "<?php echo number_format(round($e[145] / $e[201],2),2,'.',''); ?>";
		var kurss = "<?php echo $e[201]; ?>";
		var picture_copyright = "";

	//]]>
    </script>

    <script src="<?php echo $root_dir; ?>/include/javascript.js?version=<?php echo date ("YmdHis", filemtime("include/javascript.js")); ?>" type="text/javascript"></script>
   	<!--[if lt IE 7]>
   	<script type="text/javascript" src="<?php echo $root_dir; ?>include/unitpngfix.js"></script>
	<![endif]-->

	<script type="text/javascript" src="<?php echo $root_dir; ?>/js/prototype.js"></script>
	<script type="text/javascript" src="<?php echo $root_dir; ?>/js/scriptaculous.js?load=effects,builder"></script>
	<script type="text/javascript" src="<?php echo $root_dir; ?>/js/lightbox.js"></script>
	<link rel="stylesheet" href="<?php echo $root_dir; ?>/css/lightbox.css" type="text/css" media="screen" />
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-46092264-1', 'amedical.eu');
  ga('send', 'pageview');

</script>
</head>

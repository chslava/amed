<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		<?php echo wp_title(); ?>
	</title>
	<link type="image/x-icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon.ico" rel="shortcut icon">

	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-46092264-1', 'amedical.eu');
		ga('send', 'pageview');
	</script>

	<script>
		var lang = '<?php print(ICL_LANGUAGE_CODE); ?>';
		var contact_page_link = '<?php the_field("contact_page_link","option"); ?>';
		var contact_form_id = '<?php the_field("contact_form_id","option"); ?>'
	</script>

	<?php wp_head(); ?>

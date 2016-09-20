<?php
//page
get_header();
?>

<main class="ui container page">
	<?php include_once('includes/parts/breadcrumbs.php');?>
	<div class="ui grid content-page">
		<div class="sixteen wide mobile eight wide tablet eight wide computer column">
			<h1 class="ui left header decored"><?php _e( 'File Not Found', 'dswp' ); ?></h1>

			<p><?php _e( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'dswp' ); ?></p>
			<br/>
			<p><?php _e( 'Please try the following:', 'dswp' ); ?></p>
			<ul>
				<li><?php _e( 'Check your spelling', 'dswp' ); ?></li>
				<li><?php printf( __( 'Return to the <a href="%s">home page</a>', 'dswp' ), home_url() ); ?></li>
				<li><?php _e( 'Click the <a href="javascript:history.back()">Back</a> button', 'dswp' ); ?></li>
			</ul>
		</div>
	</div>
</main>

<?php get_footer(); ?>

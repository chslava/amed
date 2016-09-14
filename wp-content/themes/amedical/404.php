<?php get_header(); ?>
		<div class="row column">

			<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
				<h1 class="entry-title"><?php _e( 'File Not Found', 'dswp' ); ?></h1>
				<div class="content error">
						<p><?php _e( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'dswp' ); ?></p>
					<p><?php _e( 'Please try the following:', 'dswp' ); ?></p>
					<ul>
						<li><?php _e( 'Check your spelling', 'dswp' ); ?></li>
						<li><?php printf( __( 'Return to the <a href="%s">home page</a>', 'dswp' ), home_url() ); ?></li>
						<li><?php _e( 'Click the <a href="javascript:history.back()">Back</a> button', 'dswp' ); ?></li>
					</ul>
				</div>
			</article>

		</div>

<?php get_footer(); ?>

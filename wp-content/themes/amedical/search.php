<?php get_header(); ?>
<div class="row">
	<div class="small-12 large-8 columns" role="main">

		<h2><?php _e( 'Search Results for', 'dswp' ); ?> "<?php echo get_search_query(); ?>"</h2>

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>
			<?php the_title(); ?>
			<?php the_content(); ?>
		<?php endwhile; ?>

		<?php else : ?>
			<?php the_title(); ?>
			<?php the_content(); ?>

	<?php endif;?>


	<?php if ( is_paged() ) { ?>

		<nav id="post-nav">
			<div class="post-previous"><?php next_posts_link( __( '&larr; Older posts', 'dswp' ) ); ?></div>
			<div class="post-next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'dswp' ) ); ?></div>
		</nav>
	<?php } ?>


	</div>
	<?php get_sidebar(); ?>

<?php get_footer(); ?>

<?php get_header();
?>

<div class="row">
	<div class="small-12 columns">
		<section class="main-content" role="main">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>
					<h1><?php the_title(); ?></h1>
					<?php the_content(); ?>
				<?php endwhile; ?>

			<?php endif;?>



			<?php if ( is_paged() ) { ?>
				<nav id="post-nav">
					<div class="post-previous"><?php next_posts_link( __( '&larr; Older posts', 'dswp' ) ); ?></div>
					<div class="post-next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'dswp' ) ); ?></div>
				</nav>
			<?php } ?>

			</div>

		</section>

		<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>

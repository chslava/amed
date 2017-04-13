<?php
/**
 * Template Name: Consultation page
 * The template for displaying Consultation page for A.Medical Theme.
 * @package amedical
 * @author Eugene Kudriashov
 */
get_header(); ?>
<main>
	<div class="ui container">
		<?php get_template_part( 'includes/parts/breadcrumbs' ); ?>
	</div>
</main>
<section class="consultation-form">
	<div class="ui container">
		<div class="ui grid">
			<?php while ( have_posts() ) : the_post(); ?>
			<div class="sixteen wide mobile sixteen wide tablet five wide computer column">
				<?php
					$cons_title = get_field( 'cons_custom_title' );
					if( $cons_title ) : ?>
						<h2 class="left ui header decored mobile-centered"><?php echo $cons_title; ?></h2>
				<?php else :
						the_title( '<h2 class="left ui header decored mobile-centered">', '</h2>' );
					endif;
					the_field('cons_page_tagline');
				?>
				<?php the_field('cons_form_shortcode'); ?>
			</div>
			<?php endwhile; ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>

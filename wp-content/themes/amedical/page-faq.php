<?php
/**
 * Template Name: FAQ page
 * The template for displaying FAQ page for A.Medical Theme.
 * @package amedical
 * @author Eugene Kudriashov
 */
get_header(); ?>
<main class="ui container faq-page page">
	<?php get_template_part( 'includes/parts/breadcrumbs' ); ?>
	<div class="ui grid">
		<div class="ui row">
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="sifaxteen wide mobile ten wide tablet eleven wide computer column" id="faq-block">
					<?php
						$faq_title = get_field( 'faq_custom_title' );
						if( $faq_title ) { ?>
							<h1 class="left ui header decored mobile-centered"><?php echo $faq_title; ?></h1>
						<?php } else {
							the_title( '<h1 class="left ui header decored mobile-centered">', '</h1>' );
							}
							the_content();
							
							$freq_questions = get_field('freq_questions');
							if($freq_questions) :
								$active = true; ?>
								<div class="ui fluid accordion faq-accordion">
								<?php foreach($freq_questions as $question) : ?>
									<div class="title <?php if($active) echo 'active'; ?>">
										<?php echo $question['question']; ?><i class="chevron down icon"></i>
									</div>
									<div class="content <?php if($active) echo 'active'; ?>">
										<?php echo $question['answer']; ?>
									</div>
								<?php
									$active = false;
									endforeach;
								?>
								</div>
							<?php endif; ?>
				</div>
			<?php endwhile; ?>
			<?php get_sidebar(); ?>
		</div>
	</div>
</main>
<?php get_footer(); ?>

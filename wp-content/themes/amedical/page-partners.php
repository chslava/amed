<?php
/**
 * Template Name: Partners page
 * The template for displaying Partners page for A.Medical Theme.
 * @package amedical
 * @author Eugene Kudriashov
 */
get_header(); ?>
<main class="ui container partners-page page">
	<?php get_template_part( 'includes/parts/breadcrumbs' ); ?>
	<div class="ui grid">
		<?php while ( have_posts() ) : the_post(); ?>
			<div class="ui row">
				<div class="sixteen wide mobile eleven wide computer column">
					<div class="partners-about">
					<?php
						$page_title = get_field( 'partners_custom_title' );
						if( $page_title ) { ?>
							<h1 class="ui header decored left"><?php echo $page_title; ?></h1>
						<?php } else {
							the_title( '<h1 class="ui header decored left">', '</h1>' );
							}
							the_content();
					?>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
		<?php
			$partners_args = array(
				'post_type' => 'partner',
				'posts_per_page' => -1
			);
			$partners_counter = 0;
			$partners_q = new WP_Query( $partners_args );
			if ( $partners_q->have_posts() ) : ?>
				<div class="ui row">
					<div class="sixteen wide mobile column" id="partners-list">
						<div class="ui stackable equal height grid">
							<div class="four column row">
							<?php
								while ( $partners_q->have_posts() ) :
									$partners_q->the_post(); ?>
								
								<?php if( get_field('show_on_partners_page') ): ?>
									<div class="partner-container ui eight wide tablet four wide computer column">
										<div class="partner">
										
											<?php if (has_post_thumbnail()): ?>
                                                <img src="<?= get_the_post_thumbnail_url( get_the_ID(), 'partner-logo' ) ?>" width="100%" height="auto" />
											<?php endif; ?>
											<?php
												// the_title( '<h2 class="ui header decored left uppercase">', '</h2>' );
												// the_field('partner_description_text');
												if( get_field('link_to_partner_shop_category') ) :
											?>
												<a class="ui basic button wider" href="<?php the_field('link_to_partner_shop_category'); ?>">
													<?php esc_html_e( 'View products', 'dswp' ); ?>
												</a>
											<?php
												endif;
												if( get_field('link_to_partner_site') ) :
											?>
												<a class="read-more-link" href="<?php the_field('link_to_partner_site'); ?>" target="_blank">
													<?php esc_html_e( 'View partner website', 'dswp' ); ?><i class="long right arrow icon"></i>
												</a>
											<?php endif; ?>
										</div>
									</div>
								<?php endif; ?>
								
							<?php
								$partners_counter++;
								if ($partners_counter % 4 == 0) {
									echo '</div><div class="four column row">';
								}
							?>
							<?php endwhile; ?>
							</div>
						</div>
					</div>
				</div>
		<?php
			endif;
			wp_reset_postdata();
		?>
	</div>
</main>
<?php get_footer(); ?>

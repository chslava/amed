<?php
/**
 * The sidebar(widgets area) template file for A.Medical Theme.
 * @package amedical
 * @author Eugene Kudriashov
 */
?>
<div class="sixteen wide mobile six wide tablet five wide computer column" id="news-sidebar">
	<div class="news-sidebar">
		<?php dynamic_sidebar('main-sidebar'); ?>
		<?php if(is_page_template('page-faq.php') && (get_field('not_found_link')) ) : ?>
			<h3 class="ui header">
				<?php the_field( 'not_found_title' ); ?>
				<a class="ui primary button" href="<?php the_field( 'not_found_link' ); ?>"><?php the_field( 'not_found_text' ); ?></a>
			</h3>
		<?php endif; ?>
	</div>
</div>
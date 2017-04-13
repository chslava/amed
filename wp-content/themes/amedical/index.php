<?php
/**
 * The main template file for A.Medical Theme.
 * @package amedical
 * @author Eugene Kudriashov
 */
get_header();
?>
<main class="ui container news-page page">
<?php get_template_part( 'includes/parts/breadcrumbs' ); ?>
  <div class="ui grid">
    <div class="ui row">
      <?php if ( have_posts() ) : ?> 
        <div class="sixteen wide mobile ten wide tablet eleven wide computer column" id="news-block-<?php the_ID(); ?>">   
          <?php
            while ( have_posts() ) : the_post();
              $post_day = get_the_date( 'j' );
              $post_month = get_the_date( 'M' );
          ?>
            <div class="news-item">
              <div class="image-container">
                <?php 
                  if ( has_post_thumbnail() ) {
                    the_post_thumbnail( 'news-blog-image', array('class' => 'ui shadowed image') );
                  }
                ?>
                <time><span><?php echo $post_day; ?></span><?php echo $post_month; ?></time>
              </div>
              <?php the_title( '<h2 class="ui left header decored">', '</h2>' ); ?>
              <?php the_excerpt(); ?>
              <a href="<?php the_permalink(); ?>" class="ui basic button"><?php esc_html_e('Read more', 'dswp') ?></a>
            </div>
          <?php endwhile; ?>

          <?php dswp_amedical_pagination() ?>
        </div>
      <?php endif; ?>

      <?php get_sidebar(); ?>
    </div>
  </div>
</main>
<?php get_footer(); ?>
<?php
/*
Template Name: Page with sidebar
*/
  get_header();

?>
        <div class="row">
          <div class="small-12 large-8 columns">
              <section class="main-content">
                   <?php while ( have_posts() ) : the_post(); ?>
                       <h1><?php the_title(); ?></h1>
                       <?php the_content(); ?>
                    <?php endwhile;?>
              </section>
          </div>
          <div class="small-12 large-4 columns">
              <?php get_sidebar(); ?>
          </div>
        </div>


<?php get_footer(); ?>

<?php
/*
Template Name: Homepage
*/
  get_header();

?>
     <section>
       <div class="row">
         <div class="small-12 columns">
             <div class="main-slider">
                    <?php get_template_part('includes/parts/slider'); ?>
              </div>
        </div>
      </div>
     </section>
     <section>
          <div class="row">
            <!-- MAIN CONTENT-->
            <div class="small-12 columns">
             <?php while ( have_posts() ) : the_post(); ?>
                 <?php the_content(); ?>
              <?php endwhile;?>


            </div>

          </div>
        </section>

  <?php get_footer(); ?>

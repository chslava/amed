<?php
/*
Template Name: Contacts
*/
get_header();

?>
   <section>
        <div class="row">
          <!-- MAIN CONTENT-->
          <div class="vc-content small-12 medium-8 columns">
           <?php while ( have_posts() ) : the_post(); ?>
               <?php the_content(); ?>
            <?php endwhile;?>
          </div>

        </div>
      </section>

<?php get_footer(); ?>

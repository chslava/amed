<?php
//news opened
get_header();

?>

<!-- CONTENT-->
     <section>
        <div class="row">
          <!-- MAIN CONTENT-->
         <div class="vc-content small-12 medium-8 columns">
			<?php while ( have_posts() ) : the_post(); ?>
        <article>
          <h1> <?php the_title(); ?></h1>
	       <?php the_content(); ?>
        </article>
			<?php endwhile;?>
          </div>
          <!-- SIDEBAR-->
      <!--  <aside class="sidebar small-12 medium-4 columns">
            <?php get_sidebar(); ?>
          </aside> -->
        </div>
      </section>




<?php get_footer(); ?>

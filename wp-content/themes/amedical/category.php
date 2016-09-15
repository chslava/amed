<?Php

get_header(); 
$id = $wp_query->get_queried_object_id();
$permalink= get_category_link($id);
$object_type="category_".$id;

?>
<section>
   <div class="row">
	  <div class="small-12 medium-8 columns">
	  <?php if ( have_posts() ) : ?>

      				<?php while ( have_posts() ) : the_post(); ?>
      					<h1><?php the_title(); ?></h1>
      					<?php the_content(); ?>
      				<?php endwhile; ?>

      			<?php endif;?>
	  </div>
	  <aside class="sidebar small-12 medium-4 columns">
		 <?php get_sidebar( 'right' ); ?>
	  </aside>
   </div>
   <?php get_footer(); ?>
   
</section>
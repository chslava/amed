<?php
//news opened
get_header();

?>

<main class="ui container page">
  <div class="ui breadcrumb"><a class="section" href="index.html">Sākums</a>
    <div class="divider">//</div>
    <div class="active section">Content</div>
  </div>
  <div class="ui grid">
			<?php while ( have_posts() ) : the_post(); ?>
          <h1> <?php the_title(); ?></h1>
	       <?php the_content(); ?>
			<?php endwhile;?>
    </div>
</main>

<?php get_footer(); ?>

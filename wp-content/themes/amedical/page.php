<?php
//page
get_header();

?>

<main class="ui container page">
    <?php include_once('includes/parts/breadcrumbs.php');?>
    <div class="ui grid content-page">
        <?php while ( have_posts() ) : the_post(); ?>
            <h1> <?php the_title(); ?></h1>
            <?php the_content(); ?>
        <?php endwhile;?>
    </div>
</main>

<?php get_footer(); ?>

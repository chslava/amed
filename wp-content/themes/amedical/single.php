<?php
//news opened
get_header();
add_filter('wpseo_breadcrumb_single_link' ,'timersys_remove_links', 10 ,2);
?>

<?php while ( have_posts() ) : the_post(); ?>
<main class="ui container page about-us">
    <?php include_once('includes/parts/breadcrumbs.php');?>
    <div class="ui grid">
        <div class="ui row">
            <div class="sixteen wide mobile eight wide tablet eight wide computer column">
                <h1 class="ui left header decored"><?php the_title(); ?></h1>
                <?php the_content(); ?>
            </div>
            <div class="sixteen wide mobile eight wide tablet eight wide computer column">
              <a href="<?php the_post_thumbnail_url(); ?>">
                <?php the_post_thumbnail(); ?>
              </a>
            </div>
        </div>
    </div>
</main>

<?php endwhile;?>
<?php get_footer(); ?>

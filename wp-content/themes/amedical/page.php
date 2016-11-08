<?php
//page
get_header();

?>

<main class="ui container page content-page">
    <?php include_once('includes/parts/breadcrumbs.php');?>
    <div class="ui grid">
        <div class="ui row">
            <div class="sixteen wide mobile eight wide tablet eight wide computer column">
                <h1 class="ui left header decored"><?php the_title(); ?></h1>
                <?Php the_content(); ?>
            </div>
            <div class="sixteen wide mobile eight wide tablet eight wide computer column">
                <?php the_post_thumbnail(); ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>

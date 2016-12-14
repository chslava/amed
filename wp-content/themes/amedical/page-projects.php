<?php
/*
Template Name: Projects
*/
get_header();

?>
<?php while ( have_posts() ) : the_post(); ?>
    <main class="ui container projects page">
        <?php include_once('includes/parts/breadcrumbs.php');?>
        <div class="ui grid">
            <div class="ui row">
                <div class="sixteen wide mobile sixteen wide tablet eight wide computer column">
                    <h1 class="ui left header decored"><?php the_title(); ?></h1>
                    <?php $page_title = get_the_title(); ?>
                    <?php the_content(); ?>
                </div>
                <div class="sixteen wide mobile sixteen wide tablet eight wide computer column">
                    <?php the_post_thumbnail("service-side-content-image",array("class"=>"ui shadowed centered image", 'id'=>"projects-image")); ?>
                </div>
            </div>
        </div>
    </main>
    <?php $counter=0; ?>
    <?php while(have_rows("designing_content")): the_row(); ?>

        <section class="secondary-services">
            <div class="ui container">
                <h2 class="ui header centered decored"><?php the_sub_field("title"); ?></h2>
                <div class="ui stackable grid" id="service-image-container">
                    <div class="center aligned sixteen wide tablet ten wide desktop centered column">
                        <p><?php the_sub_field("content"); ?></p>
                    </div>
                </div>
                <div class="ui two wide tablet three wide desktop row" id="service-images">
                    <?php while(have_rows("images")): the_row(); ?><?php $image = get_sub_field("image"); ?><img src="<?php print($image['sizes']['services-images']); ?>" /><?php endwhile; ?>
                </div>
            </div>
        </section>


    <?php endwhile; ?>

    <section class="ui container" id="services-additional">
        <div class="ui grid">
            <!-- added classes .stretched very padded row-->
            <div class="ui stretched very padded row">
                <div class="sixteen wide mobile sixteen wide tablet ten wide computer column">
                    <?php if (get_field("cta_block_title")): ?>
                        <h2 class="ui left header decored">
                            <?php the_field("cta_block_title"); ?>
                        </h2>
                        <?php the_field("cta_block_text"); ?>
                    <?php endif; ?>
                </div>

                <div class="sixteen wide mobile sixteen wide tablet six wide computer column">
                    <div class="ui raised center aligned padded segment" id="services-cta">
                        <h3 class="title padded large">
                            <?php the_field("cta_block_tagline"); ?>
                        </h3>
                        <p>
                            <a class="ui basic fluid button" href="<?php the_field("cta_block_link"); ?>?<?php print(sanitize_title($page_title)); ?>">
                                <?php the_field("cta_block_button"); ?>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>



<?php endwhile;?>



<?php get_footer(); ?>

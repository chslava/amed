<?php
/*
Template Name: Services
*/
get_header();

?>
<?php while ( have_posts() ) : the_post(); ?>
    <main class="ui container service page content-page">
        <?php include_once('includes/parts/breadcrumbs.php');?>
            <div class="ui grid">
                <div class="ui row">
                    <div class="sixteen wide mobile eight wide tablet eight wide computer column">
                        <h1 class="ui left header decored"><?php the_title(); ?></h1>
                        <?Php the_content(); ?>
                    </div>
                    <div class="sixteen wide mobile eight wide tablet eight wide computer column">
                        <?php the_post_thumbnail("service-side-content-image",array("class"=>"ui shadowed centered image")); ?>
                    </div>
                </div>
                <div class="stretched very padded row">

                    <div class="sixteen wide mobile eight wide tablet eleven wide computer column">

                        <h2 class="ui left header decored"><?php the_field("service_title"); ?></h2>
                        <?php the_field("service_content"); ?>

                        <div class="ui basic compact segment">
                            <h3 class="large"><?php the_field("service_cta_text"); ?></h3>
                            <p>
                                <a class="ui basic fluid button" href="<?php the_field("service_cta_button_link"); ?>">
                                    <?php the_field("service_cta_button_text"); ?>
                                </a>
                            </p>
                        </div>

                    </div>
                    <div class="sixteen wide mobile eight wide tablet five wide computer column">
                        <div class="ui raised center aligned padded segment">
                            <div class="benefits-icon icon-service-phone-icon"></div>
                            <div class="large title"><?php the_field("service_phone_title"); ?></div>
                            <div class="large title"><?php the_field("service_phone"); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </main>


    </main>

<?php endwhile;?>



<?php get_footer(); ?>

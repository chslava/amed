<?php
/*
Template Name: Services
*/
get_header();

?>
<?php while ( have_posts() ) : the_post(); ?>
    <main class="ui container service page">
        <?php include_once('includes/parts/breadcrumbs.php');?>
            <div class="ui grid">
                <div class="ui row">
                    <div class="sixteen wide mobile sixteen wide tablet nine wide computer column">
                        <h1 class="ui left header decored"><?php the_title(); ?></h1>
                        <?Php $content = apply_filters('the_content', get_the_content()); ?>
                        <?php $content = str_replace("<p>",'<p class="service-text">',$content);?>
                        <?= $content; ?>
                    </div>
                    <div class="sixteen wide mobile sixteen wide tablet seven wide computer column">
                        <?php the_post_thumbnail("service-side-content-image",
                            array("class"=>"ui shadowed centered image", id=>"service-image")); ?>
                    </div>
                </div>

                <div class="stretched very padded row" id="service-details">

                    <div class="sixteen wide mobile sixteen wide tablet eleven wide computer column">

                        <h2 class="ui left header decored"><?php the_field("service_title"); ?></h2>
                        <?= apply_filters("the_content",get_field("service_content")); ?>


                        <div class="ui basic compact segment" id="service-cta">
                            <h3 class="large"><?php the_field("service_cta_text"); ?></h3>
                            <p>
                                <a class="ui basic fluid button"
                                   id="service-cta-button"
                                   href="<?php the_field("service_cta_button_link"); ?>">
                                    <?php the_field("service_cta_button_text"); ?>
                                </a>
                            </p>
                        </div>

                    </div>

                    <div class="sixteen wide mobile sixteen wide tablet five wide computer column">
                        <div class="ui raised center aligned padded segment" id="service-phone">
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

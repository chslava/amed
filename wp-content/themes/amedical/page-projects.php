<?php
/*
Template Name: Projects
*/
get_header();

?>
<?php while ( have_posts() ) : the_post(); ?>
    <main class="ui container projects page content-page">
        <?php include_once('includes/parts/breadcrumbs.php');?>
        <div class="ui grid">
            <div class="ui row">
                <div class="sixteen wide mobile eight wide tablet eight wide computer column">
                    <h1 class="ui left header decored"><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </div>
                <div class="sixteen wide mobile eight wide tablet eight wide computer column">
                    <?php the_post_thumbnail(); ?>
                </div>
            </div>
        </div>
    </main>
    <?php $counter=0; ?>
    <?php while(have_rows("designing_content")): the_row(); ?>
        <section class="secondary-services">
            <div class="ui container">

                <h2 class="ui header centered decored">
                  <?php the_sub_field("title"); ?>
                </h2>

                <div class="ui grid">
                    <div class="center aligned ten wide centered column">
                       <p><?php the_sub_field("content"); ?></p>
                    </div>
                    <?php $counter=0; ?>
                    <?php while(have_rows("images")): the_row(); ?>

                        <?php if ($counter%3==0): ?>
                            <div class="three column row">
                        <?php endif; ?>

                        <?php $image = get_sub_field("image"); ?>

                        <img class="ui image column" src="<?php print($image['sizes']['services-images']); ?>" />

                        <?php if ($counter%3==2): ?>
                            </div>
                        <?php endif; ?>
                        <?php $counter++; ?>
                    <?php endwhile; ?>

                    <?php if ($counter%3<2 && $counter>0): ?>
                        </div>
                    <?php endif; ?>

            </div>
            </div>
        </section>

    <?php endwhile; ?>



    <?php if (get_field("cta_block_title")): ?>
        <section class="ui container very padded">
            <div class="ui grid">
                <div class="ui stretched row">
                    <div class="sixteen wide mobile eight wide tablet ten wide computer column">
                        <h2 class="ui left header decored">
                            <?php the_field("cta_block_title"); ?>
                        </h2>
                        <?php the_field("cta_block_text"); ?>
                    </div>
                    <div class="sixteen wide mobile eight wide tablet six wide computer column">
                        <div class="ui raised center aligned padded segment">
                            <h3 class="title padded large">
                                <?php the_field("cta_block_tagline"); ?>
                            </h3>
                            <p>
                                <a class="ui basic fluid button" href="<?php the_field("cta_block_link"); ?>">
                                    <?php the_field("cta_block_button"); ?>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>


<?php endwhile;?>



<?php get_footer(); ?>

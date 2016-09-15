<?php if (have_rows("slider_items")): ?>
    <section class="slider">
        <div>
            <ul class="main-slider">
                <?php $counter=0; ?>
                <?php while (have_rows('slider_items')): ?>
                    <?php the_row(); ?>
                    <?php $counter++ ?>
                    <li>
                        <?php $image = get_sub_field('slide_image'); ?>
                        <img src="<?php print($image['sizes']['slide-big']); ?>" />
                        <div class="content">
                            <div class="ui container centered grid">
                                <div class="fourteen wide mobile thirteen wide computer column">
                                    <?php if ($counter>1): ?>
                                        <h2><?php the_sub_field("slide_text"); ?></h2>
                                    <?php else: ?>
                                        <h1><?php the_sub_field("slide_text"); ?></h1>
                                    <?php endif; ?>

                                    <?php if (get_sub_field("slide_cta_link") && get_sub_field("slide_cta_text")): ?>
                                        <a class="ui huge primary button" href="<?php print(get_sub_field("slide_cta_link")); ?>">
                                            <?php the_sub_field("slide_cta_text"); ?>
                                            <i class="long arrow right icon">
                                            </i>
                                        </a>
                                    <?php endif; ?>


                                </div>
                            </div>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </section>
<?php endif; ?>


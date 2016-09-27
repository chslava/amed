<?php if (have_rows("slider_items")): ?>

    <section class="slider">
        <div class="ui container grid">
            <div class="column">
                <ul class="main-slider">
                    <?php $counter=0; ?>
                    <?php while (have_rows('slider_items')): ?>
                        <?php the_row(); ?>
                        <?php $counter++ ?>
                        <?php $image = get_sub_field('slide_image'); ?>
                        <li style="background-image: url(<?php print($image['sizes']['slide-big']); ?>)">
                            <div class="content">
                                <?php if ($counter>1): ?>
                                    <h2><?php the_sub_field("slider_text"); ?></h2>
                                <?php else: ?>
                                    <h1><?php the_sub_field("slider_text"); ?></h1>
                                <?php endif; ?>

                                <?php if (get_sub_field("slide_cta_link") && get_sub_field("slide_cta_text")): ?>
                                    <a class="ui primary button" href="<?php print(get_sub_field("slide_cta_link")); ?>">
                                        <?php the_sub_field("slide_cta_text"); ?>
                                        <i class="long arrow right icon"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </li>

                    <?php endwhile; ?>
                </ul>
            </div>
        </div>
    </section>

<?php endif; ?>

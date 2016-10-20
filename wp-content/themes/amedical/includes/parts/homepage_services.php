<section class="services">
    <div class="ui container">
        <div class="ui three columns grid">
            <?php if (have_rows("service_items")): ?>
                <?php while(have_rows("service_items")): ?>
                    <?php the_row(); ?>
                    <div class="sixteen wide mobile five wide computer column">
                        <h3 class="ui header"><?php the_sub_field("service_name"); ?></h3>
                        <p>
                            <?php print(strip_tags(get_sub_field("service_text"),'<a><br><strong><b><i>')); ?>
                        </p>
                        <?php if (get_sub_field("service_link") && get_sub_field("service_cta_text")): ?>
                            <a class="ui basic button" href="<?php the_sub_field("service_link"); ?>">
                                <?php the_sub_field("service_cta_text"); ?>
                                <i class="long arrow right icon"></i>
                            </a>
                        <?php endif; ?>

                    </div>


                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
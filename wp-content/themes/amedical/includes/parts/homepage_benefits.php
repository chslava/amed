<?php $benefit_title = get_field("benefit_title"); ?>
<?php $benefit_text = get_field("benefit_text"); ?>

<?php if (have_rows("benefit_items")): ?>
    <section class="benefits ui container">
        <div class="ui grid">
            <div class="sixteen wide column">
                <h2 class="ui header centered decored"><?php print($benefit_title); ?></h2>
                <p class="content">
                    <?php print(strip_tags($benefit_text)); ?>
                </p>
            </div>
            <div class="ui stretched row">
                <?php while(have_rows("benefit_items")): ?>
                    <?php the_row(); ?>
                    <div class="sixteen wide centered mobile eight wide tablet four wide computer column">
                        <div class="ui raised segment">
                            <div class="benefits-icon <?php the_sub_field("benefit_item_icon"); ?>"></div><strong><?php the_sub_field("benefit_item_title"); ?></strong>
                            <p><?php the_sub_field("benefit_item_text"); ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>

            </div>
        </div>
    </section>
<?php endif; ?>



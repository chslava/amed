
<section class="represent ui container very padded">
    <h2 class="ui centered header centered decored">
        <?php the_field("we_represent_title"); ?>
    </h2>
    <div class="ui six column center aligned grid">
        <ul class="represent-slider">
            <?php if (have_rows("we_represent_bramd_items")): ?>
                <?php while(have_rows("we_represent_bramd_items")): ?>
                    <?php the_row(); ?>
                    <li>
                        <?php $image=get_sub_field("brand_logo"); ?>
                        <img src="<?php print($image['sizes']['brand-logo']); ?>" />
                    </li>
                <?php endwhile; ?>
            <?php endif; ?>
        </ul>
        <div class="center aligned row">
            <a class="ui primary button" href="<?php the_field("we_represent_link"); ?>"><?php the_field("we_represent_cta"); ?>
                <i class="long arrow right icon"></i>
            </a>
        </div>
    </div>
</section>
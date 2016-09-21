
<section class="represent ui container very padded">
    <h2 class="ui centered header centered decored">
        <?php the_field("we_represent_title"); ?>
    </h2>
    <div class="ui six column center aligned grid">
        <ul class="represent-slider">
            <?php if (have_rows("we_represent_bramd_items")): ?>
                <?php
                $represent_params = array(
                    'post_type' => 'partner'
                );
                $represent_q= new WP_Query( $represent_params );

                if ( $represent_q->have_posts() ) {
                    // The 2nd Loop
                    while ( $represent_q->have_posts() ) :

                        $represent_q->the_post();
                        if (has_post_thumbnail()):
                            ?>
                            <li>
                                <?php the_post_thumbnail("brand-logo") ?>
                            </li>
                            <?php
                        endif;

                    endwhile;

                    // Restore original Post Data
                    wp_reset_postdata();
                }
                ?>
                <?php while(have_rows("we_represent_bramd_items")): ?>
                    <?php the_row(); ?>

                <?php endwhile; ?>
            <?php endif; ?>
        </ul>
<!--        <div class="center aligned row">-->
<!--            <a class="ui primary button" href="--><?php //the_field("we_represent_link","option"); ?><!--">--><?php //the_field("we_represent_cta","option"); ?>
<!--                <i class="long arrow right icon"></i>-->
<!--            </a>-->
<!--        </div>-->
    </div>
</section>
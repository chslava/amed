<section class="represent ui container very padded">
    <h2 class="ui centered header centered decored">
        <?php the_field("we_represent_title"); ?>
    </h2>
    <div class="ui six column center aligned grid">
        <ul class="represent-slider">
            <?php
                $represent_params = array(
                    'post_type' => 'partner',
                    'posts_per_page' => -1
                );
                $represent_q= new WP_Query( $represent_params );
                if ( $represent_q->have_posts() ) :
                    while ( $represent_q->have_posts() ) :
                        $represent_q->the_post();
                            if ( has_post_thumbnail() && get_field('show_on_homepage') ): ?>
                                <li>
                                    <?php the_post_thumbnail(); ?>
                                </li>
                            <?php endif; 
                    endwhile;
                    wp_reset_postdata();
                endif; ?>
        </ul>
        <?php if(get_field('we_represent_link') && get_field('we_represent_cta')): ?>
            <div class="center aligned row">
                <a id="we-represent-button" class="ui primary button" href="<?php the_field('we_represent_link'); ?>">
                    <?php the_field('we_represent_cta'); ?>
                    <i class="long arrow right icon"></i>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>
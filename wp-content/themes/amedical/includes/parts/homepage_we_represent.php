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
                if ( $represent_q->have_posts() ) {
                    while ( $represent_q->have_posts() ) :
                        $represent_q->the_post();
                            $partner_logo = get_field('partner_logo'); ?>
                            
                            <?php if ($partner_logo): ?>
                                <li>
                                    <img src="<?php echo $partner_logo['sizes']['brand-logo']; ?>">
                                </li>
                            <?php else: ?>
                                <?php if (has_post_thumbnail()): ?>
                                    <li>
                                        <?php the_post_thumbnail("brand-logo") ?>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <?php
                    endwhile;
                    wp_reset_postdata();
                }
                ?>
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
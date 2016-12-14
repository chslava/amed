<?php
// the query
$args =array();
$args['posts_per_page']=2;
$the_query = new WP_Query( $args ); ?>

<?php if ( $the_query->have_posts() ) : ?>



<section class="home-news">
    <div class="ui container">
        <h2 class="ui centered header centered decored"><?php _e('News / Blog','amedical'); ?></h2>
        <div class="ui grid">
                <!-- the loop -->
                <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <div class="sixteen wide mobile eight wide computer column">
                        <?php if (has_post_thumbnail()): ?>
                            <div class="image-container">
                                <?php the_post_thumbnail("homepage-blog-image"); ?>
                                <time>
                                    <span><?php the_date("d"); ?></span>
                                    <?php print(get_the_date("M")); ?>
                                </time>
                            </div>
                        <?php endif; ?>
                        <h3 class="ui header"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p>
                            <?php print(strip_tags(get_the_excerpt())); ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php _e("Read more",'amedical'); ?>
                                <i class="long right arrow icon"></i>
                            </a>
                        </p>
                    </div>
                <?php endwhile; ?>
                <!-- end of the loop -->

                <!-- pagination here -->

                <?php wp_reset_postdata(); ?>






        </div>

        <div class="aligned center view-all visibility-hidden">
            <?php $news_page_id = get_option('page_for_posts'); ?>
            <a id="all-news" class="ui primary button" href="<?php the_permalink($news_page_id); ?>">
                <?php _e("View all articles",'amedical'); ?>
                <i class="long right arrow icon"></i>
            </a>
        </div>

    </div>
</section>

<?php else : ?>

<?php endif; ?>

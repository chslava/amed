<?php
/**
 * The template file for display single posts A.Medical Theme.
 * @package amedical
 * @author Eugene Kudriashov
 */
get_header();
?>
<main class="ui container news-page page">
    <?php get_template_part( 'includes/parts/breadcrumbs' ); ?>
    <div class="ui grid">
        <div class="ui row">
            <?php while ( have_posts() ) : the_post(); ?>
                <div class="sixteen wide mobile sixteen wide tablet eleven wide computer column" id="news-block-<?php the_ID(); ?>">
                    <div class="news-item news-item-open">
                        <?php the_title( '<h2 class="ui left header decored">', '</h2>' ); ?>
                        <?php 
                            if ( has_post_thumbnail() ) {
                                the_post_thumbnail( 'news-blog-image-open', array('class' => 'ui shadowed image') );
                            }
                        ?>
                        <div class="news-img-footer">
                            <span>
                                <?php
                                    esc_html_e( 'Date: ', 'dswp' );
                                    echo get_the_date( 'd.m.Y' );
                                ?>
                            </span>
                            <?php
                                $post_categories = get_the_category_list(', ');
                                if ( $post_categories ) : ?>
                                <span>
                                    <?php
                                        esc_html_e( 'Categories: ', 'dswp' );
                                        echo $post_categories;
                                    ?>
                                </span>
                            <?php endif; ?> 
                        </div>
                        
                        <hr>
                        
                        <div class="news-content">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <?php
                        $post_gallery = get_field( 'post_gallery_imgs' );
                        if( $post_gallery ) : ?>

                            <div class="photo-gallery-container">
                                <?php if( get_field( 'post_gallery_title' ) ) : ?>
                                    <h2><?php the_field( 'post_gallery_title' ); ?></h2>
                                <?php endif; ?>
                                <div class="photo-gallery">
                                    <?php foreach( $post_gallery as $image ): ?>
                                        <img src="<?php echo $image['sizes']['news-gallery-thumb']; ?>">
                                    <?php endforeach; ?> 
                                </div>
                            </div>
                    <?php endif; ?>

                    <?php if( have_rows('related_posts') ): ?>
                        <div class="related-articles-container">
                            <?php if( get_field( 'related_section_title' ) ) : ?>
                                <h2 class="ui header left decored"><?php the_field( 'related_section_title' ); ?></h2>
                            <?php endif; ?>
                            <div class="ui grid related-articles">   
                                <?php while ( have_rows('related_posts') ) : the_row();
                                    $post = get_sub_field('related_post');
                                    setup_postdata( $post );
                                    $rel_post_day = get_the_date( 'j' );
                                    $rel_post_month = get_the_date( 'M' );
                                ?>
                                <div class="sixteen wide mobile eight wide computer column">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <div class="image-container">
                                            <?php the_post_thumbnail( 'services-images' ); ?>
                                            <time><span><?php echo $rel_post_day; ?></span> <?php echo $rel_post_month; ?></time>
                                        </div>
                                    <?php endif; ?>
                                    <h3 class="ui header">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <?php the_excerpt(); ?>
                                    <a href="<?php the_permalink(); ?>" class="ui basic button"><?php esc_html_e('Read more', 'dswp') ?></a>
                                </div>
                                <?php wp_reset_postdata(); ?>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
            <?php get_sidebar(); ?>
        </div>
    </div>
</main>
<?php get_footer(); ?>

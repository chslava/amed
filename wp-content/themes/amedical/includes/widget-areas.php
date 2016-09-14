<?php
if ( ! function_exists( 'dswp_sidebar_widgets' ) ) :
function dswp_sidebar_widgets()
{
	register_sidebar(array(
	  'id' => 'main-sidebar',
	  'name' => __( 'Sidebar widgets', 'dswp' ),
	  'description' => __( 'Drag widgets to this sidebar container.', 'dswp' ),
	  'before_widget' => '<article id="%1$s" class="widget %2$s">',
	  'after_widget' => '</article>',
	  'before_title' => '<h6>',
	  'after_title' => '</h6>',
	));
}
add_action( 'widgets_init', 'dswp_sidebar_widgets' );
endif;






/* widget */
class CustomWidget extends WP_Widget
{

	function CustomWidget() {
		// Instantiate the parent object
		parent::__construct( false, 'Description' );
	}

	function widget( $args, $instance )
    {


      //print_r($instance);
      $category = $instance['category'];

		$offers = get_special_offers($category);
		if (count($offers)>0)
		{
		?>
		<!-- SPECIAL OFFERS-->
		<section class="special-offers mt-md">
			<div class="row">
                <div class="small-12 columns text-center">
                    <h2 class="title-primary"><a href="<?Php get_special_offers_url(); ?>"><?Php _e('Special Offers','dswp'); ?></a></h2>
                </div>
			</div>
            <div class="row">
                <div class="js-carousel--content-items carousel--content">
				<?Php

				  $offers_count=0;
				  foreach($offers as $offer)
				  {

					print(get_special_offer_item_html($offer,$offers_count));
					$offers_count++;
				  }
				?>
                </div>
            </div>
        </section>
		<?Php
        }

	}

	function update( $new_instance, $old_instance ) {
		// Save widget options
		return $new_instance;
	}

	function form( $instance ) {
		/*
        $category = $instance['category'];
        ?>
			<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php _e( 'Title:' ); ?>
			</label>
			<!--<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />-->
            <?php
                    $categories = get_terms('special_offer_category');
                    ///print("<pre>");
                    //print("-->");
                    //print_r($categories);
                    //print("<--");
                    //print("</pre>");
            ?>
            <label for="<?php echo $this->get_field_id( 'category' ); ?>">
				<?php _e( 'Category:' ); ?>
			</label>
            <select name="<?php echo $this->get_field_name('category'); ?>" id="<?php echo $this->get_field_id( 'category' ); ?>">
                <option value="0">Any - Random</option>
                <?Php

                    foreach($categories as $cat_item)
                    {

                        if (esc_attr( $category )==$cat_item->term_id)
                        {
                            ?>
                            <option selected="selected" value="<?Php print($cat_item->term_id); ?>">
                                <?php print($cat_item->name); ?>
                            </option>
                            <?Php
                        }
                        else
                        {
                            ?>
                            <option value="<?Php print($cat_item->term_id); ?>">
                                <?php print($cat_item->name); ?>
                            </option>
                            <?Php
                        }



                    }

                ?>
            </select>

		<?Php */
	}
}

function CustomWidget_register_widgets() {
	register_widget( 'CustomWidget' );
}

add_action( 'widgets_init', 'CustomWidget_register_widgets' );

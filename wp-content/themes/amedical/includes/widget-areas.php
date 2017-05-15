<?php
if ( ! function_exists( 'dswp_sidebar_widgets' ) ) :
function dswp_sidebar_widgets()
{
	register_sidebar(array(
	  'id' => 'main-sidebar',
	  'name' => __( 'Sidebar widgets', 'dswp' ),
	  'description' => __( 'Drag widgets to this sidebar container.', 'dswp' ),
	  'before_widget' => '',
	  'after_widget' => '',
	  'before_title' => '<h3 class="ui header">',
	  'after_title' => '</h3>',
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

/**
* Custom Subcategories Sidebar Widget for AMedical Theme
* @author: Eugene Kudriashov
*/
class amedical_sub_categories_widget extends WP_Widget {

	function __construct() {
		parent::__construct('amedical_sub_categories_widget', __('Amedical sub-categories', 'dswp'), array('classname' => 'widget_sub_categories', 'description' => __('Output list of sub-categories for a selected category.', 'dswp')));
	}

	function widget($args, $instance) {

		extract($args, EXTR_SKIP);

		$category_id = empty($instance['category_id']) ? 1 : $instance['category_id'];
		$title = apply_filters('widget_title', empty($instance['title'] ) ? __('Sub Categories', 'dswp') : $instance['title'], $instance, $this->id_base);
		$no_sub_text = '<p>'.__('No sub-categories', 'dswp').'</p>';
		$subs = get_categories(array('child_of' => $category_id));

		echo $before_widget;
		echo $before_title.$title.$after_title;
		
		if (!empty($subs)) {
			echo '<ul class="simple-list">';
			$highlight_first = true;
			foreach( $subs as $sub ) {
				echo '<li'.(($highlight_first)?' class="current"':" ").'><a href="' . get_category_link( $sub->term_id ) . '">' . $sub->name.'</a><li>';
				$highlight_first = false;
			}
			echo '</ul>';
		} else {
			echo $no_sub_text;
		}

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {

		$instance = $old_instance;

		$instance['title'] = sanitize_text_field($new_instance['title']);
		$instance['category_id'] = (int) $new_instance['category_id'];

		return $instance;
	}

	function form($instance) {

		$instance = wp_parse_args((array) $instance, array('title' => __('Sub Categories', 'sub-categories-widget'), 'category_id' => 1));

		?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'sub-categories-widget'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']) ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('category_id'); ?>"><?php _e('Parent category:', 'sub-categories-widget'); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id('category_id'); ?>" name="<?php echo $this->get_field_name('category_id'); ?>">
					<?php
						$categories = get_categories(array('hide_empty' => 0));
						foreach ($categories as $cat) {
							$selected = $cat->cat_ID == $instance['category_id'] ? ' selected="selected"' : '';
							echo '<option'.$selected.' value="'.$cat->cat_ID.'">'.$cat->cat_name.'</option>';
						}
					?>
				</select>
			</p>
		<?php
	}
}
add_action('widgets_init', create_function('', 'return register_widget("amedical_sub_categories_widget");'));

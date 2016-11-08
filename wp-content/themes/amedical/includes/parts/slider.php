<?php
$the_query = new WP_Query(array(
	'post_type' => 'slider'));

// The Loop
if ( $the_query->have_posts() ) {
	echo '<div class="slider">';
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
      if ( has_post_thumbnail() ) {
        echo '<div class="slide">';
        the_post_thumbnail();
     echo get_the_title();
     echo get_the_content();
     echo '</div>';
	   }
  }
	echo '</div>';
} else {
  echo 'No sliders found';
}
/* Restore original Post Data */
wp_reset_postdata();
?>

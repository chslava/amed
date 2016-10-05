<?php
/*
Template Name: Contacts
*/
get_header();

?>

<main class="contacts">
  <div class="ui container">
      <div class="ui grid">
          <div class="sixteen wide mobile eight wide tablet five wide computer column">

              <?php include_once('includes/parts/breadcrumbs.php'); ?>

              <h1 class="ui header"><?php echo get_the_title(); ?></h1>
              <p><?php echo the_field('address_title','option'); ?>: <?php echo the_field('address','option'); ?></p>
              <p><?php echo the_field('phone_title','option'); ?>:
                  <a href="tel:<?php echo the_field('phone','option'); ?>">
                    <?php echo the_field('phone','option'); ?>
                  </a>,
                  <a href="tel:<?php echo the_field('phone-2','option'); ?>">
                      <?php echo the_field('phone-2','option'); ?>
                  </a>
              </p>
              <p><?php echo the_field('fax_title','option'); ?>: <?php echo the_field('fax','option'); ?></p>
              <p><?php echo the_field('email_title','option'); ?>: <a href="mailto:<?php echo the_field('email','option'); ?>"><?php echo the_field('email','option'); ?></a></p>
              <p><?php echo the_field('opening_hours_title','option'); ?>: <?php echo the_field('opening_hours','option'); ?></p>
              <div class="ui divider"></div>
              <h2 class="ui header"><?php echo the_field('title_registration','option'); ?></h2>
              <p><?php echo the_field('registration_name','option'); ?></p>
              <p><?php echo the_field('registration_no','option'); ?></p>
              <p><?php echo the_field('registration_address','option'); ?></p><br>
              <p><?php echo the_field('bank_name','option'); ?></p>
              <p><?php echo the_field('bank_account','option'); ?></p>
              <p><?php echo the_field('bank_code','option'); ?></p>
        </div>
    </div>
  </div>
  <div class="info"></div>

  <div class="map contact-map" data-lat="<?php echo get_field("lat","option"); ?>" data-lng="<?php echo get_field("lng","option"); ?>"></div>


  <script>
    jQuery(function($) {
        var address ='<?php the_field("address","option"); ?>';

    map = new GMaps({
            div: '.contact-map',
            lat:  <?php echo get_field("lat","option"); ?>,
            lng: <?php echo get_field("lng","option"); ?>,
            zoom: 12,
            scrollwheel: false,
            disableDefaultUI: true,
            navigationControl: true,
            mapTypeControl: false,
            scaleControl: true,
            zoomControl:true,
            draggable: false,
            styles: [
                {
                    stylers: [
                        {saturation: -75}
                    ]
                },
                {
                    featureType: "buildings",
                    elementType: "geometry",
                    stylers: [
                        {visibility: "simplified"}
                    ]
                }, {
                    featureType: "road",
                    elementType: "geometry",
                    stylers: [
                        {visibility: "simplified"}
                    ]
                }, {
                    featureType: "road",
                    elementType: "labels",
                    stylers: [
                        {visibility: "simplified"}
                    ]
                }
            ]
        });
        map.setCenter(<?php the_field("lat","option") ?>, <?php the_field("lng","option") ?>);
        var image = {
                 url: '<?php echo get_stylesheet_directory_uri() ;?>/img/marker.png',
                 size: new google.maps.Size(101, 101),
                 origin: new google.maps.Point(0, 0),
                 anchor: new google.maps.Point(50.5, 50.5)
               };
        map.addMarker({
            lat: <?php the_field("lat","option") ?>,
            lng: <?php the_field("lng","option") ?>,
            icon: image
        });


    })
  </script>

</main>

<section class="contact-form">
  <div class="ui container">
    <div class="ui grid">
      <div class="sixteen wide mobile eight wide tablet eight wide computer column">
        <?php if ( have_posts() ) : ?>
  				<?php while ( have_posts() ) : the_post(); ?>
  					<?php the_content(); ?>
  				<?php endwhile; ?>
  			<?php endif;?>
      </div>
      <div class="sixteen wide mobile eight wide tablet eight wide computer column"><?php echo the_post_thumbnail('contact-side-content-image',array( 'class' => 'ui shadowed image' )); ?></div>
    </div>
  </div>
</section>

<?php get_footer(); ?>

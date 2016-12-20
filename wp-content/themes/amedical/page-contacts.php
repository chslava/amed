<?php
/*
Template Name: Contacts
*/
get_header();
add_filter('wpseo_breadcrumb_single_link', 'timersys_remove_links', 10, 2);
?>

<main class="contacts">

    <div class="ui container">

        <div class="sixteen wide mobile sixteen wide tablet five wide computer column">
            <?php include_once('includes/parts/breadcrumbs.php'); ?>
        </div>

        <div class="ui grid">
            <div class="eight wide tablet sixteen wide desktop column contact-address">

                <h1 class="ui header"><?php echo get_the_title(); ?></h1>
                <p><?php echo the_field('address_title', 'option'); ?>
                    : <?php echo the_field('address', 'option'); ?></p>
                <p><?php echo the_field('phone_title', 'option'); ?>:
                    <a href="tel:<?php echo the_field('phone', 'option'); ?>">
                        <?php echo the_field('phone', 'option'); ?>
                    </a>,
                    <a href="tel:<?php echo the_field('phone-2', 'option'); ?>">
                        <?php echo the_field('phone-2', 'option'); ?>
                    </a>
                </p>
                <p><?php echo the_field('fax_title', 'option'); ?>: <?php echo the_field('fax', 'option'); ?></p>
                <p><?php echo the_field('email_title', 'option'); ?>: <a
                        href="mailto:<?php echo the_field('email', 'option'); ?>"><?php echo the_field('email', 'option'); ?></a>
                </p>
                <p><?php echo the_field('opening_hours_title', 'option'); ?>
                    : <?php echo the_field('opening_hours', 'option'); ?></p>
                <div class="ui divider hide-for-tablet"  id="contacts-divider"></div>
            </div>
            <div class="eight wide tablet sixteen wide desktop column contact-details">
                <h2 class="ui header"><?php echo the_field('title_registration', 'option'); ?></h2>
                <p><?php echo the_field('registration_name', 'option'); ?></p>
                <p><?php echo the_field('registration_no', 'option'); ?></p>
                <p><?php echo the_field('registration_address', 'option'); ?></p><br>
                <p><?php echo the_field('bank_name', 'option'); ?></p>
                <p><?php echo the_field('bank_account', 'option'); ?></p>
                <p><?php echo the_field('bank_code', 'option'); ?></p>
            </div>
        </div>
    </div>
    <div class="info"></div>

    <!-- <div class="map contact-map" data-lat="<?php echo get_field("lat", "option"); ?>" data-lng="<?php echo get_field("lng", "option"); ?>"></div> -->

    <div id="map" class="map contact-map"></div>

    <script>
        function initMap() {
            var uluru = {
                lat: <?php echo get_field("lat", "option"); ?>,
                lng: <?php echo get_field("lng", "option"); ?>};
            var map = new google.maps.Map(document.getElementById('map'), {
                center: uluru,
                zoom: 13,
                scrollwheel: false,
                disableDefaultUI: true,
                navigationControl: true,
                mapTypeControl: false,
                scaleControl: true,
                zoomControl: true,
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




            var infowindow = new google.maps.InfoWindow({
                content: document.getElementById("hidden-info").innerHTML
            });

            document.getElementById("hidden-info").style.visibility = "hidden";

            var image = {
                url: '<?php echo get_stylesheet_directory_uri();?>/img/marker.png',
                size: new google.maps.Size(101, 101),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(50.5, 50.5)
            };

            var marker = new google.maps.Marker({
                position: uluru,
                icon: image,
                map: map
            });

            map.addListener('center_changed', function() {
                //pan to marker
                map.panTo(marker.getPosition());

            });


            marker.addListener('click', function () {
                infowindow.open(map, marker);
            });

        }
    </script>

</main>
<div id='hidden-info'><span class='map-info'><?php echo the_field('map_info_window', 'option'); ?><span></div>
<section class="contact-form">
    <div class="ui container">
        <div class="ui grid">
            <div class="sixteen wide mobile sixteen wide tablet eight wide computer column">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <?php the_content(); ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>


            <div
                class="sixteen wide mobile sixteen wide tablet eight wide computer column"><?php echo the_post_thumbnail('contact-side-content-image', array('class' => 'ui shadowed image', 'id'=>'contact-image')); ?></div>
        </div>
    </div>
</section>

<?php get_footer(); ?>

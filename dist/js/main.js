$(function() {
    $('.ui.dropdown').dropdown();

    $('.ui.rating').rating({
        maxRating: 5
    });

    $('.main-slider').bxSlider();

    $('.represent-slider').bxSlider({
        slideWidth: 190,
        minSlides: 2,
        maxSlides: 6,
        moveSlides: 2,
        slideMargin: 0,
        controls: false,
        pager: false,
        infiniteLoop: true,
        auto: true,
        autoControls: false
    });
})


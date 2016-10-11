jQuery(function($) {
    //for wordpress subscription module
    if ($(".mc4wp-notice").length > 0) {
        $('html, body').animate({
            scrollTop: $("#mc4wp-form-1").offset().top
        }, 500);
    }

    $('.menu').on('click', '.ui.dropdown', function(e) {
        if (window.innerWidth <= 992) {
            e.preventDefault();
            $('.ui.dropdown').removeClass('active');
            $(this).addClass('active');
            if ($(this).children('.menu').css('display') == 'block') {
                $(this).children('.menu').hide();
                $(this).removeClass('active');
                return;
            }

            $('.ui.dropdown .menu').hide();
            $(this).children('.menu').slideToggle(200);
        }

    })
    $('select.ui.dropdown').dropdown();

    $('.ui.rating').rating({
        maxRating: 5
    });

    $('.ui.checkbox').checkbox();

    $('.main-slider').bxSlider({
        adaptiveHeight: true,
        infiniteLoop: true,
        auto: true,
        pause: 7000,
        speed: 1000
    });


    if (($(window).width()) < 768) {
        $('.represent-slider').bxSlider({
            moveSlides: 1,
            infiniteLoop: true,
            auto: true,
            pager: false,
            slideMargin: 0,
            autoReload: true
        });
    } else {
        $('.represent-slider').bxSlider({
            slideWidth: 150,
            minSlides: 1,
            maxSlides: 6,
            moveSlides: 1,
            slideMargin: 58,
            pager: false,
            infiniteLoop: true,
            auto: true
        });
    }

    $('.mob-search').on('click', function(e) {
        e.preventDefault();
        $('.search-row').slideToggle();
        if ($('.search-row').css('display') == 'flex') {
            $('.search-row input').focus();
        }
    })
    $('.mob-toogle-menu').on('click', function(e) {
        e.preventDefault();
        $('.mob-menu').slideToggle(200);
        $(this).children('i').toggleClass('icon-mob-toogle-close', 'icon-mob-toogle-open');
        $(this).children('i').toggleClass('icon-mob-toogle-open');
    })
})

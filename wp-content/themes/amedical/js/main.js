$(function() {
    $('.menu').on('click', '.ui.dropdown', function (e) {
        e.preventDefault();
        $('.ui.dropdown').removeClass('active');
        $(this).addClass('active');
        if($(this).children('.menu').css('display')=='block') {
            $(this).children('.menu').hide();
            $(this).removeClass('active');
            return;
        }

        $('.ui.dropdown .menu').hide();
        $(this).children('.menu').slideToggle(200);
    })
    $('select.ui.dropdown').dropdown();

    $('.ui.rating').rating({
        maxRating: 5
    });

    $('.ui.checkbox').checkbox();

    $('.main-slider').bxSlider({
        adaptiveHeight: true
    });

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

    $('.mob-search').on('click', function (e) {
        e.preventDefault();
        $('.search-row').slideToggle();
        if ($('.search-row').css('display') == 'flex') {
            $('.search-row input').focus();
        }
    })
    $('.mob-toogle-menu').on('click', function (e) {
        e.preventDefault();
        $('.mob-menu').slideToggle(200);
        $(this).children('i').toggleClass('icon-mob-toogle-close', 'icon-mob-toogle-open');
        $(this).children('i').toggleClass('icon-mob-toogle-open');
    })
})


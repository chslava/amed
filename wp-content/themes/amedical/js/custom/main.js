jQuery(document).ready(function($) {

    // Mobile menu toggle
    $('.menu-toggle').click(function (e) {
        $(window).scrollTop(0);
        e.preventDefault();
        e.stopPropagation();
        $(this).toggleClass('open');
        $('header').toggleClass('is-pushed-left');
        $('.content-wrapper').toggleClass('is-pushed-left');
        $('footer').toggleClass('is-pushed-left');
        var h = $(document).height();
        $('.navigation-mobile').toggleClass('active').css('height', h);
    });


    // Mobile menu dropdown arrow
    function mobileAccordion() {
        "use strict";

        var nav             = $('.navigation-mobile');
        var allPanels       = nav.find('.sub-menu').hide();

        nav.find('.arrow').on('click', function (e) {
            e.stopPropagation();

            var element     = $(this).parent('li');
            var is_open     = element.hasClass('open');
            var exclude     = element.parentsUntil('.navigation-mobile', $(this).parent('li'));

            allPanels.not(exclude).slideUp(); // close
            nav.find('.open').not(exclude).removeClass('open');

            if(!is_open) {
                element.addClass('open').children('.sub-menu').slideDown();
            }

            return false;
        });
    }

    // Slick slider
    $('.slider').slick({
        infinite: true,
        dots: true,
        lazyLoad: 'progressive',
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        centerMode: true,
        centerPadding: '0',
        variableWidth: false,


        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    arrows: true,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 2,
                    variableWidth: true
                }
            },
            {
                breakpoint: 640,
                settings: {
                    arrows: true,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 1
                }
            }
        ]
    });

    // Initialize functions when document ready
    console.log('document ready');

    mobileAccordion();

    setTimeout("objectFitImages();", 250);





});
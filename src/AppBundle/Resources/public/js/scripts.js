;(() => {
    jQuery(document).ready(function ($) {
            "use strict";
        $('header').css({header: 'background-color: rgba(19, 18, 18, 0.3);'});

            const win = window,
                doc = document,
                body = $('body'),
                bodyHtml = $('html, body'),
                html = $('html'),
                browser = {
                    w: doc.documentElement.clientWidth,
                    h: doc.documentElement.clientHeight
                }, color = {
                    white: '#fff',
                    main: '#05afd1'
                };

            /* Preload */
            {
                let preloader = $('.preloader'),
                    preloadIcon = $('.preloader-icon');
                $(win).on('load', function () {
                    if (preloader.length) {
                        preloadIcon.hide();
                        $('body').removeClass('preload');
                        preloader.delay(200).fadeOut('slow');
                    }
                });
            }


            /* Accordeon */
            {
                let accordeon = $(".accordeon-main"),
                    accordeonActive = $(".accordeon-main.active");

                accordeon.on('click', function (e) {
                    if ($(this).hasClass('active')) {
                        e.preventDefault();
                    }
                    else {
                        accordeon.removeClass('active');
                        $(this).toggleClass('active');
                        accordeon.children('.block-active').html('<i class="fa fa-plus" aria-hidden="true"></i>');
                        $(this).children('.block-active').html('<i class="fa fa-minus" aria-hidden="true"></i>');
                        accordeon.next().slideUp('fast');
                        $(this).next().slideToggle('fast');
                    }
                });
                accordeonActive.on('click', function (e) {
                    e.preventDefault();
                });
            }

            /* Nav Fixed on Scroll */
            {
                if (browser.w >= 992) {
                    $(win).on('scroll', function () {
                        let menu = $('.main-nav');
                        let winOffset = win.pageYOffset;
                        if (winOffset >= 1) {
                            menu.addClass('fixed')
                        } else {
                            menu.removeClass('fixed')
                        }
                    });
                }
            }


            /* Scroll Up Button */
            {

                let body = document.body,
                    html = document.documentElement,
                    bodyHeight = Math.max(body.scrollHeight, body.offsetHeight,
                        html.clientHeight, html.scrollHeight, html.offsetHeight),
                    upArrow = $('.up');

                $(win).on('scroll', function () {
                    let pageOffset = win.pageYOffset;


                    if (pageOffset > bodyHeight / 3) {
                        upArrow.addClass('active');
                    } else {
                        upArrow.removeClass('active');
                    }

                });

                upArrow.on('click', function () {
                    bodyHtml.animate({scrollTop: 0}, 500);
                    return false;
                });
            }


            /* Mobile Menu */
            {
                let menuIcon = $('.menu-icon'),
                    mobileMenu = $('.menu-wrap');
                menuIcon.on('click', function () {
                    $(this).toggleClass('active');
                    mobileMenu.slideToggle(250);
                });

                if (browser.w < 992) {
                    $('.menu-item-has-children > a').on('click', function (e) {
                        e.preventDefault();
                        $(this).siblings($('.sub-menu')).slideToggle('fast').toggleClass('active');
                    });
                }
            }

            /* Stellar Parallax Section */
            {
                if ($('.parallax-section').length && browser.w >= 1024) {
                    $.stellar({
                        horizontalScrolling: false,
                        verticalScrolling: true,
                        horizontalOffset: 0,
                        verticalOffset: 0,
                        responsive: true,
                        parallaxBackgrounds: true,
                    });
                }
            }


            /* Gallery Post */
            {
                let postGallery = $(".post-gallery  ");
                if (postGallery.length) {
                    postGallery.imagesLoaded(function () {
                        postGallery.slick({
                            infinite: true,
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            fade: true,
                            easing: 'ease',
                            nav: true,
                            dots: true,
                            arrows: true,
                            appendDots: postGallery,
                            appendArrows: postGallery,
                            prevArrow: "<div class='prev'><i class='fa fa-angle-left' aria-hidden='true'></i></div>",
                            nextArrow: "<div class='next'><i class='fa fa-angle-right' aria-hidden='true'></i></div>"
                        });
                    });
                }
            }

            /* Masonry Grid */
            {
                let itemsGrid = $('.masonry-grid, .masonry-list');
                if (itemsGrid.length) {
                    itemsGrid.imagesLoaded(function () {
                        itemsGrid.differ({
                            itemSelector: '.item',
                        });
                    });
                }

                $('.filters').on('click', 'li a', function (e) {
                    e.preventDefault();
                    $(".filters li a").removeClass('active');
                    $(this).addClass('active');
                    let filterValue = $(this).attr('data-filter');
                    itemsGrid.differ({filter: filterValue});
                });
            }

            /* Testimonials Slider */
            {
                let testimonialsSldier = $(".testimonials-slider-wrap");
                if (testimonialsSldier.length) {
                    testimonialsSldier.owlCarousel({
                        slideSpeed: 350,
                        navigation: true,
                        loop: true,
                        items: 1,
                        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                    });
                }
            }


            /* Home Ripples Water Effect */
            {
                let ripple = $('.ripple');
                if (ripple.length) {
                    if (typeof $.fn.ripples === 'function') {
                        try {
                            ripple.ripples({
                                resolution: 500,
                                perturbance: 0.01
                            });
                        } catch (e) {
                            $('.error').show().text(e);
                        }
                    }
                }
            }

            /* Home Particlesground */
            {
                let particlesDots = $('#dots-canvas');
                if (particlesDots.length) {
                    particlesDots.particleground({
                        dotColor: 'rgba(50, 175, 210, 0.47)',
                        lineColor: 'rgba(255, 255, 255, 0.4)',
                        particleRadius: 6,
                    });
                }
            }

            /* Home Particles Background */
            {
                if ($('#particles-js').length) {
                    particlesJS.load('particles-js', 'js/libs/particlesjs-config.json', function () {
                    });
                }
            }

            /* Home Parallax Scene */
            {
                let scene = document.querySelector('.scene');
                if (scene) {
                    let parallaxInstance = new Parallax(scene);
                }
            }

            /* Home Background Slider */
            {
                let HomeSlider = $(".header-slider");
                if (HomeSlider.length) {
                    HomeSlider.slick({
                        infinite: true,
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        fade: true,
                        easing: 'linear',
                        nav: true,
                        dots: true,
                        arrows: true,
                        appendDots: HomeSlider,
                        appendArrows: HomeSlider,
                        autoplay: true,
                        autoplaySpeed: 3500,
                        prevArrow: "<div class='prev'><i class='fa fa-angle-left' aria-hidden='true'></i></div>",
                        nextArrow: "<div class='next'><i class='fa fa-angle-right' aria-hidden='true'></i></div>",
                    });
                }
            }

            /* Home Background Video Section */
            {
                let HomeVideo = document.querySelector('.video-bg');
                if (HomeVideo) {
                    webView.mediaPlaybackRequiresUserAction = NO;
                    HomeVideo.addEventListener('load', function () {
                        HomeVideo.play();
                    });
                }
            }

            /* Counters Section */
            {
                $(win).on('load', function () {
                    let countersSection = document.querySelector('.counters');
                    if (countersSection) {
                        let countersCount = $('.counters .item').length;
                        for (let i = 1; i <= countersCount; i++) {

                            let counter = {
                                elem: document.querySelector('#counter' + i),
                                count: document.querySelector('#counter' + i).getAttribute('data-count'),
                                fill: document.querySelector('#counter' + i).getAttribute('data-fill'),
                            };
                            let bar = new ProgressBar.Circle(counter.elem,
                                {
                                    color: color.white,
                                    strokeWidth: 8,
                                    trailWidth: 8,
                                    easing: 'easeInOut',
                                    duration: 1000,
                                    text: {
                                        autoStyleContainer: false
                                    },
                                    from: {color: color.white, width: 8},
                                    to: {color: color.main, width: 8},
                                    // Set default step function for all animate calls
                                    step: function (state, circle) {
                                        circle.path.setAttribute('stroke', state.color);
                                        circle.path.setAttribute('stroke-width', state.width);

                                        let value = Math.round(circle.value() * counter.count);
                                        if (value === 0) {
                                            circle.setText('');
                                        } else {
                                            circle.setText(value);
                                        }

                                    }
                                });

                            let Counterswaypoint = new Waypoint({
                                element: countersSection,
                                handler: function () {
                                    bar.animate(counter.fill / 100);
                                },
                                offset: '90%'
                            })

                        }
                    }
                });
            }

            /* Google Map Settings */
            {
                let mapElem = document.querySelector('.map');
                if (mapElem) {
                    let GoogleMapInit = function () {
                        let map = new google.maps.Map(mapElem, {
                            zoom: 12,
                            center: new google.maps.LatLng(50.436841, 30.372402),
                            scrollwheel: false,
                            styles: [
                                {
                                    "featureType": "administrative",
                                    "elementType": "labels.text.fill",
                                    "stylers": [
                                        {
                                            "color": "#444444"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "landscape",
                                    "elementType": "all",
                                    "stylers": [
                                        {
                                            "color": "#f2f2f2"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "poi",
                                    "elementType": "all",
                                    "stylers": [
                                        {
                                            "visibility": "off"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "road",
                                    "elementType": "all",
                                    "stylers": [
                                        {
                                            "saturation": -100
                                        },
                                        {
                                            "lightness": 45
                                        }
                                    ]
                                },
                                {
                                    "featureType": "road.highway",
                                    "elementType": "all",
                                    "stylers": [
                                        {
                                            "visibility": "simplified"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "road.arterial",
                                    "elementType": "labels.icon",
                                    "stylers": [
                                        {
                                            "visibility": "off"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "transit",
                                    "elementType": "all",
                                    "stylers": [
                                        {
                                            "visibility": "off"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "water",
                                    "elementType": "all",
                                    "stylers": [
                                        {
                                            "color": "#46bcec"
                                        },
                                        {
                                            "visibility": "on"
                                        }
                                    ]
                                }
                            ]
                        });

                        let marker = new google.maps.Marker({
                            position: new google.maps.LatLng(50.436841, 30.372402),
                            map: map,
                            icon: 'http://maps.gstatic.com/mapfiles/api-3/images/spotlight-poi.png',
                            title: 'Petra Chaadajeva St, 2Б, Kyiv, Ukraine, 02000'
                        });


                        let infowindow = new google.maps.InfoWindow({
                            content: 'Petra Chaadajeva St, 2Б, Kyiv, Ukraine, 02000'
                        });

                        google.maps.event.addListener(marker, 'click', (function (marker) {
                            return function () {
                                infowindow.setContent(marker.title);
                                infowindow.open(map, marker);
                            }
                        })(marker));

                    }
                    google.maps.event.addDomListener(window, 'load', GoogleMapInit());
                }
            }

        }
    ); // jQuery doc ready function


$(function () {

    $('form[name="app_bundle_contact"]').on('submit', function (e) {
        if (!e.isDefaultPrevented()) {
            var url = "/api/parents/contacts";

            $.ajax({
                type: "POST",
                url: url,
                data: $(this).serialize(),
                success: function (data)
                {
                    $('form[name="app_bundle_contact"]').css({display:'none'});
                    $('form[name="app_bundle_contact"]').closest('div').append('<h6 class="center">' +
                        'Ваш запрос отправляется успешно. Наши администраторы связаны с вами.' +
                        '<br>Спосибо <b>' + data.name + '</b>'+
                        '</h6>');
                    /*var messageAlert = 'alert-' + data.type;
                    var messageText = data.name;

                    var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable">' +
                        'Ваш запрос отправляется успешно. Наши администраторы связаны с вами в течение 5 мин.' +
                        '<br>Спосибо <b>' + data.name + '</b></div>';
                    if (messageAlert && messageText) {
                        $('.contact-form').find('.messages').html(alertBox);
                        $('.contact-form')[0].reset();
                        $('img.exit').click();
                    }*/
                }
            });
            return false;
        }
    })
});

})();


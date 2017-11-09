/**
  * isMobile
  * responsiveMenu();
  * topSearch();          
  * flatTestimonials_1();
  * flatTestimonials_2();
  * flatTestimonials_3();
  * flatTestimonials_4();
  * flatClient();
  * detectViewport();
  * counter();
  * flatAccordion();
  * tabs();
  * portfolioIsotope();
  * googleMap();
  * CountDown();
  * flatFilterPrice();
  * popupGallery();
  * sectionVideo();         
  * responsiveVideo();
  * swClick(); 
  * parallax();
  * removePreloader();
  * goTop();
*/

;(function($) {

   'use strict'

    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };

	var responsiveMenu = function() {
        var menuType = 'desktop';

        $(window).on('load resize', function() {
            var currMenuType = 'desktop';

            if ( matchMedia( 'only screen and (max-width: 991px)' ).matches ) {
                currMenuType = 'mobile';
            }

            if ( currMenuType !== menuType ) {
                menuType = currMenuType;

                if ( currMenuType === 'mobile' ) {
                    var $mobileMenu = $('#mainnav').attr('id', 'mainnav-mobi').hide();
                    var hasChildMenu = $('#mainnav-mobi').find('li:has(ul)');

                    $('#header').after($mobileMenu);
                    hasChildMenu.children('ul').hide();
                    hasChildMenu.children('a').after('<span class="btn-submenu"></span>');
                    $('.btn-menu').removeClass('active');
                } else {
                    var $desktopMenu = $('#mainnav-mobi').attr('id', 'mainnav').removeAttr('style');

                    $desktopMenu.find('.submenu').removeAttr('style');
                    $('#header').find('.nav-wrap').append($desktopMenu);
                    $('.btn-submenu').remove();
                }
            }
        });

        $('.btn-menu').on('click', function() {         
            $('#mainnav-mobi').slideToggle(300);
            $(this).toggleClass('active');
        });

        $(document).on('click', '#mainnav-mobi li .btn-submenu', function(e) {
            $(this).toggleClass('active').next('ul').slideToggle(300);
            e.stopImmediatePropagation()
        });
    }

    var headerFixed = function() {
        if ( $('body').hasClass('header_sticky2') ) {
            var nav = $('.header');

            if ( nav.size() != 0 ) {
                var offsetTop = $('.header.scroll-head').offset().top,
                    headerHeight = $('.header.scroll-head').height(),
                    injectSpace = $('<div />', { height: headerHeight }).insertAfter(nav);   
                    injectSpace.hide();                 

                $(window).on('load scroll', function(){
                     if ( $(window).scrollTop() > offsetTop + 120 ) {
                         $('.header.scroll-head').addClass('downscrolled');
                     } else {
                         $('.header.scroll-head').removeClass('header-small downscrolled');
                     }

                     if ( $(window).scrollTop() > 500 ) {
                         $('.header.scroll-head').addClass('header-small upscrolled');
                     } else {
                         $('.header.scroll-head').removeClass('upscrolled');
                     }
                })
            }
        }     
    };

    var headerFixed111 = function() {
        if ( $('body').hasClass('header-sticky') ) {
            var nav = $('.header');

            if ( nav.size() !== 0 ) {
                var offsetTop = $('.header').offset().top,
                    headerHeight = $('.header').height(),
                    injectSpace = $('<div />', { height: 80 }).insertAfter(nav);   
                    injectSpace.hide();                 

                $(window).on('load scroll', function(){
                    if ( $(window).scrollTop() > offsetTop ) {
                        if ( $('.header').hasClass('header-classic') ) {
                            injectSpace.show();
                        }
                        $('.header').addClass('downscrolled');                        
                    } else {
                        $('.header').removeClass('header-small downscrolled');
                        injectSpace.hide();
                    }                    
                })
            }
        }
    };

    var headerFixedstyle2 = function() {
        if ( $('body').hasClass('header-sticky2') ) {
            var nav = $('.header');

            if ( nav.size() !== 0 ) {
                var offsetTop = $('.header').offset().top,
                    headerHeight = $('.header').height(),
                    injectSpace = $('<div />', { height: 60 }).insertAfter(nav);   
                    injectSpace.hide();                 

                $(window).on('load scroll', function(){
                    if ( $(window).scrollTop() > offsetTop ) {
                        if ( $('.header').hasClass('header-classic') ) {
                            injectSpace.show();
                        }
                        $('.header').addClass('downscrolled');                        
                    } else {
                        $('.header').removeClass('header-small downscrolled');
                        injectSpace.hide();
                    }                    
                })
            }
        }
    };

    var topSearch = function () {
        $(document).on('click', function(e) {   
            var clickID = e.target.id;   
            if ( ( clickID !== 's' ) ) {
                $('.top-search').removeClass('show');                
            } 
        });

        $('.show-search').on('click', function(event){
            event.stopPropagation();
        });

        $('.search-form').on('click', function(event){
            event.stopPropagation();
        });        

        $('.show-search').on('click', function (event) {
            if(!$('.top-search').hasClass( "show" )) {
                $('.top-search').addClass('show');  
                event.preventDefault();                
            }
                
            else
                $('.top-search').removeClass('show');
                event.preventDefault();

            if( !$('.show-search' ).hasClass( "active" ) )
                $( '.show-search' ).addClass( 'active' );
            else
                $( '.show-search' ).removeClass( 'active' );
        });   
    };

    var ajaxContactForm = function() {  
        $('#contactform').each(function() {
            $(this).validate({
                submitHandler: function( form ) {
                    var $form = $(form),
                        str = $form.serialize(),
                        loading = $('<div />', { 'class': 'loading' });

                    $.ajax({
                        type: "POST",
                        url:  $form.attr('action'),
                        data: str,
                        beforeSend: function () {
                            $form.find('.form-submit').append(loading);
                        },
                        success: function( msg ) {
                            var result, cls;                            
                            if ( msg == 'Success' ) {                                
                                result = 'Message Sent Successfully To Email Administrator. ( You can change the email management a very easy way to get the message of customers in the user manual )';
                                cls = 'msg-success';
                            } else {
                                result = 'Error sending email.';
                                cls = 'msg-error';
                            }

                            $form.prepend(
                                $('<div />', {
                                    'class': 'flat-alert ' + cls,
                                    'text' : result
                                }).append(
                                    $('<a class="close" href="#"><i class="fa fa-close"></i></a>')
                                )
                            );

                            $form.find(':input').not('.submit').val('');
                        },
                        complete: function (xhr, status, error_thrown) {
                            $form.find('.loading').remove();
                        }
                    });
                }
            });
        }); // each contactform
    };   

    var alertBox = function() {
        $(document).on('click', '.close', function(e) {
            $(this).closest('.flat-alert').remove();
            e.preventDefault();
        })     
    }       
  
    var googleMap = function() {
        if ( $().gmap3 ) {
            $("#maps").gmap3({
                map:{
                    options:{
                        zoom: 11,
                        mapTypeId: 'Spec_style',
                        mapTypeControlOptions: {
                            mapTypeIds: ['Spec_style', google.maps.MapTypeId.SATELLITE, google.maps.MapTypeId.HYBRID]
                        },
                        scrollwheel: false
                    }
                },
                getlatlng:{
                    address:  "1341 W Mockingbrid, NewYourk",
                    callback: function(results) {
                        if ( !results ) return;
                        $(this).gmap3('get').setCenter(new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng()));
                        $(this).gmap3({
                            marker:{
                                latLng:results[0].geometry.location,
                                options:{
                                    // icon: 'http://themesflat.com/html/canava/images/icon/marker.png'
                                }
                            }
                        });
                    }
                },
                styledmaptype:{
                    id: "Spec_style",
                    options:{
                        name: "Spec Map"
                    }, 
                    styles: [
                        {
                            "featureType": "landscape",
                            "stylers": [
                                {
                                    "saturation": -100
                                },
                                {
                                    "lightness": 65
                                },
                                {
                                    "visibility": "on"
                                }
                            ]
                        },

                        {
                            "featureType": "poi",
                            "stylers": [
                                {
                                    "saturation": -100
                                },
                                {
                                    "lightness": 51
                                },
                                {
                                    "visibility": "simplified"
                                }
                            ]
                        },

                        {
                            "featureType": "road.highway",
                            "stylers": [
                                {
                                    "saturation": -100
                                },
                                {
                                    "visibility": "simplified"
                                }
                            ]
                        },

                        {
                            "featureType": "road.arterial",
                            "stylers": [
                                {
                                    "saturation": -100
                                },
                                {
                                    "lightness": 30
                                },
                                {
                                    "visibility": "on"
                                }
                            ]
                        },
                        {
                            "featureType": "road.local",
                            "stylers": [
                                {
                                    "saturation": -100
                                },
                                {
                                    "lightness": 40
                                },
                                {
                                    "visibility": "on"
                                }
                            ]
                        },
                        {
                            "featureType": "transit",
                            "stylers": [
                                {
                                    "saturation": -100
                                },
                                {
                                    "visibility": "simplified"
                                }
                            ]
                        },

                        {
                            "featureType": "administrative.province",
                            "stylers": [
                                {
                                    "visibility": "off"
                                }
                            ]
                        },
                        {
                            "featureType": "water",
                            "elementType": "labels",
                            "stylers": [
                                {
                                    "visibility": "on"
                                },
                                {
                                    "lightness": -25
                                },
                                {
                                    "saturation": -100
                                },
                                { "color": "#81abff" }
                            ]
                        },
                        {
                            "featureType": "water",
                            "elementType": "geometry",
                            "stylers": [
                                {
                                    "hue": "#81abff"
                                },
                                {
                                    "lightness": 17
                                },
                                {
                                    "saturation": -97
                                }
                            ]
                        }
                    ]                   
                },
            });
        }
    };            

    var flatTestimonials_1 = function() {
        $('.flat-row').each(function() {            
            if ( $().owlCarousel ) {
                $(this).find('.flat-testimonials1').owlCarousel({
                    loop: true,
                    margin: 30,
                    nav: $('.flat-testimonials1').data('nav'),
                    dots: $('.flat-testimonials1').data('dots'),                     
                    autoplay: $('.flat-testimonials1').data('auto'),                    
                    responsive:{
                        0:{
                            items: 1
                        },
                        480:{
                            items: 2
                        },
                        767:{
                            items: 2
                        },
                        991:{
                            items: 2
                        },
                        1200: {
                            items: $('.flat-testimonials1').data('item')
                        }
                    }
                });
            }
        });
    };

    var flatTestimonials_2 = function() {
        $('.flat-row').each(function() {            
            if ( $().owlCarousel ) {
                $(this).find('.flat-testimonials2').owlCarousel({
                    loop: true,
                    margin: 30,
                    nav: $('.flat-testimonials2').data('nav'),
                    dots: $('.flat-testimonials2').data('dots'),                     
                    autoplay: $('.flat-testimonials2').data('auto'),                    
                    responsive:{
                         0:{
                            items: 1
                        },
                        480:{
                            items: 2
                        },
                        767:{
                            items: 2
                        },
                        991:{
                            items: 2
                        },
                        1200: {
                            items: $('.flat-testimonials2').data('item')
                        }
                    }
                });
            }
        });
    };

    var flatTestimonials_3 = function() {
        $('.flat-row').each(function() {            
            if ( $().owlCarousel ) {
                $(this).find('.flat-testimonials3').owlCarousel({
                    loop: true,
                    margin: 0,
                    nav: $('.flat-testimonials3').data('nav'), 
                    dots: $('.flat-testimonials3').data('dots'),                                    
                    autoplay: $('.flat-testimonials3').data('auto'),                    
                    responsive:{
                        0:{
                            items: 1
                        },
                        480:{
                            items: 1
                        },
                        767:{
                            items: 1
                        },
                        991:{
                            items: 1
                        },
                        1200: {
                            items: $('.flat-testimonials3').data('item')
                        }
                    }
                });
            }
        });
    };

    var flatTestimonials_4 = function() {
        $('.flat-row').each(function() {            
            if ( $().owlCarousel ) {
                $(this).find('.wrap-portfolio').owlCarousel({
                    loop: true,
                    margin: 13,
                    nav: $('.wrap-portfolio').data('nav'), 
                    dots: $('.wrap-portfolio').data('dots'),                                    
                    autoplay: $('.wrap-portfolio').data('auto'),                    
                    responsive:{
                        0:{
                            items: 1
                        },
                        480:{
                            items: 2
                        },
                        767:{
                            items: 2
                        },
                        991:{
                            items: 2
                        },
                        1200: {
                            items: $('.wrap-portfolio').data('item')
                        }
                    }
                });
            }
        });
    };

    var flatClient = function() {
        $('.flat-row').each(function() {            
            if ( $().owlCarousel ) {
                $(this).find('.flat-client').owlCarousel({
                    loop: true,
                    margin: 70,
                    nav: $('.flat-client').data('nav'),
                    dots: $('.flat-client').data('dots'),                     
                    autoplay: $('.flat-client').data('auto'),                    
                    responsive:{
                        0:{
                            items: 2
                        },
                        320: {
                            items: 2
                        },
                        480:{
                            items: 3
                        },
                        767:{
                            items: 3
                        },
                        991:{
                            items: 4
                        },
                        1200: {
                            items: $('.flat-client').data('item')
                        }
                    }
                });
            }
        });
    }; 

    var flatpopup = function() {
        $('.flat-row').each(function() {            
            if ( $().owlCarousel ) {
                $(this).find('.flat-item-img').owlCarousel({
                    loop: true,
                    margin: 70,
                    nav: $('.flat-item-img').data('nav'),
                    dots: $('.flat-item-img').data('dots'),                     
                    autoplay: $('.flat-item-img').data('auto'),                    
                    responsive:{
                        0:{
                            items: 1
                        },
                        320: {
                            items: 1
                        },
                        480:{
                            items: 1
                        },
                        767:{
                            items: 1
                        },
                        991:{
                            items: 1
                        },
                        1200: {
                            items: 1
                        }
                    }
                });
            }
        });
    }; 

    var counter = function() {       
        $('.flat-counter').on('on-appear', function() {             
            $(this).find('.numb-count').each(function() { 
                var to = parseInt( ($(this).attr('data-to')),10 ), speed = parseInt( ($(this).attr('data-speed')),10 );
                if ( $().countTo ) {
                    $(this).countTo({
                        to: to,
                        speed: speed
                    });
                }
            });
       });
    }; 

    var quantity = function(){
            jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up">></div><div class="quantity-button quantity-down"><</div></div>').insertAfter('.quantity input');
                jQuery('.quantity').each(function() {
                  var spinner = jQuery(this),
                    input = spinner.find('input[type="number"]'),
                    btnUp = spinner.find('.quantity-up'),
                    btnDown = spinner.find('.quantity-down'),
                    min = input.attr('min'),
                    max = input.attr('max');

                  btnUp.click(function() {
                    var oldValue = parseFloat(input.val());
                    if (oldValue >= max) {
                      var newVal = oldValue;
                    } else {
                      var newVal = oldValue + 1;
                    }
                    spinner.find("input").val(newVal);
                    spinner.find("input").trigger("change");
                  });

                  btnDown.click(function() {
                    var oldValue = parseFloat(input.val());
                    if (oldValue <= min) {
                      var newVal = oldValue;
                    } else {
                      var newVal = oldValue - 1;
                    }
                    spinner.find("input").val(newVal);
                    spinner.find("input").trigger("change");
                  });

                });
    }  

    var detectViewport = function() {
        $('[data-waypoint-active="yes"]').waypoint(function() {
            $(this).trigger('on-appear');
            }, { offset: '90%', triggerOnce: true });

        $(window).on('load', function() {
            setTimeout(function() {
                $.waypoints('refresh');
            });
        });
    };

    var flatAccordion = function() {
        var args = {duration: 600};
        $('.flat-toggle .toggle-title.active').siblings('.toggle-content').show();

        $('.flat-toggle.enable .toggle-title').on('click', function() {
            $(this).closest('.flat-toggle').find('.toggle-content').slideToggle(args);
            $(this).toggleClass('active');
        }); // toggle 

        $('.flat-accordion .toggle-title').on('click', function () {
            if( !$(this).is('.active') ) {
                $(this).closest('.flat-accordion').find('.toggle-title.active').toggleClass('active').next().slideToggle(args);
                $(this).toggleClass('active');
                $(this).next().slideToggle(args);
            } else {
                $(this).toggleClass('active');
                $(this).next().slideToggle(args);
            }     
        }); // accordion
    }; 

    var tabs = function() {
        $('.flat-tabs').each(function() {
            $(this).children('.content-tab').children().hide();
            $(this).children('.content-tab').children().first().show();
            $(this).find('.menu-tab').children('li').on('click', function(e) {  
                var liActive = $(this).index(),
                    contentActive = $(this).siblings().removeClass('active').parents('.flat-tabs').children('.content-tab').children().eq(liActive);

                contentActive.addClass('active').fadeIn('slow');
                contentActive.siblings().removeClass('active');
                $(this).addClass('active').parents('.flat-tabs').children('.content-tab').children().eq(liActive).siblings().hide();
                e.preventDefault();
            });
        });
    };

    var portfolioIsotope = function() {         
        if ( $().isotope ) {           
            var $container = $('.iso-portfolio');
            $container.imagesLoaded(function(){
                $container.isotope({
                    itemSelector: '.item',
                    transitionDuration: '1s'
                });
            });

            $('.portfolio-filter li').on('click',function() {                           
                var selector = $(this).find("a").attr('data-filter');
                $('.portfolio-filter li').removeClass('active');
                $(this).addClass('active');
                $container.isotope({ filter: selector });
                return false;
            });

            $('.iso-portfolio .load-more a').on('click', function(e) {
                e.preventDefault();

                var el = $(this),
                    url = el.attr('href'),
                    page = parseInt(el.attr('data-page'), 10);

                el.addClass('loading').text('Loading...');

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: "html",
                    async: false,   // wait result
                    data : { page : page }
                })
                .done(function (data) {
                    if ( data != null ) {                      
                        var newitem = $(data);
                        $container.append(newitem).isotope('appended', newitem);
                        el.removeClass('loading').text('Load more');
                        page = page + 1;
                        el.attr({'data-page': page, 'href': './ajax/p' + page + '.html'});
                    }
                })
                .fail(function () {
                    el.text('No more portfolio to load.');
                })
            });
        };
    };

    var CountDown = function() {
        var before = '<div class="square"><div class="numb">',
            text = '</div><div class="text">';
            if ($().countdown) {
                $(".countdown").countdown('2017/07/27', function(event) {
                  $(this).html(event.strftime(before + '%D' + text + '</div></div>' + before + '%H' + text + '</div></div>' + before + '%M' + text + '</div></div>' + before + '%S' + text + '</div>'));
                });
            }
    }; 

    var flatFilterPrice = function() {
        if( $().slider ) {
            $( ".price_slider" ).slider({
                range: true,
                min: 607,
                max: 1140,
                values: [ 610, 980 ],
                slide: function( event, ui ) {
                    $( ".price_label > input " ).val( "$" + ui.values[ 0 ] + "  - $" + ui.values[ 1 ] );
                    }
            });

            $( ".price_label > input " ).val( "$" + $( ".price_slider" ).slider( "values", 0 ) +
            "  -  $" + $( ".price_slider" ).slider( "values", 1 ) );
            $( ".ui-slider-handle").append("<span class='shadow'></span>");
        }
    };

    var sectionVideo = function () {
        if($().YTPlayer) {
            $(".video-section").YTPlayer( {
                showControls: false,
                autoPlay: false,
                
            }); 
            var v = $('.video-section');
            $('#video-controls a')
            .each(function() {
                var t = $(this);
                t.on('click', (function(e) {
                    e.preventDefault();  
                    if (t.hasClass('fa-play')) {
                        t.removeClass('fa-play')
                            .addClass(
                                'fa-pause');
                        v.playYTP();
                        return false
                    }                  
                    if (t.hasClass('fa-pause')) {
                        t.removeClass(
                                'fa-pause')
                            .addClass('fa-play');
                        v.pauseYTP();
                        return false
                    }  
                    if (t.hasClass('fa-play-circle')) {
                        t.removeClass('fa-play-circle')
                            .addClass(
                                'fa-pause-circle');
                        v.playYTP();
                        return false
                    }  
                    if (t.hasClass('fa-pause-circle')) {
                        t.removeClass(
                                'fa-pause-circle')
                            .addClass('fa-play-circle');
                        v.pauseYTP();
                        return false
                    }                        
                }));
            });
        }
    }

    var responsiveVideo= function() {
        if ( $().fitVids ) {
            $('.container').fitVids();
        }
    };

    var swClick = function () {
        function activeLayout () {
            $(".switcher-container" ).on( "click", "a.sw-light", function() {
                $(this).toggleClass( "active" );
                $('body').addClass('home-boxed');  
                $('body').css({'background': '#f6f6f6' });                
                $('.sw-pattern.pattern').css ({ "top": "100%", "opacity": 1, "z-index": "10"});
            }).on( "click", "a.sw-dark", function() {
                $('.sw-pattern.pattern').css ({ "top": "98%", "opacity": 0, "z-index": "-1"});
                $(this).removeClass('active').addClass('active');
                $('body').removeClass('home-boxed');
                $('body').css({'background': '#fff' });
                return false;
            })       
        }        

        function activePattern () {
            $('.sw-pattern').on('click', function () {
                $('.sw-pattern.pattern a').removeClass('current');
                $(this).addClass('current');
                $('body').css({'background': 'url("' + $(this).data('image') + '")', 'background-size' : '30px 30px', 'background-repeat': 'repeat' });
                return false
            })
        }

        activeLayout(); 
        activePattern();
    } 
    
    var goTop = function() {
        $(window).scroll(function() {
            if ( $(this).scrollTop() > 800 ) {
                $('.go-top').addClass('show');
            } else {
                $('.go-top').removeClass('show');
            }
        }); 

        $('.go-top').on('click', function() {            
            $("html, body").animate({ scrollTop: 0 }, 1000 , 'easeInOutExpo');
            return false;
        });
    };   

    var retinaLogos = function() {
      var retina = window.devicePixelRatio > 1 ? true : false;

        if(retina) {
            $('.header .logo').find('img').attr({src:'./images/logo@2x.png',width:'210',height:'88'});   
        }
    };    
    
    var parallax = function() {
        if ( $().parallax && isMobile.any() == null ) {
            $('.parallax1').parallax("50%", 0.5);  
            $('.parallax2').parallax("50%", 0.5);
            $('.parallax3').parallax("50%", 0.5);
            $('.parallax4').parallax("50%", 0.5);
            $('.parallax5').parallax("50%", 0.5);
            $('.parallax6').parallax("50%", 0.5);         
        }
    };

    var popupGallery = function () {
        $(".popup-gallery").magnificPopup({
            type: "image",
            tLoading: "Loading image #%curr%...",
            removalDelay: 600,
            mainClass: "my-mfp-slide-bottom",
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [ 0, 1 ]
            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
            }
        });
    }

    var popupdiv = function() {
            $('[data-popup-open]').on('click', function(e)  {
                var targeted_popup_class = jQuery(this).attr('data-popup-open');
                $('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);
         
                e.preventDefault();
            });
         
            //----- CLOSE
            $('[data-popup-close]').on('click', function(e)  {
                var targeted_popup_class = jQuery(this).attr('data-popup-close');
                $('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);
         
                e.preventDefault();
            });
    }

    

    var removePreloader = function() {        
        $('.loading-overlay').fadeOut('slow',function () {
            $(this).remove();
        });
    };

   	// Dom Ready
	$(function() { 
         if ( matchMedia( 'only screen and (min-width: 991px)' ).matches ) {
            headerFixed111();
            headerFixed();
            headerFixedstyle2();
         }  
        responsiveMenu();
        topSearch();          
        flatTestimonials_1();
        flatTestimonials_2();
        flatTestimonials_3();
        flatTestimonials_4();
        flatClient();
        flatpopup();
        detectViewport();
        counter();
        flatAccordion();
        tabs();
        portfolioIsotope();
        googleMap();
        CountDown();
        flatFilterPrice();
        popupGallery();
        sectionVideo();         
        responsiveVideo();
        swClick(); 
        parallax();
        removePreloader();
        goTop();
        popupdiv();
   	});

})(jQuery);
/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can 
 * always reference jQuery with $, even when in .noConflict() mode.
 *
 * Google CDN, Latest jQuery
 * To use the default WordPress version of jQuery, go to lib/config.php and
 * remove or comment out: add_theme_support('jquery-cdn');
 * ======================================================================== */

 
(function($) {

// Use this variable to set up the common and page specific functions. If you 
// rename this variable, you will also need to rename the namespace below.
var Roots = {
  // All pages
  common: {
    init: function(){
		
		// Move modal to bottom (where there are no z-index issues)
		$('.modal').appendTo('body');
		
		// Fill Text
		$(window).resize(function() {
			$('.textfill').textfill({ 	maxFontPixels: 0,
										widthOnly: true,
									});
			$('.textfill-ul').textfill({	widthOnly: true,
											innerTag: 'ul',
											maxFontPixels: 100,
										});
			$('.sliding-top-nav').each(function(){
				baseFont = parseInt( $(this).css('font-size') );
				$(this).textfill({	widthOnly: true,
									innerTag: 'ul',
									maxFontPixels: baseFont,
								});
			});
		}).resize();

		
		$('.fitVids').fitVids();
		$('.modal').find('iframe').attr('src', '');
	
		// Modals Vcenter
		function adjustModalMaxHeightAndPosition(){
			$('.modal').each(function(){
				if( $(this).hasClass('in') === false){
					$(this).show();
				}
				var contentHeight = $(window).height() - 60;
				var headerHeight = $(this).find('.modal-header').outerHeight() || 2;
				var footerHeight = $(this).find('.modal-footer').outerHeight() || 2;

				$(this).find('.modal-content').css({
					'max-height': function() {
						return contentHeight;
					}
				});

				$(this).find('.modal-body').css({
					'max-height': function () {
						return (contentHeight - (headerHeight + footerHeight));
					}
				});

				$(this).find('.modal-dialog').css({
					'margin-top': function () {
						return -($(this).outerHeight() / 2);
					},
					'margin-left': function () {
						return -($(this).outerWidth() / 2);
					}
				});
				if($(this).hasClass('in') === false){
					$(this).hide();
				}
			});
		}
		$(window).resize(adjustModalMaxHeightAndPosition).trigger("resize");
		
		$('.modal').on('hide.bs.modal', function (){
			var iframe = $(this).find('iframe');
			var src = iframe.attr('src');
			iframe.attr('src', '');
		});
		$('.modal').on('show.bs.modal', function (){
			var iframe = $(this).find('iframe');
			var src = iframe.data('src');
			iframe.attr('src', src);
		});

        $('.scrolltop').each(function () {
            $(this).click(function () {
                $('html,body').animate({
                    scrollTop: 0,
                    easing: 'easeInOutQuart',
                }, 400);
                return false;
            });
        });

        $('.sliding-top-nav ul').each( function(){

            $(this).append('<div class="top-slider"></div>');

            var left = $(this).find('li a.active').first().position().left;
            var width = $(this).find('li a.active').first().outerWidth();

            $(this).children('.top-slider').stop().animate({
                'left': left,
                'width': width
            });
        });

        $('.sliding-top-nav li a').hover(function () {

            var left = $(this).position().left;
            var width = $(this).outerWidth();

            $(this).parents('.sliding-top-nav').find('.top-slider').stop().animate({
                'left': left,
                'width': width
            });

        }, function () {

            var left = $(this).parents('.sliding-top-nav').find('a.active').position().left;
            var width = $(this).parents('.sliding-top-nav').find('a.active').outerWidth();

            $(this).parents('.sliding-top-nav').find('.top-slider').stop().animate({
                'left': left,
                'width': width
            });

        });

        $('.sliding-top-nav li a').click(function () {

            $(this).parents('.sliding-top-nav').find('.active').removeClass('active');
            $(this).addClass('active');

        });

        $('a[href="#current-tours"]').click(function () {
            $('.tour.past').slideUp();
            $('.tour.current').slideDown();
            return false;
        });

        $('a[href="#past-tours"]').click(function () {
            $('.tour.current').slideUp();
            $('.tour.past').slideDown();
            return false;
        });
		
		
		$('.hotels-menu a').click(function () {
            $showHotels = $( '.' + $(this).attr('href').slice(1, -1) );
			$('.archive-post.hotel').not( $showHotels ).slideUp();
			$showHotels.slideDown();
            return false;
        });
		
		$('.roads-menu a').click(function () {
            $showRoads = $( '.' + $(this).attr('href').slice(1, -1) );
			$('.archive-post.road').not( $showRoads ).slideUp();
			$showRoads.slideDown();
            return false;
        });
		
		
		// Dynamically adjust .main's overlap of section.hero based on .main's (sub)header baseline
		$(window).on('resize', function(){
		
			if( !$('section.hero').length || !$('.main').length ){
				return;
			}
		
			var heroOffset = $('section.hero').offset().top + $('section.hero').outerHeight();
			
			$('.main').css('margin-top', function(index, oldMarginTop){
				var $possibleHeaders = $('.main').children().not('.main-back-btn').not('.top-row');
				var $header = $possibleHeaders.first().filter('.flex-heading-lg').children(':first');
				var $subheader = $possibleHeaders.not('.flex-heading-lg').first().filter('.flex-heading-md').children(':first');
				
				if( !$header.length ){
					$header = $('.main').find('h3').filter(function(){
						var offsetTop = $(this).offset().top - $('.main').offset().top;
						var offsetLeft = $(this).offset().left - $('.main').offset().left;
						return offsetTop < 400 && offsetLeft < 100;
					}).first();
				}
				if( !$subheader.length ){
					$subheader = $('.main').find('h3').filter(function(){
						var offsetTop = $(this).offset().top - $('.main').offset().top;
						var offsetLeft = $(this).offset().left - $('.main').offset().left;
						return offsetTop < 400 && offsetLeft < 100;
					}).first();
				}
				
				if( $('.main').children('.top-row').length ){
					var $reference = $header.length ? $header : $subheader;
				}else{
					var $reference = $subheader.length ? $subheader : $header;
				}
				if( $reference.length ){
					var referenceOffset = $reference.offset().top + $reference.height();
					var offsetDiff = (referenceOffset - heroOffset) || 0;
					var newMarginTop = Math.min(0, parseInt( oldMarginTop ) - offsetDiff);
				}
				
				return newMarginTop;
			});
			
			$('section.hero').css('padding-bottom', function(index, oldPadBot){
				var mainOverlap = heroOffset - $('.main').offset().top;
				var backBtnHeight = $('.main-back-btn').outerHeight(true);
				var newPadBot = mainOverlap + backBtnHeight || oldPadBot;				
				
				return newPadBot;
			});
			
			
		}).resize();
		
		
		$(window).on('scroll resize', function(){
			if( $(document).scrollTop() > $('.main').offset().top ){
				$('.inner-top-nav').addClass('fixed').width( function(){
					return $(this).parent().width();
				}).css('left', function(){
					return $(this).parent().offset().left;
				});
			}else{
				$('.inner-top-nav').removeClass('fixed').removeAttr('style');
			}
		});
		
        /*moin = $.ajax({
            type:"POST",
            url: "http://localhost/autobahn/wp-admin/admin-ajax.php",
            data: {
                "action" : "returnPosts",
            },
            success: function(results){
                console.log(results);
            }
        });

        console.log(moin);*/
		
		
		
		
		// Equalize divs with .equalize
		$(window).load(function() {
			$('.showcase-boxes .boxes-row').equalizer({
												columns: '> .showcase-box',
												resizeable: true,
												breakpoint: 768,
			});
		});
		
    }
  },
  // Home page
  home: {
    init: function() {
        // JavaScript to be fired on the home page

        fullPage();
//        $(window).resize(function() {
//            fullPage();
//        });

        function fullPage() {
            if ($(window).width() >= 768) {

                $('.wrap').fullpage({ fixedElements: '.fixed-header' });

                $('.scrolltop').each(function () {
                    $(this).click(function () {
                        $.fn.fullpage.moveTo(1);
                    });
                });
            } else { $.fn.fullpage.destroy('all'); }
        }
    }
  },
  // Driving Tours
  driving_tours: {
      init: function () {

      }
  },
  // About us page, note the change from about-us to about_us.
  about_us: {
    init: function() {
      // JavaScript to be fired on the about us page
    }
  },
  // Booking Page
  booking: {
    init: function() {
      
	  
	  $('.first-form-tab').click(function() {
        $('#booking-form-start').tab('show');
      });
	  
	  
	  
	var previousPage = 1;
	
	$('a[href="#gform_page_2_1"]').not('.disabled > a').click( function(){
		$('#gform_page_2_2 .gform_previous_button').click();
		return $(this).attr('href') ? false : '';
	});
	$('a[href="#gform_page_2_2"], .btn.first-form-tab').not('.disabled > a').click( function(){
		$('#gform_page_2_1 .gform_next_button').click();
		return $(this).attr('href') ? false : '';
	});
	$('a[href="#gform_page_2_3"]').not('.disabled > a').click( function(){
		$('#gform_page_2_2 .gform_next_button').click();
		return $(this).attr('href') ? false : '';
	});
	$('a[href="#gform_page_2_4"]').not('.disabled > a').click( function(){
		$('#gform_page_2_3 .gform_next_button').click();
		return $(this).attr('href') ? false : '';
	});
	
	$('.disabled > a').click(function(){
		return false;
	});
	  
	$(document).on('gform_post_render', function(event, form_id, current_page){
	
		//console.log(event);
		//console.log(form_id);
		//console.log(current_page);
	
		switch( parseInt(current_page) ){
			case 1:
				$('.booking-nav li:lt(1)').addClass('active');
				if( previousPage != 1 ){
					$('.booking-tab#start').show();
				}else{
					$('.booking-nav li:gt(3)').addClass('disabled');
				}
				previousPage = 1;
				break;
			case 2:
				$('.booking-nav li:lt(2)').addClass('active');
				if( previousPage != 2 ){
					$('.booking-tab#start').hide();
					$('.booking-nav li:nth-child(3)').removeClass('disabled');
				}else{
					$('.booking-nav li:nth-child(4)').addClass('disabled');
				}
				previousPage = 2;
				break;
			case 3:
				$('.booking-nav li:lt(3)').addClass('active');
				if( previousPage != 3 ){
					$('.booking-tab#start').hide();
					$('.booking-nav li:nth-child(4)').removeClass('disabled');
				}else{
				
				}
				previousPage = 3;
				break;
			case 4:
				$('.booking-nav li:lt(4)').addClass('active');
				if( previousPage != 4 ){
					$('.booking-tab#start').hide();
				}else{
				
				}
				previousPage = 4;
				break;
		}
		
	});

	  
	  
    }
  }
};

// The routing fires all common scripts, followed by the page specific scripts.
// Add additional events for more control over timing e.g. a finalize event
var UTIL = {
  fire: function(func, funcname, args) {
    var namespace = Roots;
    funcname = (funcname === undefined) ? 'init' : funcname;
    if (func !== '' && namespace[func] && typeof namespace[func][funcname] === 'function') {
      namespace[func][funcname](args);
    }
  },
  loadEvents: function() {
    UTIL.fire('common');

    $.each(document.body.className.replace(/-/g, '_').split(/\s+/),function(i,classnm) {
      UTIL.fire(classnm);
    });
  }
};

$(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.

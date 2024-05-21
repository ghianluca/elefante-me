window.ELEFANTE = window.ELEFANTE || {};

ELEFANTE.Home = (function() {
	var _private = {
		getNavHeight: function() {
			return $('#navigation').height();
		},

		getNavWidth: function() {
			return $('#navigation').width();
		},

		getCompensatedHeight: function() {
			return window.innerHeight - _private.getNavHeight();
		},

		getCompensatedWidth: function() {
			return window.innerWidth - _private.getNavWidth();
		},

		getMiddlePosition: function(element) {
			var height 	= $(element).height();
			var top 	= (_private.getCompensatedHeight() / 2) - (height / 2);
			var width 	= $(element).width();
			var left 	= Math.abs((_private.getCompensatedWidth() / 2) - (width / 2));

			return {
				top: top,
				left: left
			} 
		}
	};

	return {
		init: function() {
			this.bindEvents();
			this.fit();
		},

		bindEvents: function() {
			$('#home div.logo img').css('visibility', 'hidden');
			var _this = this;
			var $img = $('#home div.logo img');
			var imgSrc = $img.attr('src');
			var newImage = new Image();

			newImage.onload = function () {
				$('#home div.logo img').css('visibility', '');
			}
			newImage.src = imgSrc;
		},

		fit: function() {
			var height = _private.getCompensatedHeight();
			$('#home').css({height: height});
		}
	};
})();

ELEFANTE.Scroll = (function($) {
	return {
		to: function(target, callback) {
			var offset = $(target).offset().top;

			$('html, body').animate({
				scrollTop: offset
			}, 750, 'swing', callback);
		},
	};
})(jQuery);

jQuery(document).ready(function($){
	"use strict";

	var window_height = $(window).height(),
		window_width = $(window).width(),
		navigation_height;

		$(window).resize(function(e) {
		ELEFANTE.Home.fit();
	}).resize();

	$('[data-scroll-to]').on('click', function(e) {
		e.stopPropagation();
		ELEFANTE.Scroll.to($(this).attr('data-scroll-to'));
	});

	/* ============== placeholder ============== */

	$('input, textarea').placeholder();

	/* ============== SLIDERS ============== */

	$("#header-slide").owlCarousel({
		navigation : false,
		pagination: true,
		autoPlay: true,
		singleItem: true,
		mouseDrag: false,
		touchDrag: false,
		transitionStyle : "fade"
	});

	$(window).resize(function() {

		window_height = $(window).height();
		
		navigation_height =  $("#navigation").height();

		$('#header-wrap').css('height', ( window_height - ( navigation_height / 2 ) ) +'px');
		$('#header-wrap .logo').css('width', $('#header-wrap .container').width() +'px');

	}).resize();

	$('.slide').owlCarousel({
		navigation : true,
		pagination: true,
		navigationText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
		autoHeight: true,
		singleItem: true
	});

	/* ============== MENU ============== */

	var getLinkHash = function($a) {
		var href = $a.attr('href');
    	var re = /(#\w+)/g; 
		var m;
		var hash;
		 
		while ((m = re.exec(href)) != null) {
		    if (m.index === re.lastIndex) {
		        re.lastIndex++;
		    }

		    return m[0];
		}
	};

	$('#navigation .menu-container').onePageNav({
		currentClass: 'active',
		changeHash: true,
	    scrollChange: function($currentListItem) {
	    	// to avoid a glich when scrolling we remove the element id and add
	    	// id back after change page hash
	    	var hash = getLinkHash($currentListItem.find('a').eq(0));
			Routify.go(hash);
    	}
	});


	$('#mobile-menu-button').on('click',function(){

		var $MobileMenu = $('#mobile-menu');

		if ( $MobileMenu.css('display') == 'block' ){
			$MobileMenu.slideUp(300).addClass('active');
		} else{
			$MobileMenu.slideDown(300).removeClass('active');
		}

	});

	
	$(window).load(function() {
		var $navigation = $('.fixed-enabled');
		var navigation_offset = $navigation.offset().top  + 10;
			
		$(window).resize(function(){
			$navigation.removeClass('fixed-nav');
			navigation_offset = $navigation.offset().top  + 10;
			navigation_scroll();
		});
		
		$(window).scroll(function(){
			navigation_scroll();
		});
			
		function navigation_scroll(){
			var scrollY = $(window).scrollTop();
				if(scrollY > navigation_offset){
					$navigation.addClass('fixed-nav');
				}else if(scrollY < navigation_offset){
					$navigation.removeClass('fixed-nav');
				}
		}
	});

	/* ============ HOME PARALLAX  =========== */

	ELEFANTE.Home.init();

	/* ============== PARALLAX  ============== */

	if (!isMobile.any() && window_width > 990) {
		$(window).bind('load', function () {

			if ($('.parallax').length) {
				$('.parallax').each(function(index, el) {

					$(this).parallax("50%", 0.2);

				});
			}

		});
	}

	/* ========== SECTION H1 RESIZE  =========== */

	if (isMobile.any()) {
		var $titles = $('.header-section h2');
		$titles.each(function() {
			var minFontSize = $(this).attr('data-min-font-size') || 50;
			var maxFontSize = $(this).attr('data-max-font-size') || 120;

			$(this).fitText(1.1, {
				minFontSize: minFontSize + 'px',
				maxFontSize: maxFontSize + 'px' 
			});
		});

	}

	/* ============== LIGHTBOX  ============== */

		$('.lightbox').magnificPopup({
			type:'image'
		});

	/* ============== COUNTUP ============== */

	$('.countup').appear(function() {

		var count_element =  $(this);

		count_element.countTo({
			from: 0,
			to: parseInt( count_element.text() , 10 ) ,
			speed: 3000
		});

	});

	/* ============== SKILL ============== */

	$('.skill.style-2 .chart').appear(function() {

		var color = $(this).css('color'),
			size  = parseInt( $(this).css('width') , 10 );

		$(this).easyPieChart({
			barColor: color,
			trackColor: false, 
			scaleColor: false,
			lineCap: 'square',
			lineWidth: 6,
			size: size,
			animate: 1500,
			onStep: function(from, to, percent) {
				$(this.el).find('span').text(Math.round(percent));
			}
		});

	});

	$('.skill').not('.skill.style-2').appear(function() {

		$(this).pin();

	});

	/* ============== fitVids ============== */

	$('.fit').fitVids();

	/* ============== CLIENTS ============== */

	$('#client-carousel').owlCarousel({
		items: 6,
		autoPlay: true,
		pagination: false,
		autoHeight: true
	});

	/* ============== TWITTER ============== */

	$("#twitter-carousel").owlCarousel({
		items: 1,
		pagination: true,
		singleItem: true,
		// jsonPath : 'http://127.0.0.1:8888/Krown/php/tweets-json.php',
		jsonPath : 'php/tweets-json.php',
		jsonSuccess : customDataSuccess
	});

	function customDataSuccess(data){
		var content = "";
		for(var i in data){
			content += "<div>";
			content +=   data[i].tweet;
			// content +=   "<div>"+ data[i]["date"] +"</div>";
			content += "</div>";
		}

		$("#twitter-carousel").html(content);
	}

	/* ============== COMMENTS ============== */

	$("#comments").on('click',function(event) {
		event.preventDefault();
		$(".comments").fadeIn('400');

	});

	/* ============== PORTFOLIO ============== */

	var $container = $('#work-wrap'),
		$containerProxy = $container.clone().empty().css({ visibility: 'hidden' }),
		colWidth;

		$container.after( $containerProxy );

	if ($container.hasClass('style-2') || $container.hasClass('style-3') || $container.hasClass('style-4') || $container.hasClass('style-5') || $container.hasClass('style-6')) {

		$container.isotope({
			itemSelector: '.work-item',
		});

	} else {

		$(window).resize( function() {

			colWidth = Math.floor( $containerProxy.width() / 4 );
			$container.css({
				width: colWidth * 4
			})
			.isotope({
				resizable: false,
				itemSelector: '.work-item',
				masonry: {
					columnWidth: colWidth
				}
			});
			
		}).resize();

	}

	$container.imagesLoaded( function() {
		$container.isotope('layout');
	});

	// filters
	$('#filters li:eq(0) a').addClass('active');

	$('#filters a').each(function(index, el) {
		var selector = $(this).attr('data-filter');
		var length;

		if (selector == "*") {
			length = $container.find(".work-item").length;
		}else{
			length = $container.find(selector).length;
		}

		$(this).append( $("<span />").text(length) );

	});

	$('#filters a').on('click',function(){

		$('#filters a').removeClass('active');
		$(this).addClass('active');

		var selector = $(this).attr('data-filter');

		$container.isotope({ filter: selector });

		return false;
	});

	/* ============== CONTACT FORM ============== */

	$('#contact-form').submit(function(event) {

		var $span   = $(this).find('span'),
			action   = $(this).attr('action'),
			data  = $(this).serialize();

		$span.removeClass("text-danger , text-success").fadeOut().text('Sending...').fadeIn();

		$.ajax({
			url: action,
			type: 'POST',
			data: data,
			dataType: 'json'
		}).done(function(response) {

			if (response.errors) {
				$span.text(response.errors[0]).addClass('text-danger').fadeIn();
			} else {
				$span.text(response.success).addClass('text-success').fadeIn();
			}

		});

		return false;
	});
	
});

function preloader(speed) {
	$("#preloader").fadeOut(speed, function() {});
}

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

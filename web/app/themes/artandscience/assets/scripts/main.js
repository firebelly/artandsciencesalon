// FBSage - Firebelly 2015
/*jshint latedef:false*/

// Good Design for Good Reason for Good Namespace
var FBSage = (function($) {

  var screen_width = 0,
      breakpoint_small = false,
      breakpoint_medium = false,
      breakpoint_large = false,
      breakpoint_array = [480,1000,1200],
      $document,
      $sidebar,
      loadingTimer,
      page_at;

  function _init() {
    // touch-friendly fast clicks
    FastClick.attach(document.body);

    // Cache some common DOM queries
    $document = $(document);
    $('body').addClass('loaded');

    // Set screen size vars
    _resize();

    // Fit them vids!
    // $('main').fitVids();

    _initBookAppointment();
    _initStylistsSort();
    _initCareersNav();
    // _initNav();
    _injectSvgSprite();

    // Esc handlers
    $(document).keyup(function(e) {
      if (e.keyCode === 27) {
        _hideMobileNav();
      }
    });

    // Smoothscroll links
    $('a.smoothscroll').click(function(e) {
      e.preventDefault();
      var href = $(this).attr('href');
      _scrollBody($(href));
    });

    // Scroll down to hash afer page load
    $(window).load(function() {
      if (window.location.hash) {
        _scrollBody($(window.location.hash));
      }
    });

  } // end init()

  function _scrollBody(element, duration, delay) {
    if ($('#wpadminbar').length) {
      wpOffset = $('#wpadminbar').height();
    } else {
      wpOffset = 0;
    }
    element.velocity("scroll", {
      duration: duration,
      delay: delay,
      offset: -wpOffset
    }, "easeOutSine");
  }

  // Handles main nav
  function _initNav() {
    // SEO-useless nav toggler
    $('<div class="menu-toggle"><div class="menu-bar"><span class="sr-only">Menu</span></div></div>')
      .prependTo('header.banner')
      .on('click', function(e) {
        _showMobileNav();
      });
    var mobileSearch = $('.search-form').clone().addClass('mobile-search');
    mobileSearch.prependTo('.site-nav');
  }

  function _initBookAppointment() {
    var $bAModule = $('#book-appointment');

    $bAModule.on('click', 'button', function() {
      if ($bAModule.is('.-active')) {
        $bAModule.removeClass('-active');
      } else {
        $bAModule.addClass('-active');
      }
    });
  }

  function _initStylistsSort() {
    if ($('.page.stylists').length) {

      var $stylistsNav = $('.stylists-nav');

      // Show related location when toggled from nav
      $stylistsNav.on('click', '.location a', function(e) {
        e.preventDefault();
        var targetLocation = $(this).attr('href'),
            thisListItem = $(this).closest();

        if ($(this).closest('.location')) {
          $(this).closest('.location').addClass('-active');
        }

      });

    }
  }

  function _initCareersNav() {
    var $careersNav = $('.careers-nav');

    if ($careersNav.length) {
      // Hide the careers section initially, except the first
      $('.careers-nav li:eq(0)').find('a').addClass('-active');
      $('.careers-child-page:eq(0)').addClass('-active');

      $('.careers-nav a').on('click', function(e) {
        e.preventDefault();
        var target = $(this).attr('data-target');

        $careersNav.find('a.-active').not($(this)).removeClass('-active');

        if (!$(this).is('.-active')) {
          $(this).addClass('-active');
        }

        console.log(target);

        $('.careers-child-page.-active:not(#'+target+')').removeClass('-active');
        $('#'+target).addClass('-active');

      });
    }
  }

  function _injectSvgSprite() {
    boomsvgloader.load('/app/themes/artandscience/assets/svgs/build/svgs-defs.svg');
  }

  function _showMobileNav() {
    $('.menu-toggle').addClass('menu-open');
    $('.site-nav').addClass('active');
  }

  function _hideMobileNav() {
    $('.menu-toggle').removeClass('menu-open');
    $('.site-nav').removeClass('active');
  }

  // Track ajax pages in Analytics
  function _trackPage() {
    if (typeof ga !== 'undefined') { ga('send', 'pageview', document.location.href); }
  }

  // Track events in Analytics
  function _trackEvent(category, action) {
    if (typeof ga !== 'undefined') { ga('send', 'event', category, action); }
  }

  // Called in quick succession as window is resized
  function _resize() {
    screenWidth = document.documentElement.clientWidth;
    breakpoint_small = (screenWidth > breakpoint_array[0]);
    breakpoint_medium = (screenWidth > breakpoint_array[1]);
    breakpoint_large = (screenWidth > breakpoint_array[2]);
  }

  // Called on scroll
  // function _scroll(dir) {
  //   var wintop = $(window).scrollTop();
  // }

  // Public functions
  return {
    init: _init,
    resize: _resize,
    scrollBody: function(section, duration, delay) {
      _scrollBody(section, duration, delay);
    }
  };

})(jQuery);

// Fire up the mothership
jQuery(document).ready(FBSage.init);

// Zig-zag the mothership
jQuery(window).resize(FBSage.resize);

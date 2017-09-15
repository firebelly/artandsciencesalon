// FBSage - Firebelly 2015
/*jshint latedef:false*/

// Good Design for Good Reason for Good Namespace
var FBSage = (function($) {

  var screen_width = 0,
      breakpoint_xs = false,
      breakpoint_sm = false,
      breakpoint_md = false,
      breakpoint_lg = false,
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
    _initNav();
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

  // Init main nav interactivity
  function _initNav() {
    // SEO-useless nav toggler
    $('<button aria-hidden="true" class="menu-toggle"><svg class="icon icon-nav"><use xlink:href="#icon-nav"/></svg></button>')
      .prependTo('body');

    $(document).on('click','.menu-toggle',function(e) {
      _toggleMobileNav();
    });
  }

  // Nav behavior functions
  function _toggleMobileNav() {
    if ( $('body').hasClass('-nav-open') ) {
      _hideMobileNav();
    } else {
      _showMobileNav();
    }
  }
  function _showMobileNav() {
    $('body')
      .addClass('-nav-open')
      .addClass('-nav-transition-permitted');// Allows CSS transitions on nav -- this is off by default to prevent unwanted transitions on screen resize
  }
  function _hideMobileNav() {
    $('body')
      .removeClass('-nav-open')
      .addClass('-nav-transition-permitted'); // Allows CSS transitions on nav -- this is off by default to prevent unwanted transitions on screen resize
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

  function _injectSvgSprite() {
    boomsvgloader.load('/app/themes/artandscience/assets/svgs/build/svgs-defs.svg');
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

    // Check breakpoint indicator in DOM ( :after { content } is controlled by CSS media queries )
    var breakpointIndicatorString = window.getComputedStyle(
      document.querySelector('#breakpoint-indicator'), ':after'
    ).getPropertyValue('content')
    .replace(/['"]+/g, '');

    breakpoint_lg = breakpointIndicatorString === 'lg';
    breakpoint_md = breakpointIndicatorString === 'md' || breakpoint_lg;
    breakpoint_sm = breakpointIndicatorString === 'sm' || breakpoint_md;
    breakpoint_xs = breakpointIndicatorString === 'xs' || breakpoint_sm;

    // Close the nav on resize and prevent transitions
    _hideMobileNav();
    // Avoid unwanted CSS transitions that result from change from mobile nav CSS to desktop nav CSS
    $('body').removeClass('-nav-transition-permitted'); 
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

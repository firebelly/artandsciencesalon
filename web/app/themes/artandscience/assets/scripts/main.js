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
    _initExperienceLevelsPopup();
    _initAccordianTable();
    _initStylistsSort();
    _initSubpageNav();
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
    // Inject SEO-useless nav toggler
    $('<button aria-hidden="true" class="menu-toggle"><svg class="icon icon-nav"><use xlink:href="#icon-nav"/></svg><svg class="icon icon-x"><use xlink:href="#icon-x"/></svg></button>')
      .prependTo('body');

    // Duplicate Secondary nav and inject into footer
    $('#menu-footer-nav')
      .clone()
      .prependTo('.site-footer')
      .wrap('<div class="footer-menu"></div>')
      .attr('id','#menu-footer-nav-duplicated');

    // Add interactivity to menu-toggle button
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

  function _initAccordianTable() {

    // JQuery selectors
    var $toggles = $('.accordian-table .accordian-toggle');
    var $drawers = $('.accordian-table .accordian-drawer');

    // Close the accordian from the getgo
    $drawers.velocity("slideUp", { duration: 0 });

    // Inject open/close indicator icon
    $toggles.each(function() {
      $('<svg class="icon icon-triangle"><use xlink:href="#icon-triangle"/></svg>')
      .prependTo(this);
    });

    // Add click functionality
    $toggles.click(function() {
      $toggle = $(this);
      $drawer = $(this).next();

      // Based on state: Add class -active and velocity slide open OR remove class and slide close
      if ($toggle.is('.-active')) {
        $toggle.removeClass('-active');
        $drawer.velocity("slideUp", { duration: 200 });
      } else {
        $toggle.addClass('-active');
        $drawer.velocity("slideDown", { duration: 200 });
      }
    });

  }

  function _initBookAppointment() {

    // JQuery selectors
    var $bAModule = $('#book-appointment');
    var $locationList = $bAModule.find('.location-list');

    // Close the accordian from the getgo
    $locationList.velocity("slideUp", { duration: 0 });

    // Open and close the accordian
    $bAModule.on('click', 'button', function() {

      // Based on state: Add class -active and velocity slide open OR remove class and slide close
      if ($bAModule.is('.-active')) {
        $bAModule.removeClass('-active');
        $locationList.velocity("slideUp", { duration: 200 });

      } else {
        $bAModule.addClass('-active');
        $locationList.velocity("slideDown", { duration: 200 });
      }
    });

    // Scroll variables
    var lastScrollTop = 0; // Used to house last scroll point to calculate scroll direction
    var scrollScore = 0; // Used to keep track of whether we've been scrolling in one direction for multiple scroll events
    var threshold = 10; // If scrollScore hits threshold or -threshold we trigger DOWN and UP scroll behaviors

    // Are we starting past the top of the page.  If so, we want the button look
    if ($(window).scrollTop() >= 30) {
      $bAModule.addClass('-button');
    }

    // On scroll
    $(window).scroll(function(e){

      // Get scroll pos
      var scrollTop = $(this).scrollTop();

      // OK.  So we don't want the hiding and showing to respond RAPIDLY to scroll events
      // We want to establish the user has scrolled enough to indicate intentional scrolling rather than a mouse jitter
      // So we're going to keep score.

      // If we scroll down add one point.  If we scroll up, subract 2.
      scrollScore += (scrollTop > lastScrollTop) ? 1 : -2;

      // Limit score to range [-threshold, threshold]
      scrollScore = Math.max(scrollScore, -threshold);
      scrollScore = Math.min(scrollScore, threshold);

      // The score is held at zero while the button is active
      if ( $bAModule.is('.-active') ) {
        scrollScore = 0;
      }

      // If we hit -threshold it means we've been scrolling UP for a while
      if ( scrollScore === -threshold ) {
        $bAModule.removeClass('-hide');
        $bAModule.addClass('-button');
      }

      // If we hit +threshold it means we've been scrolling DOWN for a while
      if ( scrollScore === threshold ) {
        $bAModule.addClass('-hide');
      }

      // Are we at the top of the page?
      if (scrollTop < 30) {
        $bAModule.removeClass('-button');
      }

      // Save current scroll position to reference next event
      lastScrollTop = scrollTop;
    });

  }

  function _initExperienceLevelsPopup() {
    $toggles.each(function() {
    $('<svg class="icon icon-triangle"><use xlink:href="#icon-triangle"/></svg>')
      $hosts.prependTo(this);
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

  function _initSubpageNav() {
    var $subPageNav = $('.subpage-nav');

    if ($subPageNav.length) {
      // Hide the careers section initially, except the first
      $('.subpage-nav li:eq(0)').find('a').addClass('-active');
      $('.subpage:eq(0)').addClass('-active');

      $('.subpage-nav a').on('click', function(e) {
        e.preventDefault();
        var target = $(this).attr('data-target'),
            $target = $('#'+target);

        $subPageNav.find('a.-active').not($(this)).removeClass('-active');

        // If it aint already active, make it so
        if (!$(this).is('.-active')) {
          $(this).addClass('-active');
          // Deactivate other active subpage
          $('.subpage.-active:not(#'+target+')').css('opacity', 0).removeClass('-active');
          $target.css('opacity', 0);
          $target.addClass('-active');
          _scrollBody($('.top-section'), 800);
          $target.css('opacity', 1);
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

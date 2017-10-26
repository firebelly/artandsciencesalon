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

  // Inject lazy-loading masks
  $('.lazy').each(function () {
    var $thumb = $(this);
    var preload_url = $(this).data('preload-src');
    $('<div class="load-mask"></div>')
      .prependTo($thumb)
      .attr('style',"background-image: url('"+preload_url+"');");
  });

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

    _initStickyNav();
    _hashHandling();
    _initLazyLoading();
    _initPersonPopup();
    _initImageViewerPopup();
    _initExperienceLevelsPopup();
    _initAccordianTable();
    _initStylistsSort();
    _initSubpageNav();
    _initNav();
    _initBookAppointment();
    _injectSvgSprite();
    _initBigclicky();
    _breakupLongEmails();
    _pullInstagramPost();
    _initToTop();

    // Certain elements (e.g. popups) are hidden during load, remove the class hiding them...
    $('.hide-during-page-load').removeClass('hide-during-page-load');

    // Key Handlers
    $(document).keyup(function(e) {

      // Esc
      if (e.keyCode === 27) {
        _hideMobileNav();
        _closeExperiencePopup();
        _imageViewerPopupClose();
        _closePersonPopup();
      }

      // Left
      if (e.keyCode === 37) {
        _switchPersonPopup('prev');
      }

      // Right
      if (e.keyCode === 39) {
        _switchPersonPopup('next');
      }
    });

    // Smoothscroll links
    $('a.smoothscroll').click(function(e) {
      e.preventDefault();
      var href = $(this).attr('href');
      _scrollBody($(href));
    });

  } // end init()

  function _initStickyNav() {

    $nav = $('.site-header');
    $nav.addClass('-fixed');

    console.log($nav[0].getBoundingClientRect().height);

    $('.site-top').waypoint({
      handler: function(direction) {
        if(direction==='up') {
          $nav.addClass('-fixed');
        }
        if(direction==='down'){
          $nav.removeClass('-fixed');
        }
      }, 
      offset: function() {
        var navHeight = $nav[0].getBoundingClientRect().height,
          topHalfHeight = this.adapter.outerHeight();
        return  navHeight - topHalfHeight;
      }
    });

  }

  // Grab most recent Instagram post with tag "behindthechair"
  function _pullInstagramPost() {
    if($('#instafeed').length) {

      // Creds;
      var clientId =  '87f02470c76449f187c33be623387c45', 
      accessToken = '429658804.87f0247.f3373e9bfed947b3a66e22daaf826c15'; 

      // CMS
      var instagramTag = $('#instafeed').data('tag');
      var instagramBackupUrl = $('#instafeed').data('backup-url');

      // Use this to indicate we found our image
      var foundImage = false;

      // Run instafeed
      var feed = new Instafeed({
        get: 'user',
        userId: '429658804',
        clientId: clientId,
        accessToken: accessToken,
        resolution: 'standard_resolution',
        template: '<div class="thumbnail lazy" style="background-image: url(\'{{image}}\');"></div>',
        // You can only specify one field for 'get' so we use a filter function to detect if the tag is there
        filter: function(image) {
          if (image.tags.indexOf(instagramTag) >= 0 && !foundImage) { // If we haven't found a match and the tag is present
            foundImage = true; // We found our match.  Don't accept any more.
            return true;
          }
          return false;
        },
        // Use backup image if none found
        after: function() {
          if(!foundImage) {
            $('<div class="thumbnail lazy" style="background-image: url(\''+instagramBackupUrl+'\');"></div>').prependTo('#instafeed');
          }
        },
        // Or in case of error
        error: function() {
          $('<div class="thumbnail lazy" style="background-image: url(\''+instagramBackupUrl+'\');"></div>').prependTo('#instafeed');
        },
      });
      feed.run();
    }
  }

  function _hashHandling() {
    // Scroll down to hash afer page load OR open person popup with hash content
    $(window).load(function() {
      if (window.location.hash) {

        // Find direct matches
        $hashMatches = $(window.location.hash);

        // Find matches a generic person (not tied to specific location), make $target first of these
        $personMatchesBySlug = $('[data-slug="'+window.location.hash.substr(1)+'"]');
        
        // Grab targets, prioritize exact match, then generic match (not that they should ever overlap)
        $targets = $hashMatches.length ? $hashMatches : $personMatchesBySlug;

        // If we have any sort of match...
        if($targets.length){

          // I know id's are supposed to be unique, but just to be safe...
          $target = $targets.first();

          // If target belongs subpage and it is not open, open it.
          var $subpage = $target.closest('.subpage:not(.-active)');
          if( $subpage.length ) {
            _openSubpage($subpage, false);
          }

          // If target is a person, open the popup
          if($target.hasClass('person')){
            // _scrollBody($('body'),0,0,0);
            setTimeout(function() {
              _openPersonPopup($target);
            },500);

          // Otherwise scroll to the target
          } else {
            // _scrollBody($('body'),0,0,0);
            _scrollBody($target);
          }
        }
      }
    });
  }

  function _initLazyLoading() {
    $('.lazy').Lazy({
        threshold: 3000,
        afterLoad: function($element) {
          $element.addClass('-loaded');

          // Remove the unncessary markup after its transition
          var $mask = $element.find('.load-mask');
          setTimeout(function () {
            $mask.remove();
          },500);
        }
    });
  }

  function _breakupLongEmails() {
    $('.breakup-email').each(function () {
      var email = $(this).text().split('@');
      if (email.length === 2) {
        var brokenEmail = '<span class="email-part">'+email[0]+'@</span><span class="email-part">'+email[1]+'</span>';
        $(this).empty().append(brokenEmail);
      }
    });
  }


  function _initPersonPopup() {

      // Add control buttons to popups
      $('<button class="prev-person-popup arrow"><svg class="icon icon-triangle"><use xlink:href="#icon-triangle"/></svg></button><button class="next-person-popup arrow"><svg class="icon icon-triangle"><use xlink:href="#icon-triangle"/></svg></button>')
        .prependTo('.person-popup .controls-wrap');
      $('<button class="close-person-popup"><span class="text">Close</span><svg class="icon icon-x"><use xlink:href="#icon-x"/></svg></button>')
        .prependTo('.person-popup');
       $('<div class="popup-mask"></div>')
        .prependTo('.site-main');

      // Hide popups
      $('.person-popup').velocity('fadeOut',{duration: 0});

      // Open button handling
      $('.open-person-popup').click(function (e) {
        e.preventDefault();
        $person = $(this).closest('.person');
        _openPersonPopup($person);
      });

      // Next button handling
      $('.next-person-popup').click(function () {
        _switchPersonPopup('next');
      });

      // Prev button handling
      $('.prev-person-popup').click(function () {
        _switchPersonPopup('prev');
      });

      // Close button handling
      $('.close-person-popup').click(function () {
        _closePersonPopup();
      });
  }

  function _openPersonPopup($person) {

    // Update the history (url bar)
    history.replaceState(null, null, '#'+$person.attr('id'));

    $('body').addClass('-person-popup-open');

    // Find the popup
    $popup = $person.find('.person-popup');

    // Give it -open class and fade in
    $popup
      .addClass('-open')
      .velocity('fadeIn', {duration: 200});

    // Hide contents
    $popup.find('.content-wrap')
      .velocity('slideUp',{duration: 0});
    $popup.find('.popup-wrap')
      .velocity({opacity: 0, translateY: '-30px'}, {duration: 0});

    // Header slides in
    $popup.find('.popup-wrap')
      .velocity({opacity: 1, translateY: '0px'}, {
        delay: 200,
        duration: 100,
        complete: function() {

          // Then contents drop down
          $popup.find('.content-wrap').velocity('slideDown',{duration: 300});
        }
      });
  }

  function _closePersonPopup() {

    // Find the open popup
    $popup = $('.person-popup.-open');

    $('body').removeClass('-person-popup-open');

    // If it exists...
    if($popup.length) {

      // Reset url
      history.replaceState(null, null, window.location.pathname);

      // Hide it and remove -open class
      $popup.removeClass('-open').velocity('fadeOut', {
        duration: 200
      });
    }
  }

  function _switchPersonPopup(nextOrPrev) {
    // Find the open popup
    $popup = $('.person-popup.-open');

    // If it exists...
    if($popup.length) {

      // Who am I?
      var $currentPerson = $popup.closest('.person');

      // Are we on a subpage? If so, grab all the people on that subpage,
      // If not on a subpage (like on "about"), grab everyone on the whole page
      var $currentSubpage = $popup.closest('.subpage');
      var $people;
      if ($currentSubpage.length) {
        $people = $currentSubpage.find('.person:not(.no-popup)');
      } else {
        $people = $('.person:not(.no-popup)');
      }

      // Where am I in the list?
      var currentIndex = $people.index($currentPerson);

      // Find the next or previous person, depending on nextOrPrev
      var nextIndex;
      if(nextOrPrev==='next') {
        nextIndex = (currentIndex + 1) % ($people.length);
      }
      if(nextOrPrev==='prev') {
        nextIndex = (currentIndex - 1) % ($people.length);
      }
      var $nextPerson = $($people.get(nextIndex));

      // The king is dead
      _closePersonPopup();

      // Long live the king
      _openPersonPopup($nextPerson);
    }
  }

  function _initImageViewerPopup() {

    // Hide the popup
    $('.image-viewer-popup').velocity('fadeOut', {duration: 0});

    // Inject close button into popup
    $('<button class="popup-close"><svg class="icon icon-popup-close"><use xlink:href="#icon-popup-close"/></svg></button>')
      .appendTo('.image-viewer-popup');

    // Image slider in popup
    $('.image-viewer-popup .image-slider').slick({
      infinite: true,
      dots: false,
      fade: true,
      speed: 100,
      prevArrow: '<button class="prev-image"><svg class="icon icon-triangle"><use xlink:href="#icon-triangle"/></svg></button>',
      nextArrow: '<button class="next-image"><svg class="icon icon-triangle"><use xlink:href="#icon-triangle"/></svg></button>',
    });

    // Clicking an image to open the slider
    $('.image-viewer-popup-open').click(function() {
      var imageUrl = $(this).data('image-url');
      var slideNum = parseInt($(this).data('slide'));
      $('.image-viewer-popup').velocity('fadeIn', {duration: 100});
      $('.image-viewer-popup .image-slider').slick('slickGoTo', slideNum );
    });

    // Close button
    $(document).on('click','.image-viewer-popup .popup-close', function () {
      _imageViewerPopupClose();
    });
  }

  function _imageViewerPopupClose() {
    $('.image-viewer-popup').velocity('fadeOut', {duration: 100});
  }

  function _scrollBody($element, duration, delay, offset) {

    if (typeof offset === 'undefined') {
      offset = 0;
    }

    if ($('#wpadminbar').length) {
      wpOffset = $('#wpadminbar').height();
    } else {
      wpOffset = 0;
    }
    $element.velocity("scroll", {
      duration: duration,
      delay: delay,
      offset: -wpOffset + offset
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

    // Duplicate Book Appointment module
    $('.book-appointment')
      .clone()
      .appendTo('body')
      .addClass('-duplicate');

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

    $drawers.velocity('slideUp', { duration: 0 });

    // Inject open/close indicator icon
    $toggles.each(function() {
      $('<svg class="icon icon-triangle"><use xlink:href="#icon-triangle"/></svg>')
      .prependTo(this);
    });

    // Add click functionality
    $toggles.click(function() {
      $toggle = $(this);
      $drawer = $(this).next();

      // Toggle open or closed based on current state
      if ($toggle.is('.-active')) {

        console.log('close');
        $toggle.removeClass('-active');
        $drawer.velocity('slideUp', {
          duration: 200,
          complete: function () {
            Waypoint.refreshAll();
          }
        });
      } else {
        console.log('open');
        $toggle.addClass('-active');
        $drawer.velocity('slideDown', {
          duration: 200,
          complete: function () {
            Waypoint.refreshAll();
          }
        });
      }
    });
  }

  function _initBookAppointment() {

    // JQuery selectors
    var $bAModule = $('.book-appointment');
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

    // Are we starting past the top of the page.  If so, we want the button look
    if ($(window).scrollTop() > 10) {
      $bAModule.filter('.-duplicate').addClass('-button');
    }
 
    // Scroll handling vars
    var lastKnownScrollPosition, scrollPosition;
    var ticking = false;

    // Throttle by animation frame
    window.addEventListener('scroll', function(e) {

      if (!ticking) {
        window.requestAnimationFrame(function() {
          scrollyChecks();
          ticking = false;
        });
        ticking = true;
      }
    });

    // Keep track of states of scrolly things
    var BAShowing = true;

    // The function that houses the checks (called from inside throttling function)
    function scrollyChecks() {

      // Scroll behaviors only happen on md and above
      if(breakpoint_md) {

        // Get scroll position
        scrollPosition = window.scrollY;

        // SCROLLING DOWN
        if ( scrollPosition > lastKnownScrollPosition ) {

          // Hide BA
          if(BAShowing) {
            $bAModule.addClass('-hide');
            BAShowing = false;

            // Slide up on hide if appropriate
            if ($bAModule.is('.-active')) {
              $bAModule.removeClass('-active');
              $locationList.velocity("slideUp", { duration: 200 });
            }
          }
        }

        // SCROLLING UP
        if ( scrollPosition < lastKnownScrollPosition ) {

          // Show BA
          if(!BAShowing) {
            $bAModule.removeClass('-hide');
            $bAModule.addClass('-button');
            BAShowing = true;
          }
        }

        lastKnownScrollPosition = scrollPosition;
      }
    }

    // Do the checks once at the outset
    scrollyChecks(); 
  }

  function _initExperienceLevelsPopup() {

    // Hide the original popup (we'll be cloning it to wherever it needs to go)
    var $experiencePopup = $('.experience-popup');
    $experiencePopup.velocity('slideUp', {duration: 0});

    // Inject popup open/close buttons where appropriate
    $('.experience-popup-location').each(function() {
      $('<button class="experience-popup-open"><svg class="icon icon-popup-open"><use xlink:href="#icon-popup-open"/></svg></button>').prependTo(this);
    });
    $('.experience-popup h2').each(function() {
      $('<button class="experience-popup-close"><svg class="icon icon-popup-close"><use xlink:href="#icon-popup-close"/></svg></button>').prependTo(this);
    });

    // Clicking open button...
    $(document).on('click','.experience-popup-open', function() {

      // Place the markup in container of .experience-popup-location
      var $popupLocation = $(this).closest('.experience-popup-location').parent();
      $experiencePopup.appendTo($popupLocation);

      // Open up
      $experiencePopup.velocity('slideDown', {duration: 200});
    });

    // Clicking close button...
    $(document).on('click','.experience-popup-close', function() {
      _closeExperiencePopup();
    });
  }

  function _closeExperiencePopup() {
   $('.experience-popup').velocity('slideUp', {duration: 200});
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

  function _initToTop() {

    // Inject popup open/close buttons where appropriate
    $('.to-top-location').each(function() {
      $('<button class="to-top"><span class="text">Back To Top </span><svg class="icon icon-triangle"><use xlink:href="#icon-triangle"/></svg></button>').appendTo(this);
    });

    // Clicking open button...
    $(document).on('click','.to-top', function() {
      _scrollBody($('.site-main'));
    });
  }

  function _initSubpageNav() {
    var $subPageNav = $('.subpage-nav');

    if ($subPageNav.length) {
      $('.subpage-nav .subpage-link').each(function() {

        // Select me and my target
        var $thisLink = $(this),
            target = $thisLink.attr('data-target'),
            $target = $('#'+target);

        // Click behavior
        $thisLink.on('click', function(e) {
          e.preventDefault();
          _openSubpage($target,true);
        }); // end click behavior
      });

      // Hide the subpage section navs
      $('.subpage-section-nav').velocity('slideUp', {duration: 0});

      // Open first page (dont scroll there)
      _openSubpage($('.subpage:eq(0)'),false);
    }
  }
  function _openSubpage($target,scrollToSubpage) {
    var $subPageNav = $('.subpage-nav');

    if ($subPageNav.length) {

      var target = $target.attr('id');

      $thisLink = $('.subpage-link[data-target="'+target+'"]');

      // Remove -active class where not needed
      $subPageNav.find('a.-active').not($thisLink).removeClass('-active');

      // If it aint already active, make it so
      if (!$thisLink.is('.-active')) {

        $thisLink.addClass('-active');

        // Deactivate and hide previously active subpage
        $('.subpage.-active:not(#'+target+')').css('opacity', 0).removeClass('-active');

        // Hide all subpage section navs
        $('.subpage-section-nav').velocity('slideUp', {duration: 0});

        // Fade in target, add active class, scroll to it (if specified)
        $target.css('opacity', 0);
        $target.addClass('-active');
        if(scrollToSubpage) {_scrollBody($('.top-section'), 800);}
        $target.css('opacity', 1);

        // Show suppage section nav for this page;
        $thisLink.next('.subpage-section-nav').velocity('slideDown', {duration: 300});
      }

      // Refresh waypoints as we've shifted elements a bunch
      Waypoint.refreshAll();
    }
  }

  function _initBigclicky() {
    // Bigclicky™
    $(document).on('click', '.bigclicky', function(e) {
      if (!$(e.target).is('a')) {
        e.preventDefault();
        var link = $(this).find('a:first');
        var href = link.attr('href');
        if (href) {
          if (e.metaKey || link.attr('target')) {
            window.open(href);
          } else {
            location.href = href;
          }
        }
      }
    });
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

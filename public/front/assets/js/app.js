
// HemaPulse interactions with jQuery
$(function(){
  const $window = $(window);
  const $body = $('body');
  const $header = $('.header, .landing-header');
  const $scrollTopBtn = $('.scrolltop');

  // Animate On Scroll (landing)
  if (window.AOS){
    AOS.init({duration:700, once:true, offset:80});
  }

  // Section scroll reveal
  const $reveal = $('.reveal');
  function update(){
    $reveal.each(function(){
      const top = this.getBoundingClientRect().top;
      if(top < window.innerHeight - 80){ $(this).addClass('visible'); }
    });
  }
  update();
  $window.on('scroll', update);

  // Sticky header + scroll to top visibility
  function handleScroll(){
    const scrolled = $window.scrollTop();
    if($header.length){ $header.toggleClass('scrolled', scrolled > 10); }
    if($scrollTopBtn.length){
      if(scrolled > 300){ $scrollTopBtn.fadeIn(200); }
      else{ $scrollTopBtn.fadeOut(200); }
    }
  }
  handleScroll();
  $window.on('scroll', handleScroll);

  $scrollTopBtn.on('click', function(e){
    e.preventDefault();
    $('html, body').animate({scrollTop:0}, 500);
  });

  // Smooth scroll for on-page anchors
  $('.navbar .nav-link[href^="#"], .footer a[href^="#"]').on('click', function(e){
    const target = $(this).attr('href');
    if(target && target.startsWith('#') && $(target).length){
      e.preventDefault();
      $('html, body').animate({scrollTop: $(target).offset().top - 72}, 500);
    }
  });
  $('.navbar .nav-link[data-anchor]').on('click', function(e){
    const anchor = $(this).data('anchor');
    if($body.hasClass('landing-page') && anchor && $(anchor).length){
      e.preventDefault();
      $('html, body').animate({scrollTop: $(anchor).offset().top - 72}, 500);
    }
  });

  // Landing page active menu tracking (only for anchor links, not page navigation)
  if($body.hasClass('landing-page')){
    const $sections = $('section[id]');
    const $anchorNavLinks = $('.navbar .nav-link[href^="#"], .navbar .nav-link[data-anchor]');
    // Only run scroll tracking if there are anchor-based nav links
    if($anchorNavLinks.length){
      function highlightNav(){
        let current = '';
        const scrollPos = $window.scrollTop() + 120;
        $sections.each(function(){
          const $section = $(this);
          if(scrollPos >= $section.offset().top){ current = $section.attr('id'); }
        });
        // Only remove active from anchor links, not from page nav links with IDs
        $anchorNavLinks.removeClass('active');
        if(current){
          $('.navbar .nav-link[href="#'+current+'"], .navbar .nav-link[data-anchor="#'+current+'"]').addClass('active');
        }
      }
      highlightNav();
      $window.on('scroll', highlightNav);
    }
  }

  // Slick sliders on landing page
  if($.fn && $.fn.slick){
    const $categorySlider = $('.category-slider');
    if($categorySlider.length){
      $categorySlider.not('.slick-initialized').slick({
        slidesToShow:3,
        slidesToScroll:1,
        dots:false,
        arrows:false,
        autoplay:true,
        autoplaySpeed:3200,
        pauseOnHover:false,
        responsive:[
          {breakpoint:992, settings:{slidesToShow:2}},
          {breakpoint:576, settings:{slidesToShow:1}}
        ]
      });
      $('.js-category-prev').on('click', function(e){
        e.preventDefault();
        $categorySlider.slick('slickPrev');
      });
      $('.js-category-next').on('click', function(e){
        e.preventDefault();
        $categorySlider.slick('slickNext');
      });
    }

    const $productSlider = $('.product-slider');
    if($productSlider.length){
      $productSlider.not('.slick-initialized').slick({
        slidesToShow:3,
        slidesToScroll:1,
        dots:false,
        arrows:false,
        autoplay:true,
        autoplaySpeed:2600,
        pauseOnHover:false,
        responsive:[
          {breakpoint:1200, settings:{slidesToShow:3}},
          {breakpoint:992, settings:{slidesToShow:2}},
          {breakpoint:576, settings:{slidesToShow:1}}
        ]
      });
      $('.js-product-prev').on('click', function(e){
        e.preventDefault();
        $productSlider.slick('slickPrev');
      });
      $('.js-product-next').on('click', function(e){
        e.preventDefault();
        $productSlider.slick('slickNext');
      });
    }
  }

  // Qty controls
  $('.qty-decrease').on('click', function(){
    const $inp = $(this).closest('.product-qty').find('input');
    const v = Math.max(1, parseInt($inp.val(),10)-1);
    $inp.val(v);
  });
  $('.qty-increase').on('click', function(){
    const $inp = $(this).closest('.product-qty').find('input');
    const v = parseInt($inp.val(),10)+1;
    $inp.val(v);
  });

  // Fake complete order -> success modal
  $('#completeOrder').on('click', function(e){
    e.preventDefault();
    const modal = new bootstrap.Modal(document.getElementById('successModal'));
    modal.show();
  });

  // Product detail thumbnails to hero image
  $(document).on('click', '.hp-thumb', function(){
    const src = $(this).attr('src');
    $('#pd-main').attr('src', src);
  });

  // Optional data-target switcher (supporting legacy preview toggles)
  $(document).on('click', '.hp-link[data-target], .hp-switcher [data-target], .navbar .nav-link[data-target]', function(e){
    const target = $(this).data('target');
    if(!target || !$(target).length){ return; }
    e.preventDefault();
    $('.hp-page').removeClass('active');
    $(target).addClass('active');
    $('.navbar .nav-link').removeClass('active');
    $('.navbar .nav-link[data-target="'+target+'"]').addClass('active');
    window.scrollTo({top:0, behavior:'smooth'});
  });
});

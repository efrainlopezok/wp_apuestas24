jQuery(document).ready(function($){

  // $(function(){
  //   var shrinkHeader = 10;
  //   $(window).scroll(function() {
  //     var scroll = getCurrentScroll();
  //       if ( scroll >= shrinkHeader ) {
  //            $('.header').addClass('small-header');
  //         }
  //         else {
  //             $('.header').removeClass('small-header');
  //         }
  //   });
  //
  // function getCurrentScroll() {
  //     return window.pageYOffset || document.documentElement.scrollTop;
  //     }
  // });
  //
  //   $('.clickScroll').click(function() {
  //   if(location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')&& location.hostname == this.hostname) {
  //       var $target = $(this.hash);
  //       $target = $target.length && $target || $('[name=' + this.hash.slice(1) +']');
  //       if ($target.length) {
  //       var targetOffset = $target.offset().top - 100;
  //       $('html,body').animate({scrollTop: targetOffset}, 1000);
  //       return false;
  //       }
  //     }
  //   });



    $(".tnp-email").attr("placeholder", "Ingrese su email");

  $('.row-grid').children('.column-2:last-child').addClass('last-child');
  $('.row-grid').children('.column-2:first-child').addClass('first-child');

  /* CUSTOM SCRIPT */

  $('.wpcf7_control_wrap input, .wpcf7_control_wrap textarea, .wpcf7_control_wrap select').focusin(function() {
    $(this).parent().parent().addClass('active');
  });

  $('.wpcf7_control_wrap input, .wpcf7_control_wrap textarea, .wpcf7_control_wrap select').focusout(function() {
    if ($(this).val() === "") {
      $(this).parent().parent().removeClass('active');
    };
  });

  $('.wpcf7_control_wrap input, .wpcf7_control_wrap textarea, .wpcf7_control_wrap select').each(function() {
    if ($(this).val() != "") {
      $(this).parent().parent().removeClass('active');
    };
  });

  $('.wpcf7_control_wrap input').change(function(){
    if($('.wpcf7_control_wrap input, .wpcf7_control_wrap textarea').val().length > 1) {
      $(this).parent().parent().toggleClass('refull');
    }
  });

  $('#menu-main-menu').clone().appendTo('.content_menu_responsive');
  /**
   * Fix New Search in Mobile
   */
  $('.content_menu_responsive #searchform').parent().remove();
  $('.social_media_footer').clone().appendTo('.content_menu_responsive').addClass('social_media_responsive');

  $('.btn_service_service').clone().appendTo('.content_btn_service_responsive');
  $('.image_desktop_content_team').clone().appendTo('.content_image_responsive_team').addClass('image_responsive_content_team');
  $('.image_featured_service').clone().appendTo('.content_image_staff_responsive').addClass('image_responsive_content_staff');


  $( ".menu_open" ).click(function() {
    $('body').addClass('open__menu__responsive');
    $('#wrapper_site').addClass( "nav__open" );
    $("#sidenav_menu").addClass( "load__layer__responsive" );
  });

  $( ".menu_close, .overlay_menu_responsive" ).click(function() {
    $('body').removeClass('open__menu__responsive');
    $('#wrapper_site').removeClass('nav__open')
    $("#sidenav_menu").removeClass( "load__layer__responsive" );
  });

  //- pop-up-manual
  $('.trabaja__nosotros--pitcher').click(function(event) {
    event.preventDefault();
    $('.trabaja__nosotros__wrap').addClass('active');
    $('body').addClass('active');
  });

  $('.trabaja__nosotros__pop__up__close, .trabaja__nosotros__overlay').click(function(event) {
    event.preventDefault();
    $('.trabaja__nosotros__wrap').removeClass('active');
    $('body').removeClass('active');
  });

  $('.adp_content iframe').wrap('<div class="videoWrapper"></div>');

});
